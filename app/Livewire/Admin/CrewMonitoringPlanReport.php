<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Voyage;
use Livewire\Attributes\Title;

#[Title('Crew Monitoring Plan Report')]
class CrewMonitoringPlanReport extends Component
{
    public $search = '';
    public $perPage = 10;
    public $pages = [10, 20, 30, 40, 50];

    public function render()
    {
        $reports = Voyage::query()
            ->with(['unit', 'vessel', 'board_crew', 'crew_change'])
            ->where('report_type', 'Crew Monitoring Plan')
            ->when($this->search, function ($query) {
                $query->whereHas('unit', function ($q) {
                    $q->where('name', 'like', '%' . $this->search . '%');
                });
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.crew-monitoring-plan-report', [
            'reports' => $reports,
            'pages' => $this->pages,
        ]);
    }
}
