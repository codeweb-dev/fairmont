<?php

namespace App\Livewire\Unit;

use Livewire\WithoutUrlPagination;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Voyage;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CrewMonitoringPlanExport;
use App\Exports\CrewMonitoringPlanReportsByDateExport;
use Illuminate\Support\Carbon;
use ZipArchive;
use Illuminate\Support\Facades\Log;

#[Title('Crew Monitoring Plan Report On Board Crew')]
class TableOnBoardCrew extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $search = '';
    public $perPage = 10;
    public $pages = [10, 20, 30, 40, 50];
    public $selectedOnBoard = [];
    public $selectedCrewChange = [];
    public $selectAll = false;

    public string $viewing = 'on-board'; // Default viewing type

    public $dateRange;

    protected $paginationTheme = 'tailwind';

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function updatedViewing($value)
    {
        $this->resetPage();

        $this->selectAll = false;
        $this->search = '';

        if ($value === 'on-board') {
            $this->selectedOnBoard = array_filter($this->selectedOnBoard, function ($id) {
                return Voyage::whereHas('board_crew')->where('id', $id)->exists();
            });
            $this->selectedCrewChange = [];
        } else {
            $this->selectedCrewChange = array_filter($this->selectedCrewChange, function ($id) {
                return Voyage::whereHas('crew_change')->where('id', $id)->exists();
            });
            $this->selectedOnBoard = [];
        }
    }

    public function getSelectedReportsProperty()
    {
        return $this->viewing === 'on-board'
            ? $this->selectedOnBoard
            : $this->selectedCrewChange;
    }


    public function updatingSearch()
    {
        $this->resetPage();
        $this->selectedOnBoard = [];
        $this->selectedCrewChange = [];
        $this->selectAll = false;
    }

    public function updatedSelectAll($value)
    {
        $ids = $this->getReportsQuery()->pluck('id')->toArray();

        if ($value) {
            if ($this->viewing === 'on-board') {
                $this->selectedOnBoard = $ids;
            } else {
                $this->selectedCrewChange = $ids;
            }
        } else {
            if ($this->viewing === 'on-board') {
                $this->selectedOnBoard = [];
            } else {
                $this->selectedCrewChange = [];
            }
        }
    }

    public function updatedSelectedOnBoard()
    {
        $this->syncSelectAllState();
    }

    public function updatedSelectedCrewChange()
    {
        $this->syncSelectAllState();
    }

    private function syncSelectAllState()
    {
        $visible = $this->getReportsQuery()->pluck('id')->toArray();
        $selected = $this->selectedReports;
        $this->selectAll = count($selected) === count($visible);
    }

    private function getReportsQuery()
    {
        $assignedVesselIds = Auth::user()->vessels()->pluck('vessels.id');

        return Voyage::with(['unit', 'vessel', 'board_crew', 'crew_change', 'remarks', 'master_info'])
            ->where('report_type', 'Crew Monitoring Plan')
            ->whereIn('vessel_id', $assignedVesselIds)
            ->when($this->viewing === 'crew-change', fn($q) => $q->whereHas('crew_change'))
            ->when($this->viewing === 'on-board', fn($q) => $q->whereHas('board_crew'))
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->whereHas('unit', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    })
                        ->orWhereHas('vessel', function ($q) {
                            $q->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->dateRange, function ($query) {
                $dates = explode(' to ', $this->dateRange);

                if (count($dates) === 2) {
                    [$start, $end] = $dates;
                    return $query->whereBetween('created_at', [
                        \Carbon\Carbon::parse($start)->startOfDay(),
                        \Carbon\Carbon::parse($end)->endOfDay(),
                    ]);
                }

                return $query;
            })
            ->latest();
    }

    public function updatedDateRange()
    {
        if (!$this->dateRange) {
            // When cleared, reset both selections and pagination
            $this->selectedOnBoard = [];
            $this->selectedCrewChange = [];
            $this->selectAll = false;
            $this->resetPage();
        } else {
            // Auto-select filtered reports for the current view
            $reportIds = $this->getReportsQuery()->pluck('id')->toArray();

            if ($this->viewing === 'on-board') {
                $this->selectedOnBoard = $reportIds;
            } else {
                $this->selectedCrewChange = $reportIds;
            }

            $this->selectAll = count($reportIds) > 0;
        }
    }


    public function exportByDateRange()
    {
        if (!$this->dateRange) {
            Toaster::error('Please select a valid date range to export.');
            return;
        }

        $dates = explode(' to ', $this->dateRange);
        $start = trim($dates[0] ?? '');
        $end = trim($dates[1] ?? '');

        $startDate = $start ? Carbon::parse($start)->startOfDay() : null;
        $endDate = $end ? Carbon::parse($end)->endOfDay() : null;

        if (!$startDate && !$endDate) {
            Toaster::error('Please select at least a start or end date.');
            return;
        }

        $reportQuery = $this->getReportsQuery();

        if ($startDate && $endDate) {
            $reportQuery->whereBetween('created_at', [$startDate, $endDate]);
        } elseif ($startDate) {
            $reportQuery->where('created_at', '>=', $startDate);
        } elseif ($endDate) {
            $reportQuery->where('created_at', '<=', $endDate);
        }

        $reportCount = $reportQuery->count();
        if ($reportCount === 0) {
            Toaster::error('No reports found for the selected date range.');
            return;
        }

        $firstReport = $reportQuery->with('vessel')->first();

        $reportType = 'crew_monitoring_plan_report';
        $vesselName = $firstReport && $firstReport->vessel ? $firstReport->vessel->name : 'Vessel';

        if ($startDate && $endDate && $startDate->isSameDay($endDate)) {
            $date = $startDate->format('Y-m-d');
            $filename = "{$reportType}_{$vesselName}_{$date}.xlsx";
        } else {
            $from = $startDate ? $startDate->format('Y-m-d') : 'Start';
            $to = $endDate ? $endDate->format('Y-m-d') : 'End';
            $filename = "{$reportType}_{$vesselName}_{$from}_{$to}.xlsx";
        }

        Toaster::success('Reports exported by date range.');
        $this->selectedOnBoard = [];
        $this->selectedCrewChange = [];
        $this->selectAll = false;
        $this->dateRange = null;

        return Excel::download(
            new CrewMonitoringPlanReportsByDateExport($startDate, $endDate, $this->viewing),
            $filename
        );
    }

    private function resetSelections(): void
    {
        $this->selectedOnBoard = [];
        $this->selectedCrewChange = [];
        $this->selectAll = false;
        $this->dateRange = null;
    }

    public function exportSelected()
    {
        if (empty($this->selectedReports)) {
            Toaster::error('Please select at least one report to export.');
            return;
        }

        if (count($this->selectedReports) === 1) {
            $reportId = $this->selectedReports[0];
            $report = Voyage::with(['unit', 'vessel', 'board_crew', 'crew_change', 'remarks', 'master_info'])->find($reportId);

            if ($this->viewing === 'on-board' && $report->board_crew->isEmpty()) {
                Toaster::error('Selected report has no on-board crew data.');
                return;
            }

            if ($this->viewing === 'crew-change' && $report->crew_change->isEmpty()) {
                Toaster::error('Selected report has no crew change data.');
                return;
            }

            $vesselName = $report->vessel?->name ?? 'Vessel';
            $reportDate = Carbon::parse($report->created_at)->timezone('Asia/Manila')->format('Y-m-d');
            $reportType = $this->viewing === 'on-board' ? 'on_board_crew' : 'crew_change';

            $filename = "{$reportType}_{$vesselName}_crew_monitoring_plan_report_{$reportDate}.xlsx";
            $this->resetSelections();

            try {
                Toaster::success('Report exported successfully.');
                return Excel::download(new CrewMonitoringPlanExport([$reportId], $this->viewing), $filename);
            } catch (\Exception $e) {
                Toaster::error($e->getMessage());
                return;
            }
        }

        return $this->exportMultipleReports();
    }

    private function exportMultipleReports()
    {
        $tempDir = storage_path('app/temp/exports');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $firstReport = Voyage::with('vessel')->find($this->selectedReports[0]);

        $reportType = $this->viewing === 'on-board' ? 'on_board_crew' : 'crew_change';
        $vesselNameRaw = $firstReport->vessel->name ?? 'Vessel';
        $vesselName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $vesselNameRaw);
        $reportDate = Carbon::parse($firstReport->created_at)->timezone('Asia/Manila')->format('Y-m-d');

        $zipFileName = "{$reportType}_{$vesselName}_crew_monitoring_plan_report_{$reportDate}.zip";
        $zipPath = "{$tempDir}/{$zipFileName}";

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            Toaster::error('Unable to create ZIP file.');
            return;
        }

        $filenameCounts = [];
        foreach ($this->selectedReports as $reportId) {
            $report = Voyage::with(['unit', 'vessel', 'board_crew', 'crew_change'])->find($reportId);

            if (!$report) {
                Log::warning("Skipping missing report ID: $reportId");
                continue;
            }

            $vesselNameRaw = $report->vessel->name ?? 'Vessel';
            $vesselName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $vesselNameRaw);
            $reportDate = Carbon::parse($report->created_at)->timezone('Asia/Manila')->format('Y-m-d');
            $reportType = $this->viewing === 'on-board' ? 'on_board_crew' : 'crew_change';

            $baseFilename = "{$reportType}_{$vesselName}_crew_monitoring_plan_report_{$reportDate}";

            $filenameCounts[$baseFilename] = ($filenameCounts[$baseFilename] ?? 0) + 1;
            $suffix = $filenameCounts[$baseFilename] > 1 ? '_' . $filenameCounts[$baseFilename] : '';
            $filename = "{$baseFilename}{$suffix}.xlsx";

            $excelContent = Excel::raw(
                new CrewMonitoringPlanExport([$reportId], $this->viewing),
                \Maatwebsite\Excel\Excel::XLSX
            );

            if ($excelContent) {
                $zip->addFromString($filename, $excelContent);
            } else {
                Log::error("Failed to generate Excel content for report ID: $reportId");
            }
        }

        $zip->close();

        Toaster::success("Reports exported successfully.");
        $this->resetSelections();

        return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
    }

    public function render()
    {
        $reports = $this->getReportsQuery()->paginate($this->perPage);

        return view('livewire.unit.table-on-board-crew', [
            'reports' => $reports,
            'pages' => $this->pages,
            'viewing' => $this->viewing,
        ]);
    }
}
