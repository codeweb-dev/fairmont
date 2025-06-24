<?php

namespace App\Exports;

use App\Models\Voyage;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;

class DepartureReportsExport implements FromView
{
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
            ->latest()
            ->get();

        return view('exports.departure-reports', ['reports' => $reports]);
    }
}
