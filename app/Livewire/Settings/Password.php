<?php

namespace App\Livewire\Settings;

use App\Models\Audit;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Password extends Component
{
    public string $current_password = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => [
                    'required',
                    'string',
                    'confirmed',
                    PasswordRule::min(12)
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
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        $user = Auth::user();

        $user->update([
            'password' => Hash::make($validated['password']),
        ]);

        // 🔐 Audit trail for password change
        Audit::create([
            'user' => $user->name,
            'event' => 'password_changed',
            'old_values' => [], // never log old password
            'new_values' => ['password' => 'updated'], // just a marker
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }
}
