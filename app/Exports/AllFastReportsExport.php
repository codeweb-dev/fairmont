<?php

namespace App\Exports;

use App\Models\Voyage;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;

class AllFastReportsExport implements FromView
{
    public function view(): View
    {
        $assignedVesselIds = Auth::user()->vessels()->pluck('vessels.id');

        $reports = Voyage::with(['vessel', 'unit', 'robs'])
            ->where('report_type', 'All Fast')
            ->whereIn('vessel_id', $assignedVesselIds)
            ->get();

        return view('exports.all-fast-reports', compact('reports'));
    }
}
