<?php

namespace App\Livewire\Officer;

use Livewire\WithoutUrlPagination;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Voyage;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KpiReportsExport;
use App\Exports\KpiReportsByDateExport;
use Illuminate\Support\Carbon;
use ZipArchive;

#[Title('KPI Report')]
class KpiReport extends Component
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

        return Voyage::with([
            'vessel',
            'unit',
            'waste',
            'remarks',
            'master_info',
        ])
            ->where('report_type', 'KPI')
            ->whereIn('vessel_id', $assignedVesselIds)
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

        // Check if both start and end dates are present
        $dates = explode(' to ', $this->dateRange);

        if (count($dates) !== 2 || empty($dates[0]) || empty($dates[1])) {
            Toaster::error('Please select a full date range with both start and end dates.');
            $this->dateRange = null;
            return;
        }

        [$start, $end] = $dates;
        $startDate = Carbon::parse($start)->startOfDay();
        $endDate = Carbon::parse($end)->endOfDay();

        $filename = 'kpi_reports_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        Toaster::success('Reports exported by date range.');
        $this->selectedReports = [];
        $this->selectAll = false;
        $this->dateRange = null;

        return Excel::download(
            new KpiReportsByDateExport($startDate, $endDate),
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
            $report = Voyage::with([
                'vessel',
                'unit',
                'waste',
                'remarks',
                'master_info',
            ])->find($reportId);

            if (!$report) {
                Toaster::error('Report not found.');
                return;
            }

            $filename = 'kpi_report_' . $report->vessel->name . '_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

            Toaster::success('Report exported successfully.');
            $this->selectedReports = [];
            $this->selectAll = false;
            $this->dateRange = null;

            return Excel::download(new KpiReportsExport([$reportId]), $filename);
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

        $zipFileName = 'kpi_reports_export_' . now()->format('Y-m-d_H-i-s') . '.zip';
        $zipPath = $tempDir . '/' . $zipFileName;

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            Toaster::error('Unable to create ZIP file.');
            return;
        }

        $filenameCount = [];

        foreach ($this->selectedReports as $index => $reportId) {
            $report = Voyage::with([
                'vessel',
                'unit',
                'waste',
                'remarks',
                'master_info',
            ])->find($reportId);

            if ($report) {
                $vesselName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $report->vessel->name ?? 'unknown');

                $baseFilename = 'kpi_report_' . $vesselName;

                $filename = $baseFilename . '.xlsx';
                if (isset($filenameCount[$filename])) {
                    $filenameCount[$filename]++;
                    $filename = $baseFilename . '_' . $filenameCount[$filename] . '.xlsx';
                } else {
                    $filenameCount[$filename] = 1;
                }

                $excelContent = Excel::raw(new KpiReportsExport([$reportId]), \Maatwebsite\Excel\Excel::XLSX);
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

        return view('livewire.officer.kpi-report', [
            'reports' => $reports,
            'pages' => $this->pages,
        ]);
    }
}
