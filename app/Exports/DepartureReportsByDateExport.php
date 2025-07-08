<?php

namespace App\Exports;

use App\Models\Voyage;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class DepartureReportsByDateExport implements FromView
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function view(): View
    {
        $assignedVesselIds = Auth::user()->vessels()->pluck('vessels.id');

        $reports = Voyage::with([
            'vessel',
            'unit',
            'remarks',
            'master_info',
            'noon_report',
            'rob_fuel_reports',
            'rob_tanks',
            'weather_observations'
        ])
            ->where('report_type', 'Departure Report')
            ->whereIn('vessel_id', $assignedVesselIds)
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->get();

        return view('exports.departure-reports-by-date', compact('reports'));
    }
}
