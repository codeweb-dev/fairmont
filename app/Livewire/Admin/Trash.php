<?php

namespace App\Livewire\Admin;

use App\Models\User;
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

    public function render()
    {
        $query = User::onlyTrashed()->with('roles');

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        $users = $query->orderBy('deleted_at', 'desc')->paginate($this->perPage);

        return view('livewire.admin.trash', [
            'users' => $users,
            'pages' => $this->pages,
        ]);
    }
}
