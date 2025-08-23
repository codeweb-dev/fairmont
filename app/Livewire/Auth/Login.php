<?php

namespace App\Livewire\Auth;

use App\Models\Audit;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use App\Mail\OtpCode;
use App\Models\UserOtp;
use Carbon\Carbon;

#[Layout('components.layouts.auth')]
class Login extends Component
{
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    public bool $remember = false;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt(['email' => $this->email, 'password' => $this->password], $this->remember)) {
            RateLimiter::hit($this->throttleKey());
            throw ValidationException::withMessages(['email' => __('auth.failed')]);
        }

        $user = Auth::user();

        if (!$user->is_active) {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => 'Your account is deactivated. Please contact the administrator.'
            ]);
        }

        if ($user->getRoleNames()->isEmpty()) {
            Auth::logout();
            throw ValidationException::withMessages([
                'email' => 'Your account does not have an assigned role. Please contact the administrator.'
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();

        // ✅ Check if user already verified OTP today
        if ($user->last_otp_verified_at && $user->last_otp_verified_at->isToday()) {
            // Direct login, no OTP required
            $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
            return;
        }

        // Otherwise, generate new OTP
        $otp = rand(100000, 999999);
        UserOtp::create([
            'user_id' => $user->id,
            'code' => $otp,
            'expires_at' => now()->addMinutes(5),
        ]);

        Mail::to($user->email)->send(new \App\Mail\OtpCode($otp));

        Auth::logout();

        session([
            'otp_user_id' => $user->id,
            'otp_remember_me' => $this->remember,
        ]);

        $this->redirect(route('otp.verify'), navigate: true);
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => __('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}
