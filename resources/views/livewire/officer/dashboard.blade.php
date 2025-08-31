<div class="grid auto-rows-min gap-4 md:grid-cols-5">
    <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
        <div class="flex items-center justify-between w-full">
            <div>
                <flux:text>Total Reports</flux:text>
                <flux:heading size="xl">{{ $totalReports }}</flux:heading>
            </div>
            <flux:button href="{{ route('officer-total-report') }}" icon="arrow-up-right" variant="filled" wire:navigate />
        </div>
    </div>

    <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
        <div class="flex items-center justify-between w-full">
            <div>
                <flux:text>Noon Reports</flux:text>
                <flux:heading size="xl">{{ $reportCounts['Noon Report'] ?? 0 }}</flux:heading>
            </div>
            <flux:button href="{{ route('officer-noon-report') }}" icon="arrow-up-right" variant="filled"
                wire:navigate />
        </div>
    </div>

    <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
        <div class="flex items-center justify-between w-full">
            <div>
                <flux:text>Departure Reports</flux:text>
                <flux:heading size="xl">{{ $reportCounts['Departure Report'] ?? 0 }}</flux:heading>
            </div>
            <flux:button href="{{ route('officer-departure-report') }}" icon="arrow-up-right" variant="filled"
                wire:navigate />
        </div>
    </div>

    <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
        <div class="flex items-center justify-between w-full">
            <div>
                <flux:text>Arrival Reports</flux:text>
                <flux:heading size="xl">{{ $reportCounts['Arrival Report'] ?? 0 }}</flux:heading>
            </div>
            <flux:button href="{{ route('officer-arrival-report') }}" icon="arrow-up-right" variant="filled"
                wire:navigate />
        </div>
    </div>

    <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
        <div class="flex items-center justify-between w-full">
            <div>
                <flux:text>Bunkering Reports</flux:text>
                <flux:heading size="xl">{{ $reportCounts['Bunkering'] ?? 0 }}</flux:heading>
            </div>
            <flux:button href="{{ route('officer-bunkering-report') }}" icon="arrow-up-right" variant="filled"
                wire:navigate />
        </div>
    </div>

    <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
        <div class="flex items-center justify-between w-full">
            <div>
                <flux:text>All Fast Reports</flux:text>
                <flux:heading size="xl">{{ $reportCounts['All Fast'] ?? 0 }}</flux:heading>
            </div>
            <flux:button href="{{ route('officer-all-fast-report') }}" icon="arrow-up-right" variant="filled"
                wire:navigate />
        </div>
    </div>

    <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
        <div class="flex items-center justify-between w-full">
            <div>
                <flux:text>Weekly Schedule Reports</flux:text>
                <flux:heading size="xl">{{ $reportCounts['Weekly Schedule'] ?? 0 }}</flux:heading>
            </div>
            <flux:button href="{{ route('officer-weekly-schedule-report') }}" icon="arrow-up-right" variant="filled"
                wire:navigate />
        </div>
    </div>

    <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
        <div class="flex items-center justify-between w-full">
            <div>
                <flux:text>Crew Monitoring Plan Reports</flux:text>
                <flux:heading size="xl">{{ $reportCounts['Crew Monitoring Plan'] ?? 0 }}</flux:heading>
            </div>
            <flux:button href="{{ route('officer-crew-monitoring-plan-report-on-board-crew') }}" icon="arrow-up-right"
                variant="filled" wire:navigate />
        </div>
    </div>

    <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
        <div class="flex items-center justify-between w-full">
            <div>
                <flux:text>Voyage Reports</flux:text>
                <flux:heading size="xl">{{ $reportCounts['Voyage Report'] ?? 0 }}</flux:heading>
            </div>
            <flux:button href="{{ route('officer-voyage-report') }}" icon="arrow-up-right" variant="filled"
                wire:navigate />
        </div>
    </div>

    <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
        <div class="flex items-center justify-between w-full">
            <div>
                <flux:text>KPI Reports</flux:text>
                <flux:heading size="xl">{{ $reportCounts['KPI'] ?? 0 }}</flux:heading>
            </div>
            <flux:button href="{{ route('officer-kpi-report') }}" icon="arrow-up-right" variant="filled"
                wire:navigate />
        </div>
    </div>

    <div class="relative overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 p-6">
        <div class="flex items-center justify-between w-full">
            <div>
                <flux:text>Port Of Call Reports</flux:text>
                <flux:heading size="xl">{{ $reportCounts['Port of Call'] ?? 0 }}</flux:heading>
            </div>
            <flux:button href="{{ route('officer-port-of-call-report') }}" icon="arrow-up-right" variant="filled"
                wire:navigate />
        </div>
    </div>
</div>
