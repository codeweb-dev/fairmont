<?php

namespace App\Exports;

use App\Models\Voyage;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;

class PortOfCallReportsExport implements FromView
{
    public function view(): View
    {
        $assignedVesselIds = Auth::user()->vessels()->pluck('vessels.id');

        $reports = Voyage::with(['vessel', 'unit', 'remarks', 'master_info', 'noon_report', 'ports.agents'])
            ->where('report_type', 'Port Of Call')
            ->whereIn('vessel_id', $assignedVesselIds)
            ->latest()
            ->get();

        return view('exports.port-of-call-reports', compact('reports'));
    }
}
