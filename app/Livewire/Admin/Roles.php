<?php

namespace App\Livewire\Admin;

use App\Models\Audit;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Livewire\WithoutUrlPagination;
use Livewire\Attributes\Validate;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Title;
use Masmerise\Toaster\Toaster;
use Livewire\WithPagination;
use Livewire\Component;
use App\Models\User;
use Flux\Flux;
use Illuminate\Support\Facades\Auth;

#[Title('Roles')]
class Roles extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'tailwind';

    public string $role = '';

    public $search = '';
    public bool $showTrashed = false;
    public $perPage = 10;
    public $pages = [10, 20, 30, 40, 50];
    public $editData = [
        'role' => '',
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

    public function setEdit($id)
    {
        $user = User::findOrFail($id);
        $this->editId = $id;
        $this->editData = [
            'role' => $user->getRoleNames()->first() ?: '',
        ];
    }

    public function edit()
    {
        $validated = $this->validate([
            'editData.role' => ['required', 'exists:roles,name'],
        ]);
        $user = User::findOrFail($this->editId);
        $oldRole = $user->getRoleNames()->first();
        $user->syncRoles([$validated['editData']['role']]);

        Audit::create([
            'auditable_id' => $user->id,
            'auditable_type' => User::class,
            'user_id' => Auth::id(),
            'event' => 'role_updated',
            'old_values' => ['role' => $oldRole],
            'new_values' => ['role' => $validated['editData']['role']],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        Flux::modal('edit-user-' . $this->editId)->close();
        Toaster::success('User role updated successfully.');
        $this->reset(['editId', 'editData']);
    }


    public function render()
    {
        $query = User::query()->with('roles');

        if ($this->showTrashed) {
            $query->onlyTrashed();
        }

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate($this->perPage);

        $roles = Role::all();

        return view('livewire.admin.roles', [
            'users' => $users,
            'pages' => $this->pages,
            'roles' => $roles,
        ]);
    }
}
