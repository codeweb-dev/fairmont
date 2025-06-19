<?php

namespace App\Livewire\Officer;

use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Livewire\WithoutUrlPagination;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\User;
use App\Models\Voyage;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;

#[Title('Departure Report')]
class DepartureReport extends Component
{
    use WithPagination, WithoutUrlPagination;

    protected $paginationTheme = 'tailwind';

    public string $name = '';

    public $search = '';
    public $perPage = 10;
    public $pages = [10, 20, 30, 40, 50];
    public $editData = [
        'name' => '',
    ];
    public $editId = null;

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

        $reports = Voyage::query()
            ->with(['vessel', 'unit', 'remarks', 'master_info', 'noon_report', 'rob_fuel_reports'])
            ->where('report_type', 'Departure Report')
            ->whereIn('vessel_id', $assignedVesselIds)
            ->when(
                $this->search,
                fn($query) =>
                $query->whereHas(
                    'unit',
                    fn($q) =>
                    $q->where('name', 'like', '%' . $this->search . '%')
                )
            )
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.officer.departure-report', [
            'reports' => $reports,
            'pages' => $this->pages,
        ]);
    }
}
