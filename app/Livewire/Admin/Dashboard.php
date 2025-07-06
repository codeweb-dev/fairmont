<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\User;
use App\Models\Vessel;
use App\Models\Voyage;

class Dashboard extends Component
{
    public int $totalReports = 0;
    public int $totalUsers = 0;
    public int $totalVessels = 0;
    public $reportCounts = [];

    public function mount(): void
    {
        $this->totalReports = Voyage::count();
        $this->totalUsers = User::count();
        $this->totalVessels = Vessel::count();

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
            $this->reportCounts[$type] = Voyage::where('report_type', $type)->count();
        }
    }

    public function render()
    {
        return view('livewire.admin.dashboard', [
            'totalReports' => $this->totalReports,
            'totalUsers' => $this->totalUsers,
            'totalVessels' => $this->totalVessels,
        ]);
    }
}
