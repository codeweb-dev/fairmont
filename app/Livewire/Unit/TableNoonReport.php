<?php

namespace App\Livewire\Unit;

use App\Exports\NoonReportsByDateExport;
use Livewire\WithoutUrlPagination;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Voyage;
use Illuminate\Support\Facades\Auth;
use App\Exports\NoonReportsExport;
use Illuminate\Support\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;

#[Title('Noon Report')]
class TableNoonReport extends Component
{
    use WithPagination, WithoutUrlPagination;

    protected $paginationTheme = 'tailwind';

    public $search = '';
    public $perPage = 10;
    public $pages = [10, 20, 30, 40, 50];
    public $selectedReports = [];
    public $selectAll = false;

    public $dateRange;

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
        $this->selectedReports = [];
        $this->selectAll = false;
    }

    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selectedReports = $this->getReportsQuery()->pluck('id')->toArray();
        } else {
            $this->selectedReports = [];
        }
    }

    public function updatedSelectedReports()
    {
        $totalReports = $this->getReportsQuery()->count();
        $this->selectAll = count($this->selectedReports) === $totalReports;
    }

    private function getReportsQuery()
    {
        $assignedVesselIds = Auth::user()->vessels()->pluck('vessels.id');

        return Voyage::with(['vessel', 'unit', 'rob_tanks', 'rob_fuel_reports', 'noon_report', 'remarks', 'master_info', 'weather_observations'])
            ->where('report_type', 'Noon Report')
            ->whereIn('vessel_id', $assignedVesselIds)
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('voyage_no', 'like', '%' . $this->search . '%')
                        ->orWhere('port_gmt_offset', 'like', '%' . $this->search . '%')
                        ->orWhereHas('unit', function ($q) {
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
            // When cleared, reset selection and page
            $this->selectedReports = [];
            $this->selectAll = false;
            $this->resetPage();
        } else {
            // When set, auto-select filtered reports
            $reportIds = $this->getReportsQuery()->pluck('id')->toArray();
            $this->selectedReports = $reportIds;
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

        $reportType = 'noon_report';
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
        $this->selectedReports = [];
        $this->selectAll = false;
        $this->dateRange = null;

        return Excel::download(
            new NoonReportsByDateExport($startDate, $endDate),
            $filename
        );
    }

    public function exportSelected()
    {
        if (empty($this->selectedReports)) {
            Toaster::error('Please select at least one report to export.');
            return;
        }

        if (count($this->selectedReports) === 1) {
            $reportId = $this->selectedReports[0];
            $report = Voyage::with(['vessel', 'unit', 'rob_tanks', 'rob_fuel_reports', 'noon_report', 'remarks', 'master_info', 'weather_observations'])->find($reportId);

            if (!$report) {
                Toaster::error('Report not found.');
                return;
            }

            // $filename = 'noon_report_' . $report->vessel->name . '_' . $report->voyage_no . '_' . now()->format('Y-m-d_H-i-s') . '.xlsx';
            $filename = 'noon_report_' . $report->vessel->name . '_' . Carbon::parse($report->created_at)->timezone('Asia/Manila')->format('Y-m-d') . '_' . '.xlsx';

            Toaster::success('Report exported successfully.');
            $this->selectedReports = [];
            $this->selectAll = false;
            $this->dateRange = null;

            return Excel::download(new NoonReportsExport([$reportId]), $filename);
        } else {
            return $this->exportMultipleReports();
        }
    }

    private function exportMultipleReports()
    {
        $tempDir = storage_path('app/temp/exports');
        if (!file_exists($tempDir)) {
            mkdir($tempDir, 0755, true);
        }

        $zipFileName = 'noon-report_reports_export_' . now()->format('Y-m-d_H-i-s') . '.zip';
        $zipPath = $tempDir . '/' . $zipFileName;

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            Toaster::error('Unable to create ZIP file.');
            return;
        }

        foreach ($this->selectedReports as $reportId) {
            $report = Voyage::with(['vessel', 'unit', 'rob_tanks', 'rob_fuel_reports', 'noon_report', 'remarks', 'master_info', 'weather_observations'])->find($reportId);

            if ($report) {
                $vesselName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $report->vessel->name);
                $voyageNo = preg_replace('/[^A-Za-z0-9_\-]/', '_', $report->voyage_no);
                $filename = 'noon_report_' . $vesselName . '_' . $voyageNo . '.xlsx';

                $excelContent = Excel::raw(new NoonReportsExport([$reportId]), \Maatwebsite\Excel\Excel::XLSX);
                $zip->addFromString($filename, $excelContent);
            }
        }

        $zip->close();
        Toaster::success('Reports exported successfully.');
        $this->selectedReports = [];
        $this->selectAll = false;
        $this->dateRange = null;

        return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
    }

    public function render()
    {
        $reports = $this->getReportsQuery()->paginate($this->perPage);

        return view('livewire.unit.table-noon-report', [
            'reports' => $reports,
            'pages' => $this->pages,
        ]);
    }
}
