<?php

namespace App\Exports;

use App\Models\Voyage;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class ArrivalReportsByDateExport implements FromView
{
    protected $startDate;
    protected $endDate;
    protected $selectedVessel;

    public function __construct($startDate, $endDate, $selectedVessel = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->selectedVessel = $selectedVessel;
    }

    public function view(): View
    {
        $assignedVesselIds = Auth::user()->vessels()->pluck('vessels.id');

        $query = Voyage::with(['vessel', 'unit', 'remarks', 'master_info', 'noon_report', 'rob_fuel_reports'])
            ->where('report_type', 'Arrival Report')
            ->whereIn('vessel_id', $assignedVesselIds);

        if ($this->selectedVessel) {
            $query->where('vessel_id', $this->selectedVessel);
        }

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        } elseif ($this->startDate) {
            $query->where('created_at', '>=', $this->startDate);
        } elseif ($this->endDate) {
            $query->where('created_at', '<=', $this->endDate);
        }

        $reports = $query->get();

        return view('exports.arrival-reports-by-date', compact('reports'));
    }
}
