<?php

namespace App\Exports;

use App\Models\Voyage;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;

class CrewMonitoringPlanExport implements FromView
{
    protected $reportIds;
    protected $viewType;

    public function __construct($reportIds = null, string $viewType = 'on-board')
    {
        $this->reportIds = $reportIds;
        $this->viewType  = $viewType;
    }

    public function view(): View
    {
        $assignedVesselIds = Auth::user()->vessels()->pluck('vessels.id');

        $query = Voyage::with(['unit', 'vessel', 'board_crew', 'crew_change', 'remarks', 'master_info'])
            ->where('report_type', 'Crew Monitoring Plan')
            ->whereIn('vessel_id', $assignedVesselIds);

        if (! empty($this->reportIds)) {
            $query->whereKey($this->reportIds);
        }

        // fix here

        $reports = $query->get();

        return view('exports.crew-monitoring-plan', [
            'reports'  => $reports,
            'viewType' => $this->viewType,
        ]);
    }
}
