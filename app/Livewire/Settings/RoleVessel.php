<?php

namespace App\Livewire\Settings;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class RoleVessel extends Component
{
    public string $role = '';

    public string $vessel = '';

    public function mount(): void
    {
        $user = Auth::user()->load('vessels');
        $this->role   = $user->getRoleNames()->implode(', ');
        $this->vessel = $user->vessels->pluck('name')->implode(', ');
    }
}
