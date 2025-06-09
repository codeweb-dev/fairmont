<?php

namespace App\Livewire\Officer;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use App\Models\Voyage;
use Illuminate\Support\Facades\Auth;

class WeeklyScheduleReport extends Component
{
    use WithPagination, WithoutUrlPagination;

    public $search = '';
    public $perPage = 10;
    public $pages = [10, 20, 30, 40, 50];

    public function updatingPerPage()
    {
        $this->resetPage();
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $assignedVesselIds = Auth::user()->vessels()->pluck('vessels.id');

        $reports = Voyage::with(['vessel', 'unit', 'ports.agents', 'master_info'])
            ->where('report_type', 'Weekly Schedule')
            ->whereIn('vessel_id', $assignedVesselIds)
            ->when(
                $this->search,
                fn($q) =>
                $q->whereHas(
                    'unit',
                    fn($u) =>
                    $u->where('name', 'like', '%' . $this->search . '%')
                )
            )
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.officer.weekly-schedule-report', [
            'reports' => $reports,
            'pages' => $this->pages,
        ]);
    }
}
