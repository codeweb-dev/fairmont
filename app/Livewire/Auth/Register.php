<?php

namespace App\Livewire\Auth;

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.auth')]
class Register extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(12)                  // minimum 12
                    ->letters()                   // must contain letters
                    ->mixedCase()                 // at least 1 uppercase + 1 lowercase
                    ->numbers()                   // at least 1 number
                    ->symbols()                   // at least 1 symbol
                    ->uncompromised()             // check against known leaked passwords
                    ->max(128),                   // max length safeguard
            ],
        ], [
            // ✅ Custom error messages
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

        if ($user->email === 'admin@gmail.com') {
            $user->assignRole('admin');
        } else {
            $user->assignRole('unit');
        }

        event(new Registered($user));

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}
