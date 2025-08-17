<section class="mt-10 space-y-6">
    <div class="relative mb-5">
        <flux:heading>{{ __('Role & Vessel') }}</flux:heading>
        <flux:subheading>{{ __('Your current role and assigned vessels') }}</flux:subheading>
    </div>

    <div class="space-y-6">
        {{-- Role --}}
        <flux:input :label="__('Role')" type="text" :value="$role ? : __('No role assigned')" readonly />

        {{-- Vessel (only show if not admin) --}}
        @if (strtolower($role) !== 'admin')
            <flux:input :label="__('Vessel(s)')" type="text" :value="$vessel ? : __('No vessel assigned')" readonly />
        @endif
    </div>
</section>
