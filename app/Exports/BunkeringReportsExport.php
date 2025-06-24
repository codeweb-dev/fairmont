<?php

namespace App\Exports;

use App\Models\Voyage;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;

class BunkeringReportsExport implements FromView
{
    public function view(): View
    {
        $assignedVesselIds = Auth::user()->vessels()->pluck('vessels.id');

        $reports = Voyage::with([
            'vessel',
            'unit',
            'rob_tanks',
            'rob_fuel_reports',
            'noon_report',
            'remarks',
            'master_info',
            'weather_observations',
            'bunker',
            'assiociated_information'
        ])
            ->where('report_type', 'Bunkering')
            ->whereIn('vessel_id', $assignedVesselIds)
            ->latest()
            ->get();

        return view('exports.bunkering-reports', ['reports' => $reports]);
    }
}
