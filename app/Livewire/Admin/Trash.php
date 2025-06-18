<?php

namespace App\Livewire\Admin;

use App\Models\User;
use App\Models\Voyage;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithoutUrlPagination;
use Spatie\Permission\Models\Role;
use Livewire\Attributes\Title;
use Flux\Flux;
use Masmerise\Toaster\Toaster;

#[Title('Trash')]
class Trash extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'tailwind';
    public string $viewing = 'users';

    public string $search = '';
    public $perPage = 10;
    public $pages = [10, 20, 30, 40, 50];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function restore($id)
    {
        User::onlyTrashed()->findOrFail($id)->restore();
        Toaster::success('User restored successfully.');
        Flux::modal('restore-user-' . $id)->close();
    }

    public function forceDelete($id)
    {
        User::onlyTrashed()->findOrFail($id)->forceDelete();
        Toaster::success('User permanently deleted.');
        Flux::modal('force-delete-user-' . $id)->close();
    }

    public function restoreReport($id)
    {
        Voyage::onlyTrashed()->findOrFail($id)->restore();
        Toaster::success('Report restored successfully.');
        Flux::modal('restore-report-' . $id)->close();
    }

    public function forceDeleteReport($id)
    {
        Voyage::onlyTrashed()->findOrFail($id)->forceDelete();
        Toaster::success('Report permanently deleted.');
        Flux::modal('force-delete-report-' . $id)->close();
    }

    public function render()
    {
        $query = null;

        if ($this->viewing === 'users') {
            $query = User::onlyTrashed()
                ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%"));
        } else {
            $query = Voyage::onlyTrashed()
                ->with(['vessel', 'unit'])
                ->when($this->search, fn($q) => $q->where('voyage_no', 'like', "%{$this->search}%"));
        }

        return view('livewire.admin.trash', [
            'items' => $query->paginate($this->perPage),
            'pages' => $this->pages,
        ]);
    }
}
