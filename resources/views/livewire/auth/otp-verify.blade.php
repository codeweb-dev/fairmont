<div class="flex flex-col gap-6">
    <x-auth-header :title="__('One-Time PIN')" :description="__('Please enter the 6-digit PIN sent to your email to complete your login.')" />

    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="verify" class="flex flex-col gap-6">
        <flux:input type="text" wire:model.defer="code" :label="__('Code')" placeholder="Enter OTP" required
            autofocus />

        <div class="flex items-center justify-end flex-col gap-3">
            <flux:button variant="primary" type="submit" class="w-full !bg-[#ef233c] text-white">{{ __('Log in') }}
            </flux:button>

            <flux:text>Didn't get the code? Go back to <flux:link wire:click="cancelOtp">login</flux:link></flux:text>
        </div>
    </form>
</div>
