<?php

namespace App\Livewire;

use App\Models\Vessel;
use Livewire\Component;

class GlobalSearch extends Component
{
    public $query = '';
    public $results = [];

    public function updatedQuery()
    {
        $this->results = [];

        $pages = collect([
            ['name' => 'Dashboard', 'url' => route('dashboard')],
            ['name' => 'Profile Settings', 'url' => route('settings.profile')],
            ['name' => 'Password Settings', 'url' => route('settings.password')],
            ['name' => 'Appearance Settings', 'url' => route('settings.appearance')],
        ]);

        if (auth()->user()->hasRole('admin')) {
            $pages = $pages->merge([
                ['name' => 'Users', 'url' => route('users')],
                ['name' => 'Roles', 'url' => route('roles')],
                ['name' => 'Audit', 'url' => route('audit')],
                ['name' => 'Trash', 'url' => route('trash')],
                ['name' => 'Noon Report', 'url' => route('admin-noon-report')],
                ['name' => 'Departure Report', 'url' => route('admin-departure-report')],
                ['name' => 'Arrival Report', 'url' => route('admin-arrival-report')],
                ['name' => 'Bunkering Report', 'url' => route('admin-bunkering-report')],
                ['name' => 'All Fast Report', 'url' => route('admin-all-fast-report')],
                ['name' => 'Weekly Schedule Report', 'url' => route('admin-weekly-schedule-report')],
                ['name' => 'Crew Monitoring Plan Report', 'url' => route('admin-crew-monitoring-plan-report')],
                ['name' => 'Voyage Report', 'url' => route('admin-voyage-report')],
                ['name' => 'KPI Report', 'url' => route('admin-kpi-report')],
                ['name' => 'Port Of Call Report', 'url' => route('admin-port-of-call-report')],
            ]);
        }

        if (auth()->user()->hasRole('unit')) {
            $pages = $pages->merge([
                ['name' => 'Noon Report', 'url' => route('noon-report')],
                ['name' => 'Departure Report', 'url' => route('departure-report')],
                ['name' => 'Arrival Report', 'url' => route('arrival-report')],
                ['name' => 'Bunkering', 'url' => route('bunkering')],
                ['name' => 'All Fast', 'url' => route('all-fast')],
                ['name' => 'Weekly Schedule', 'url' => route('weekly-schedule')],
                ['name' => 'Crew Monitoring Plan', 'url' => route('crew-monitoring-plan')],
                ['name' => 'Voyage Report', 'url' => route('voyage-report')],
                ['name' => 'KPI', 'url' => route('kpi')],
                ['name' => 'Port Of Call', 'url' => route('port-of-call')],
            ]);
        }

        if (auth()->user()->hasRole('officer')) {
            $pages = $pages->merge([
                ['name' => 'Noon Report', 'url' => route('officer-noon-report')],
                ['name' => 'Departure Report', 'url' => route('officer-departure-report')],
                ['name' => 'Arrival Report', 'url' => route('officer-arrival-report')],
                ['name' => 'Bunkering Report', 'url' => route('officer-bunkering-report')],
                ['name' => 'All Fast Report', 'url' => route('officer-all-fast-report')],
                ['name' => 'Weekly Schedule Report', 'url' => route('officer-weekly-schedule-report')],
                ['name' => 'Crew Monitoring Plan Report (On Board)', 'url' => route('officer-crew-monitoring-plan-report-on-board-crew')],
                ['name' => 'Crew Monitoring Plan Report (Crew Change)', 'url' => route('officer-crew-monitoring-plan-report-crew-change')],
                ['name' => 'Voyage Report', 'url' => route('officer-voyage-report')],
                ['name' => 'KPI Report', 'url' => route('officer-kpi-report')],
                ['name' => 'Port Of Call Report', 'url' => route('officer-port-of-call-report')],
            ]);
        }

        $filteredPages = $pages->filter(function ($page) {
            return str_contains(strtolower($page['name']), strtolower($this->query));
        });

        $this->results = $filteredPages->take(10)->values()->toArray();
    }

    public function render()
    {
        return view('livewire.global-search');
    }
}
