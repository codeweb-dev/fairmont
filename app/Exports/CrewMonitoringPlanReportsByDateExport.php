<?php

namespace App\Exports;

use App\Models\Voyage;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;

class CrewMonitoringPlanReportsByDateExport implements FromView
{
    protected $startDate;
    protected $endDate;
    protected $viewing;
    protected $selectedVessel;

    public function __construct($startDate, $endDate, $viewing = 'on-board', $selectedVessel = null)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->viewing = $viewing;
        $this->selectedVessel = $selectedVessel;
    }

    public function view(): View
    {
        $assignedVesselIds = Auth::user()->vessels()->pluck('vessels.id');

        $query = Voyage::with(['unit', 'vessel', 'board_crew', 'crew_change'])
            ->where('report_type', 'Crew Monitoring Plan')
            ->whereIn('vessel_id', $assignedVesselIds);

        if ($this->selectedVessel) {
            $query->where('vessel_id', $this->selectedVessel);
        }

        // Filter by viewing type
        if ($this->viewing === 'on-board') {
            $query->whereHas('board_crew');
        } elseif ($this->viewing === 'crew-change') {
            $query->whereHas('crew_change');
        }

        // Apply date filter
        if ($this->startDate && $this->endDate) {
            $query->whereBetween('created_at', [$this->startDate, $this->endDate]);
        } elseif ($this->startDate) {
            $query->where('created_at', '>=', $this->startDate);
        } elseif ($this->endDate) {
            $query->where('created_at', '<=', $this->endDate);
        }

        $reports = $query->get();

        return view('exports.crew-monitoring-plan-reports-by-date', [
            'reports' => $reports,
            'viewing' => $this->viewing,
        ]);
    }
}
