<?php

namespace App\Livewire\Auth;

use App\Models\Audit;
use App\Models\User;
use App\Models\UserOtp;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('components.layouts.auth')]
class OtpVerify extends Component
{
    public $code;

    public function verify()
    {
        $userId = session('otp_user_id');
        $otp = UserOtp::where('user_id', $userId)
            ->where('code', $this->code)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otp) {
            $this->addError('code', 'Invalid or expired OTP code.');
            return;
        }

        $remember = session('otp_remember_me', false);
        Auth::loginUsingId($userId, $remember);

        // Clean up
        session()->forget(['otp_user_id', 'otp_remember_me']);

        $otp->delete();

        Audit::create([
            'auditable_id' => Auth::id(),
            'auditable_type' => User::class,
            'user_id' => Auth::id(),
            'event' => 'login',
            'old_values' => [],
            'new_values' => ['email' => Auth::user()->email],
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        return redirect()->route('dashboard');
    }

    public function cancelOtp()
    {
        $userId = session('otp_user_id');

        if ($userId) {
            UserOtp::where('user_id', $userId)->delete();
            session()->forget('otp_user_id');
        }

        return redirect()->route('login');
    }

    public function render()
    {
        return view('livewire.auth.otp-verify');
    }
}
