<?php

namespace App\Exports;

use App\Models\Voyage;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;

class DepartureReportsExport implements FromView
{
    protected $reportIds;

    public function __construct($reportIds = null)
    {
        $this->reportIds = $reportIds;
    }

    public function view(): View
    {
        $assignedVesselIds = Auth::user()->vessels()->pluck('vessels.id');

        $query = Voyage::with([
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
            ->whereIn('vessel_id', $assignedVesselIds);

        if ($this->reportIds) {
            $query->whereIn('id', $this->reportIds);
        }

        $reports = $query->get();

        return view('exports.departure-reports', ['reports' => $reports]);
    }
}
