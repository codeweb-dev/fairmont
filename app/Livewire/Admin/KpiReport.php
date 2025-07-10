<?php

namespace App\Livewire\Admin;

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

#[Title('Kpi Report')]
class KpiReport extends Component
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

    public function delete($id)
    {
        $voyage = Voyage::findOrFail($id);
        $voyage->delete(); // This will soft delete it
        Toaster::success('KPI Report soft deleted successfully.');
        Flux::modal('delete-report-' . $id)->close();
    }

    public function render()
    {
        $reports = Voyage::query()
            ->with([
                'vessel',
                'unit',
                'waste',
                'remarks',
                'master_info',
            ])
            ->where('report_type', 'KPI')
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->whereHas('unit', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    })->orWhereHas('vessel', function ($q) {
                        $q->where('name', 'like', '%' . $this->search . '%');
                    });
                });
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.kpi-report', [
            'reports' => $reports,
            'pages' => $this->pages,
        ]);
    }
}
