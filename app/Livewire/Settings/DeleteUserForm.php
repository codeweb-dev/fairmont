<?php

namespace App\Livewire\Settings;

use App\Livewire\Actions\Logout;
use App\Models\Audit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DeleteUserForm extends Component
{
    public string $password = '';

    /**
     * Delete the currently authenticated user.
     */
    public function deleteUser(Logout $logout): void
    {
        $this->validate([
            'password' => ['required', 'string', 'current_password'],
        ]);

        $user = Auth::user();

        // Audit log BEFORE deleting
        Audit::create([
            'user' => $user->name,
            'event' => 'delete_account',
            'old_values' => [
                'email' => $user->email,
                'name' => $user->name,
            ],
            'new_values' => [],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        tap($user, $logout(...))->delete();

        $this->redirect('/', navigate: true);
    }
}
