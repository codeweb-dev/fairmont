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
use Flux\Flux;
use Illuminate\Support\Facades\Auth;

#[Title('Users')]
class Users extends Component
{
    use WithPagination, WithoutUrlPagination;
    protected $paginationTheme = 'tailwind';

    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $role = '';

    public $search = '';
    public bool $showTrashed = false;
    public $perPage = 10;
    public $pages = [10, 20, 30, 40, 50];
    public $editData = [
        'name' => '',
        'email' => '',
        'password' => '',
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

    public function save()
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'string', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);

        $this->reset();

        Flux::modal('add-user')->close();

        Toaster::success('User created successfully.');
    }

    public function setEdit($id)
    {
        $user = User::findOrFail($id);
        $this->editId = $id;
        $this->editData = [
            'name' => $user->name,
            'email' => $user->email,
            'password' => '',
        ];
    }

    public function edit()
    {
        $validated = $this->validate([
            'editData.name' => ['required', 'string', 'max:255'],
            'editData.email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class . ',email,' . $this->editId],
            'editData.password' => ['nullable', 'string', Rules\Password::defaults()],
        ]);

        $user = User::findOrFail($this->editId);
        $user->name = $validated['editData']['name'];
        $user->email = $validated['editData']['email'];
        if (!empty($validated['editData']['password'])) {
            $user->password = Hash::make($validated['editData']['password']);
        }
        $user->save();

        Flux::modal('edit-user-' . $this->editId)->close();

        Toaster::success('User updated successfully.');

        $this->reset(['editId', 'editData']);
    }

    public function restore($id)
    {
        User::onlyTrashed()->findOrFail($id)->restore();

        Toaster::success('User restored successfully.');

        Flux::modal('restore-user-' . $id)->close();
    }

    public function delete($id)
    {
        User::findOrFail($id)->delete();

        Flux::modal('delete-user-' . $id)->close();

        Toaster::success('User soft deleted successfully.');
    }

    public function forceDelete($id)
    {
        User::onlyTrashed()->findOrFail($id)->forceDelete();

        Toaster::success('User permanently deleted.');

        Flux::modal('force-delete-user-' . $id)->close();
    }

    public function deactivate($id)
    {
        $user = User::findOrFail($id);

        if (Auth::id() === $user->id) {
            Toaster::error('You cannot deactivate yourself!');
            return;
        }

        $user->is_active = false;
        $user->save();

        Flux::modal('deactivate-user-' . $id)->close();
        Toaster::success('User deactivated successfully.');
    }

    public function activate($id)
    {
        $user = User::findOrFail($id);

        $user->is_active = true;
        $user->save();

        Flux::modal('deactivate-user-' . $id)->close();
        Toaster::success('User activated successfully.');
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

        return view('livewire.admin.users', [
            'users' => $users,
            'pages' => $this->pages,
            'roles' => $roles,
        ]);
    }
}
