<?php

namespace App\Livewire\Unit;

use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Voyage;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\CrewMonitoringPlanExport;
use App\Exports\CrewMonitoringPlanReportsByDateExport;
use App\Models\Notification;
use Illuminate\Support\Carbon;
use Flux\Flux;
use ZipArchive;

#[Title('Crew Monitoring Plan Report On Board Crew')]
class TableOnBoardCrew extends Component
{
    use WithPagination;

    public $dateRange;
    public $search = '';
    public $perPage = 10;
    public $pages = [10, 20, 30, 40, 50];
    public $selectedOnBoard = [];
    public $selectAll = false;
    public $currentPage = 1;

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
        $this->selectedOnBoard = [];
        $this->selectAll = false;
    }

    public function updatedSelectAll($value)
    {
        $currentPageIds = $this->getReportsQuery()
            ->paginate($this->perPage, ['*'], 'page', $this->currentPage)
            ->pluck('id')
            ->toArray();

        $this->selectedOnBoard = $value ? $currentPageIds : [];
    }

    public function updatedSelectedOnBoard()
    {
        $currentPageIds = $this->getReportsQuery()
            ->paginate($this->perPage, ['*'], 'page', $this->currentPage)
            ->pluck('id')
            ->toArray();

        $this->selectAll = count(array_intersect($currentPageIds, $this->selectedOnBoard)) === count($currentPageIds);
    }

    private function getReportsQuery()
    {
        $assignedVesselIds = Auth::user()->vessels()->pluck('vessels.id');

        return Voyage::with(['unit', 'vessel', 'board_crew', 'remarks', 'master_info'])
            ->where('report_type', 'Crew Monitoring Plan')
            ->whereIn('vessel_id', $assignedVesselIds)
            ->whereHas('board_crew')
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->whereHas('unit', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    })->orWhereHas('vessel', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
                });
            })
            ->when($this->dateRange, function ($query) {
                $dates = explode(' to ', $this->dateRange);
                if (count($dates) === 2) {
                    [$start, $end] = $dates;
                    return $query->whereBetween('created_at', [
                        Carbon::parse($start)->startOfDay(),
                        Carbon::parse($end)->endOfDay(),
                    ]);
                }
                return $query;
            })
            ->latest();
    }

    public function updatedDateRange()
    {
        $this->resetPage();

        if ($this->dateRange) {
            $currentPageReports = $this->getReportsQuery()
                ->paginate($this->perPage, ['*'], 'page', $this->currentPage);

            $this->selectedOnBoard = $currentPageReports->pluck('id')->toArray();
            $this->selectAll = count($currentPageReports) > 0
                && count($this->selectedOnBoard) === $currentPageReports->count();
        } else {
            $this->selectedOnBoard = [];
            $this->selectAll = false;
        }
    }

    public function exportByDateRange()
    {
        if (!$this->dateRange) {
            Toaster::error('Please select a valid date range to export.');
            return;
        }

        $dates = explode(' to ', $this->dateRange);
        $startDate = isset($dates[0]) ? Carbon::parse($dates[0])->startOfDay() : null;
        $endDate = isset($dates[1]) ? Carbon::parse($dates[1])->endOfDay() : null;

        $reportQuery = $this->getReportsQuery();

        $reportCount = $reportQuery->count();
        if ($reportCount === 0) {
            Toaster::error('No reports found for the selected date range.');
            return;
        }

        $firstReport = $reportQuery->with('vessel')->first();
        $vesselName = $firstReport->vessel?->name ?? 'Vessel';
        $filename = "on_board_crew_{$vesselName}_crew_monitoring_plan_report.xlsx";

        $this->resetSelections();
        Toaster::success('Reports exported by date range.');

        return Excel::download(
            new CrewMonitoringPlanReportsByDateExport($startDate, $endDate, 'on-board'),
            $filename
        );
    }

    public function exportSelected()
    {
        if (empty($this->selectedOnBoard)) {
            Toaster::error('Please select at least one report to export.');
            return;
        }

        if (count($this->selectedOnBoard) === 1) {
            $reportId = $this->selectedOnBoard[0];
            $report = Voyage::with(['unit', 'vessel', 'board_crew', 'remarks', 'master_info'])->find($reportId);

            if ($report->board_crew->isEmpty()) {
                Toaster::error('Selected report has no on-board crew data.');
                return;
            }

            $vesselName = $report->vessel?->name ?? 'Vessel';
            $reportDate = Carbon::parse($report->created_at)->format('Y-m-d');
            $filename = "on_board_crew_{$vesselName}_crew_monitoring_plan_report_{$reportDate}.xlsx";

            $this->resetSelections();
            Toaster::success('Report exported successfully.');

            return Excel::download(new CrewMonitoringPlanExport([$reportId], 'on-board'), $filename);
        }

        return $this->exportMultipleReports();
    }

    private function exportMultipleReports()
    {
        $tempDir = storage_path('app/temp/exports');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $firstReport = Voyage::with('vessel')->find($this->selectedOnBoard[0]);
        $vesselName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $firstReport->vessel->name ?? 'Vessel');
        $reportDate = Carbon::parse($firstReport->created_at)->format('Y-m-d');
        $zipFileName = "on_board_crew_{$vesselName}_crew_monitoring_plan_report_{$reportDate}.zip";
        $zipPath = "{$tempDir}/{$zipFileName}";

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            Toaster::error('Unable to create ZIP file.');
            return;
        }

        $filenameCounts = []; // Track duplicates
        foreach ($this->selectedOnBoard as $reportId) {
            $report = Voyage::with(['unit', 'vessel', 'board_crew'])->find($reportId);
            if (!$report) continue;

            $vesselNameSafe = preg_replace('/[^A-Za-z0-9_\-]/', '_', $report->vessel->name ?? 'Vessel');
            $reportDate = Carbon::parse($report->created_at)->format('Y-m-d');
            $baseFilename = "on_board_crew_{$vesselNameSafe}_crew_monitoring_plan_report_{$reportDate}";

            // Increment suffix if file already exists
            if (!isset($filenameCounts[$baseFilename])) {
                $filenameCounts[$baseFilename] = 1;
            } else {
                $filenameCounts[$baseFilename]++;
            }

            $suffix = $filenameCounts[$baseFilename] > 1 ? '_' . $filenameCounts[$baseFilename] : '';
            $filename = $baseFilename . $suffix . '.xlsx';

            $excelContent = Excel::raw(
                new CrewMonitoringPlanExport([$reportId], 'on-board'),
                \Maatwebsite\Excel\Excel::XLSX
            );

            if ($excelContent) {
                $zip->addFromString($filename, $excelContent);
            }
        }

        $zip->close();
        $this->resetSelections();
        Toaster::success("Reports exported successfully.");

        return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
    }

    public function delete($id)
    {
        $voyage = Voyage::findOrFail($id);
        $voyage->delete();

        Notification::create([
            'vessel_id' => $voyage->vessel_id,
            'text'      => "{$voyage->report_type} report has been soft deleted.",
        ]);

        Toaster::success('Crew Monitoring Plan Report soft deleted successfully.');
        Flux::modal('delete-report-' . $id)->close();
    }

    private function resetSelections(): void
    {
        $this->selectedOnBoard = [];
        $this->selectAll = false;
        $this->dateRange = null;
    }

    public function updatedCurrentPage($value)
    {
        if ($value < 1) $this->currentPage = 1;
        elseif ($value > $this->getMaxPage()) $this->currentPage = $this->getMaxPage();
    }

    private function getMaxPage()
    {
        $query = $this->getReportsQuery();
        return ceil($query->count() / $this->perPage);
    }

    public function render()
    {
        $reports = $this->getReportsQuery()->paginate($this->perPage, ['*'], 'page', $this->currentPage);

        return view('livewire.unit.table-on-board-crew', [
            'reports' => $reports,
            'pages' => $this->pages,
        ]);
    }
}
