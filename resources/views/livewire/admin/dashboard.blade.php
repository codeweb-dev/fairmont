<div class="grid auto-rows-min gap-4 md:grid-cols-3">
    <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
        <div class="flex items-center justify-between w-full">
            <div>
                <flux:text>Total Reports</flux:text>
                <flux:heading size="xl">{{ $totalReports }}</flux:heading>
            </div>

            <flux:button href="{{ route('admin-noon-report') }}" icon="arrow-up-right" variant="filled" wire:navigate />
        </div>
    </div>
    <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
        <div class="flex items-center justify-between w-full">
            <div>
                <flux:text>Total Users</flux:text>
                <flux:heading size="xl">{{ $totalUsers }}</flux:heading>
            </div>

            <flux:button href="{{ route('users') }}" icon="arrow-up-right" variant="filled" wire:navigate />
        </div>
    </div>
    <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
        <div class="flex items-center justify-between w-full">
            <div>
                <flux:text>Total Vessels</flux:text>
                <flux:heading size="xl">{{ $totalVessels }}</flux:heading>
            </div>

            <flux:button href="{{ route('vessel') }}" icon="arrow-up-right" variant="filled" wire:navigate />
        </div>
    </div>
</div>
