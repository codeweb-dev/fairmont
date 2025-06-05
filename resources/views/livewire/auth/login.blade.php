<div class="flex flex-col gap-6">
    <x-auth-header :title="__('Log in to your account')"
        :description="__('Enter your email and password below to log in')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input wire:model="email" :label="__('Email address')" type="email" required autofocus autocomplete="email"
            placeholder="email@example.com" />

        <!-- Password -->
        <div class="relative">
            <flux:input wire:model="password" :label="__('Password')" type="password" required
                autocomplete="current-password" :placeholder="__('Password')" viewable />

            @if (Route::has('password.request'))
            <flux:link class="absolute end-0 top-0 text-sm" :href="route('password.request')" wire:navigate>
                {{ __('Forgot your password?') }}
            </flux:link>
            @endif
        </div>

        <!-- Remember Me -->

        <div class="flex items-center justify-between w-full">
            <flux:checkbox wire:model="remember" :label="__('Remember me')" />

            <flux:heading class="flex items-center gap-2">
                Need Access?

                <flux:tooltip toggleable>
                    <flux:button icon="information-circle" size="sm" variant="ghost" />

                    <flux:tooltip.content class="max-w-[20rem] space-y-2">
                        <p>Please contact your system administrator.” –
                            guiding new or unauthorized
                            users appropriately.</p>
                    </flux:tooltip.content>
                </flux:tooltip>
            </flux:heading>
        </div>

        <div class="flex items-center justify-end">
            <flux:button variant="primary" type="submit" class="w-full">{{ __('Log in') }}</flux:button>
        </div>
    </form>
</div>
