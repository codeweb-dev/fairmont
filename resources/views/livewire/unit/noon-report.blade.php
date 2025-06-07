<div>
    <div class="mb-6 flex items-center justify-between w-full">
        <flux:heading size="xl" class="font-bold">Noon Report</flux:heading>

        <div class="flex items-center gap-3">
            <flux:button icon:trailing="x-mark" variant="danger">Clear Fields</flux:button>
            <flux:button icon="folder-arrow-down">Save Draft</flux:button>
            <flux:button icon="arrow-down-tray">Export Data</flux:button>
        </div>
    </div>

    <x-unit-components.noon-report.voyage-details />

    <x-unit-components.noon-report.report-details />

    <x-unit-components.noon-report.noon-condition />

    <x-unit-components.noon-report.voyage-itinerary />

    <x-unit-components.noon-report.average-weather />

    <x-unit-components.noon-report.bad-weather />

    <x-unit-components.noon-report.wind-force />

    <x-unit-components.noon-report.rob-details />

    <x-unit-components.noon-report.diesel-engine />

    <x-unit-components.noon-report.remarks />

    <x-unit-components.noon-report.master-info />

    <div class="flex items-center justify-center w-full">
        <flux:button>Submit</flux:button>
    </div>
</div>
