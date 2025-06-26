<?php

namespace App\Livewire\Officer;

use Livewire\WithoutUrlPagination;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\Voyage;
use Illuminate\Support\Facades\Auth;
use App\Exports\ArrivalReportsExport;
use Maatwebsite\Excel\Facades\Excel;
use ZipArchive;

#[Title('Arrival Report')]
class ArrivalReport extends Component
{
    use WithPagination, WithoutUrlPagination;

    protected $paginationTheme = 'tailwind';

    public $search = '';
    public $perPage = 10;
    public $pages = [10, 20, 30, 40, 50];
    public $selectedReports = [];
    public $selectAll = false;

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

        return Voyage::with(['vessel', 'unit', 'remarks', 'master_info', 'noon_report'])
            ->where('report_type', 'Arrival Report')
            ->whereIn('vessel_id', $assignedVesselIds)
            ->when(
                $this->search,
                fn($query) =>
                $query->whereHas(
                    'unit',
                    fn($q) =>
                    $q->where('name', 'like', '%' . $this->search . '%')
                )
            )
            ->latest();
    }

    public function exportSelected()
    {
        if (empty($this->selectedReports)) {
            Toaster::error('Please select at least one report to export.');
            return;
        }

        if (count($this->selectedReports) === 1) {
            $reportId = $this->selectedReports[0];
            $report = Voyage::with(['vessel', 'unit', 'remarks', 'master_info', 'noon_report'])->find($reportId);

            if (!$report) {
                Toaster::error('Report not found.');
                return;
            }

            $filename = 'arrival_report_' . $report->vessel->name . '_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

            Toaster::success('Report exported successfully.');
            $this->selectedReports = [];
            $this->selectAll = false;

            return Excel::download(new ArrivalReportsExport([$reportId]), $filename);
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

        $zipFileName = 'arrival_reports_export_' . now()->format('Y-m-d_H-i-s') . '.zip';
        $zipPath = $tempDir . '/' . $zipFileName;

        $zip = new ZipArchive();
        if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            Toaster::error('Unable to create ZIP file.');
            return;
        }

        $filenameCount = [];
        foreach ($this->selectedReports as $index => $reportId) {
            $report = Voyage::with(['vessel', 'unit', 'remarks', 'master_info', 'noon_report'])->find($reportId);

            if ($report) {
                $vesselName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $report->vessel->name ?? 'unknown');
                $baseFilename = 'arrival_report_' . $vesselName;

                $filename = $baseFilename . '.xlsx';
                if (isset($filenameCount[$filename])) {
                    $filenameCount[$filename]++;
                    $filename = $baseFilename . '_' . $filenameCount[$filename] . '.xlsx';
                } else {
                    $filenameCount[$filename] = 1;
                }

                $excelContent = Excel::raw(new ArrivalReportsExport([$reportId]), \Maatwebsite\Excel\Excel::XLSX);
                $zip->addFromString($filename, $excelContent);
            }
        }

        $zip->close();
        Toaster::success('Reports exported successfully.');
        $this->selectedReports = [];
        $this->selectAll = false;

        return response()->download($zipPath, $zipFileName)->deleteFileAfterSend(true);
    }

    public function render()
    {
        $assignedVesselIds = Auth::user()->vessels()->pluck('vessels.id');

        $reports = Voyage::query()
            ->with(['vessel', 'unit', 'remarks', 'master_info', 'noon_report'])
            ->where('report_type', 'Arrival Report')
            ->whereIn('vessel_id', $assignedVesselIds)
            ->when(
                $this->search,
                fn($query) =>
                $query->whereHas(
                    'unit',
                    fn($q) =>
                    $q->where('name', 'like', '%' . $this->search . '%')
                )
            )
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.officer.arrival-report', [
            'reports' => $reports,
            'pages' => $this->pages,
        ]);
    }
}
