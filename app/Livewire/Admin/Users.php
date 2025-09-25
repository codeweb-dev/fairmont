<?php

namespace App\Livewire\Admin;

use App\Models\Audit;
use Illuminate\Validation\Rules\Password;
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

    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = '';

    public $search = '';
    public $perPage = 10;
    public $pages = [10, 20, 30, 40, 50];
    public $editData = [
        'name' => '',
        'email' => '',
        'password' => '',
    ];
    public $editId = null;
    public $currentPage = 1;

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
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(12)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
                    ->max(128),
            ],
        ], [
            'password.min' => 'Your password must be at least 12 characters long.',
            'password.max' => 'Your password may not be longer than 128 characters.',
            'password.letters' => 'Your password must contain at least one letter.',
            'password.mixed' => 'Your password must include both uppercase and lowercase letters.',
            'password.numbers' => 'Your password must contain at least one number.',
            'password.symbols' => 'Your password must contain at least one symbol.',
            'password.uncompromised' => 'This password has appeared in a data breach. Please choose a different one.',
            'password.confirmed' => 'The password confirmation does not match.',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        Audit::create([
            'user' => $user->name,
            'event' => 'user_created',
            'old_values' => [],
            'new_values' => ['name' => $user->name, 'email' => $user->email],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

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
            'editData.email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                'unique:' . User::class . ',email,' . $this->editId,
            ],
            'editData.password' => [
                'nullable',
                'string',
                Password::min(12)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
                    ->max(128),
            ],
        ], [
            'editData.password.min' => 'Password must be at least 12 characters long.',
            'editData.password.max' => 'Password may not be longer than 128 characters.',
            'editData.password.letters' => 'Password must contain at least one letter.',
            'editData.password.mixed' => 'Password must include both uppercase and lowercase letters.',
            'editData.password.numbers' => 'Password must contain at least one number.',
            'editData.password.symbols' => 'Password must contain at least one symbol.',
            'editData.password.uncompromised' => 'This password has appeared in a data breach. Please choose a different one.',
            'editData.password.confirmed' => 'The password confirmation does not match.',
        ]);

        $user = User::findOrFail($this->editId);

        $oldValues = ['name' => $user->name, 'email' => $user->email];

        $user->name = $validated['editData']['name'];
        $user->email = $validated['editData']['email'];
        if (!empty($validated['editData']['password'])) {
            $user->password = Hash::make($validated['editData']['password']);
        }
        $user->save();

        Audit::create([
            'user' => $user->name,
            'event' => 'user_updated',
            'old_values' => $oldValues,
            'new_values' => ['name' => $user->name, 'email' => $user->email],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        Flux::modal('edit-user-' . $this->editId)->close();
        Toaster::success('User updated successfully.');
        $this->reset(['editId', 'editData']);
    }

    public function delete($id)
    {
        $user = User::findOrFail($id);

        $oldValues = ['name' => $user->name, 'email' => $user->email];

        $user->voyages()->delete();
        $user->delete();

        Audit::create([
            'user' => $user->name,
            'event' => 'user_deleted',
            'old_values' => $oldValues,
            'new_values' => [],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        Flux::modal('delete-user-' . $id)->close();
        Toaster::success('User soft deleted successfully.');
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

        Audit::create([
            'user' => $user->name,
            'event' => 'user_deactivated',
            'old_values' => ['is_active' => true],
            'new_values' => ['is_active' => false],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        Flux::modal('deactivate-user-' . $id)->close();
        Toaster::success('User deactivated successfully.');
    }

    public function activate($id)
    {
        $user = User::findOrFail($id);
        $user->is_active = true;
        $user->save();

        Audit::create([
            'user' => $user->name,
            'event' => 'user_activated',
            'old_values' => ['is_active' => false],
            'new_values' => ['is_active' => true],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        Flux::modal('deactivate-user-' . $id)->close();
        Toaster::success('User activated successfully.');
    }

    public function updatedCurrentPage($value)
    {
        if ($value < 1) {
            $this->currentPage = 1;
        } elseif ($value > $this->getMaxPage()) {
            $this->currentPage = $this->getMaxPage();
        }
    }

    private function getMaxPage()
    {
        $query = User::query();

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        return ceil($query->count() / $this->perPage);
    }

    public function render()
    {
        $query = User::query()->with('roles');

        if (!empty($this->search)) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('email', 'like', '%' . $this->search . '%');
            });
        }

        $users = $query->orderBy('created_at', 'desc')
            ->paginate($this->perPage, ['*'], 'page', $this->currentPage);

        $roles = Role::all();

        return view('livewire.admin.users', [
            'users' => $users,
            'pages' => $this->pages,
            'roles' => $roles,
        ]);
    }
}
