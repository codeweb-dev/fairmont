<?php

namespace App\Exports;

use App\Models\Voyage;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;

class CrewMonitoringPlanExport implements FromView
{
    protected $reportIds;

    public function __construct($reportIds = null)
    {
        $this->reportIds = $reportIds;
    }

    public function view(): View
    {
        $assignedVesselIds = Auth::user()->vessels()->pluck('vessels.id');

        $query = Voyage::with(['unit', 'vessel', 'board_crew', 'crew_change'])
            ->where('report_type', 'Crew Monitoring Plan')
            ->whereIn('vessel_id', $assignedVesselIds);

        if ($this->reportIds) {
            $query->whereIn('id', $this->reportIds);
        }

        $reports = $query->get();

        return view('exports.crew-monitoring-plan', compact('reports'));
    }
}
