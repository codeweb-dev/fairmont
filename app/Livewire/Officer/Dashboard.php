<?php

namespace App\Livewire\Officer;

use Livewire\Component;
use App\Models\Voyage;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{
    public $reportCounts = [];

    public function mount()
    {
        $vesselIds = Auth::user()->vessels()->pluck('vessels.id');

        $types = [
            'Noon Report',
            'Departure Report',
            'Arrival Report',
            'Bunkering',
            'All Fast',
            'Weekly Schedule',
            'Crew Monitoring Plan',
            'Voyage Report',
            'KPI',
            'Port of Call',
        ];

        foreach ($types as $type) {
            $this->reportCounts[$type] = Voyage::where('report_type', $type)
                ->whereIn('vessel_id', $vesselIds)
                ->count();
        }
    }

    public function render()
    {
        return view('livewire.officer.dashboard');
    }
}
