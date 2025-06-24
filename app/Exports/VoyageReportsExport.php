<?php

namespace App\Exports;

use App\Models\Voyage;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class VoyageReportsExport implements FromView
{
    public function view(): View
    {
        $assignedVesselIds = Auth::user()->vessels()->pluck('vessels.id');

        $reports = Voyage::with([
            'vessel',
            'unit',
            'remarks',
            'master_info',
            'robs',
            'received',
            'consumption',
            'engine',
            'off_hire',
            'location'
        ])
            ->where('report_type', 'Voyage Report')
            ->whereIn('vessel_id', $assignedVesselIds)
            ->get();

        return view('exports.voyage-reports', compact('reports'));
    }
}
