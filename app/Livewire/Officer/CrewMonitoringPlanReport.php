<?php

namespace App\Livewire\Officer;

use Livewire\Component;
use App\Models\Voyage;
use Illuminate\Support\Facades\Auth;

class CrewMonitoringPlanReport extends Component
{
    public $search = '';
    public $perPage = 10;
    public $pages = [10, 20, 30, 40, 50];

    public function render()
    {
        $assignedVesselIds = Auth::user()->vessels()->pluck('vessels.id');

        $reports = Voyage::query()
            ->with(['unit', 'vessel', 'board_crew', 'crew_change'])
            ->where('report_type', 'Crew Monitoring Plan')
            ->whereIn('vessel_id', $assignedVesselIds)
            ->when($this->search, function ($query) {
                $query->whereHas('unit', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.officer.crew-monitoring-plan-report', [
            'reports' => $reports,
            'pages' => $this->pages,
        ]);
    }
}
