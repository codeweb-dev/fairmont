<?php

namespace App\Exports;

use App\Models\Voyage;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;

class WeeklyScheduleReportsExport implements FromView
{
    public function view(): View
    {
        $assignedVesselIds = Auth::user()->vessels()->pluck('vessels.id');

        $reports = Voyage::with(['vessel', 'unit', 'ports.agents', 'master_info'])
            ->where('report_type', 'Weekly Schedule')
            ->whereIn('vessel_id', $assignedVesselIds)
            ->get();

        return view('exports.weekly-schedule-reports', compact('reports'));
    }
}
