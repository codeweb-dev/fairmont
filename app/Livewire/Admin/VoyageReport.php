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

#[Title('Voyage Report')]
class VoyageReport extends Component
{
    use WithPagination, WithoutUrlPagination;

    protected $paginationTheme = 'tailwind';

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

    public function delete($id)
    {
        $voyage = Voyage::findOrFail($id);
        $voyage->delete();
        Toaster::success('Voyage Report soft deleted successfully.');
        Flux::modal('delete-report-' . $id)->close();
    }

    public function render()
    {
        $reports = Voyage::query()
            ->with([
                'vessel',
                'unit',
                'location',
                'off_hire',
                'engine',
                'received',
                'consumption',
                'robs',
            ])
            ->where('report_type', 'Voyage Report')
            ->when($this->search, function ($query) {
                $query->whereHas(
                    'unit',
                    fn($q) =>
                    $q->where('name', 'like', '%' . $this->search . '%')
                );
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.voyage-report', [
            'reports' => $reports,
            'pages' => $this->pages,
        ]);
    }
}
