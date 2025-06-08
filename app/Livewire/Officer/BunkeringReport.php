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

#[Title('Bunker Report')]
class BunkeringReport extends Component
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
            ->with([
                'vessel',
                'unit',
                'bunker',
                'assiociated_information',
                'remarks',
                'master_info',
            ])
            ->where('report_type', 'Bunkering')
            ->whereIn('vessel_id', $assignedVesselIds)
            ->when($this->search, function ($query) {
                $query->whereHas(
                    'unit',
                    fn($q) =>
                    $q->where('name', 'like', '%' . $this->search . '%')
                );
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.officer.bunkering-report', [
            'reports' => $reports,
            'pages' => $this->pages,
        ]);
    }
}
