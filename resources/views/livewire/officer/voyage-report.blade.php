<div>
    <div class="flex flex-col gap-6 mb-6">
        <div class="flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
            <h1 class="text-3xl font-bold">
                Voyage Reports
            </h1>

            <div class="flex items-center gap-3">
                <div class="max-w-64">
                    <flux:input wire:model.live="search" placeholder="Search by keyword" icon="magnifying-glass" />
                </div>
                @if (count($officerVessels) > 1)
                    <div class="max-w-64">
                        <flux:select wire:model.live="selectedVessel" placeholder="Filter by Vessel">
                            <flux:select.option value="">All Vessels</flux:select.option>
                            @foreach ($officerVessels as $id => $name)
                                <flux:select.option value="{{ $id }}">{{ $name }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>
                @endif
                <div class="max-w-18">
                    <flux:select wire:model.live="perPage" placeholder="Rows per page">
                        @foreach ($pages as $page)
                            <flux:select.option value="{{ $page }}">{{ $page }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
            </div>
        </div>

        <div class="flex gap-3 justify-end items-center w-full">
            @if (count($selectedReports) > 0 && !$dateRange)
                <div>
                    <flux:button wire:click="exportSelected" icon:trailing="inbox-arrow-down" variant="filled">
                        Export Selected ({{ count($selectedReports) }})
                    </flux:button>
                </div>
            @endif

            @if ($dateRange)
                <flux:button wire:click="exportByDateRange" icon:trailing="arrow-down-tray">
                    Export by Date Range
                </flux:button>
            @endif

            @if ($dateRange)
                <div>
                    <flux:button wire:click="$set('dateRange', null)" variant="danger" icon="x-circle">
                        Clear Filter
                    </flux:button>
                </div>
            @endif

            <div x-data="{ fp: null }" x-init="fp = flatpickr($refs.rangeInput, {
                mode: 'range',
                dateFormat: 'Y-m-d',
                onChange: function(selectedDates, dateStr) {
                    if (selectedDates.length === 1) {
                        const onlyDate = selectedDates[0];
                        const singleDate = flatpickr.formatDate(onlyDate, 'Y-m-d');
                        $wire.set('dateRange', `${singleDate} to ${singleDate}`);
                    } else if (selectedDates.length === 2) {
                        const start = flatpickr.formatDate(selectedDates[0], 'Y-m-d');
                        const end = flatpickr.formatDate(selectedDates[1], 'Y-m-d');
                        $wire.set('dateRange', `${start} to ${end}`);
                    } else {
                        $wire.set('dateRange', null);
                    }
                }
            });"
                x-effect="
        if ($wire.dateRange === null && fp) {
            fp.clear();
        }
     "
                wire:ignore>
                <input x-ref="rangeInput" type="text"
                    class="form-input w-full border rounded-lg block disabled:shadow-none dark:shadow-none text-base sm:text-sm py-2 h-10 leading-[1.375rem] ps-3 bg-white dark:bg-white/10 dark:disabled:bg-white/[7%] shadow-xs border-zinc-200 border-b-zinc-300/80 disabled:border-b-zinc-200 dark:border-white/10 dark:disabled:border-white/5"
                    placeholder="Select Date Range">
            </div>
        </div>
    </div>

    <x-admin-components.table>
        <thead class="border-b dark:border-white/10 border-black/10 hover:bg-white/5 bg-black/5 transition-all">
            <tr>
                <th class="px-3 py-3">
                    <flux:checkbox wire:model.live="selectAll" />
                </th>
                <th class="px-3 py-3">Report Type</th>
                <th class="px-3 py-3">Vessel Name</th>
                <th class="px-3 py-3">Voyage No</th>
                <th class="px-3 py-3">Created Date</th>
                <th class="px-3 py-3">Vessel User</th>
                <th class="px-3 py-3"></th>
            </tr>
        </thead>

        @if ($reports->isEmpty())
            <tr>
                <td colspan="8" class="text-center text-zinc-500 py-10">
                    <div class="flex flex-col items-center space-y-2">
                        <flux:icon.archive-box-x-mark class="size-12" />

                        <flux:heading>No reports found.</flux:heading>
                        <flux:text class="mt-1 text-center max-w-sm">
                            Try adding a new report or adjusting your search or date range
                            filter.
                        </flux:text>
                    </div>
                </td>
            </tr>
        @endif
        @foreach ($reports as $report)
            <tr class="hover:bg-white/5 bg-black/5 transition-all">
                <td class="px-3 py-4">
                    <flux:checkbox wire:model.live="selectedReports" value="{{ $report->id }}" />
                </td>
                <td class="px-3 py-4">{{ $report->report_type }}</td>
                <td class="px-3 py-4">{{ $report->vessel->name }}</td>
                <td class="px-3 py-4">{{ $report->voyage_no }}</td>
                <td class="px-3 py-4">
                    {{ \Carbon\Carbon::parse($report->created_at)->timezone('Asia/Manila')->format('M d, Y h:i A') }}
                </td>
                <td class="px-3 py-4">{{ $report->unit->name }}</td>
                <td class="px-3 py-4">
                    <flux:button size="xs" icon="eye" wire:click="openReportModal({{ $report->id }})">View
                    </flux:button>
                </td>
            </tr>
        @endforeach
    </x-admin-components.table>

    <div class="mt-6">
        {{ $reports->links() }}
    </div>

    @if ($showModal && $selectedReport)
        <flux:modal name="report-details-modal" class="max-w-6xl" wire:model="showModal">
            <div class="space-y-6">
                <flux:heading size="lg">Voyage Report Details</flux:heading>

                <!-- Bunkering Details -->
                <flux:heading size="sm">Voyage Details</flux:heading>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <flux:label>Vessel Name</flux:label>
                        <p class="text-sm">{{ $selectedReport->vessel->name }}</p>
                    </div>
                    <div>
                        <flux:label>Voyage No</flux:label>
                        <p class="text-sm">{{ $selectedReport->voyage_no }}</p>
                    </div>
                    <div>
                        <flux:label>Date</flux:label>
                        <p class="text-sm">
                            {{ \Carbon\Carbon::parse($selectedReport->all_fast_datetime)->format('M d, Y h:i A') }}
                        </p>
                    </div>
                </div>

                <flux:separator />

                <!-- Location -->
                <flux:heading size="sm">Location</flux:heading>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <flux:label>Port of Departure COSP</flux:label>
                        <p class="text-sm">
                            {{ $selectedReport->location->port_departure ? \Carbon\Carbon::parse($selectedReport->location->port_departure)->format('M d, Y h:i A') : '' }}
                        </p>
                    </div>
                    <div>
                        <flux:label>Port of Arrival EOSP</flux:label>
                        <p class="text-sm">
                            {{ $selectedReport->location->port_arrival ? \Carbon\Carbon::parse($selectedReport->location->port_arrival)->format('M d, Y h:i A') : '' }}
                        </p>
                    </div>
                </div>

                <flux:separator />

                <!-- Off Hire -->
                <flux:heading size="sm">Off Hire</flux:heading>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <flux:label>Off Hire Hours (Hrs)</flux:label>
                        <p class="text-sm">{{ ltrim($selectedReport->off_hire->hire_hours ?? '', '0') }}</p>
                    </div>
                    <div>
                        <flux:label>Off Hire Reason</flux:label>
                        <p class="text-sm">{{ $selectedReport->off_hire->hire_reason }}</p>
                    </div>
                </div>

                <flux:separator />

                <!-- Engine -->
                <flux:heading size="sm">Engine</flux:heading>
                <div class="grid grid-cols-4 gap-4">
                    <div>
                        <flux:label>Avg ME RPM</flux:label>
                        <p class="text-sm">
                            {{ $selectedReport->engine->avg_me_rpm !== null ? rtrim(rtrim(number_format((float) $selectedReport->engine->avg_me_rpm, 3, '.', ''), '0'), '.') : '' }}
                        </p>
                    </div>
                    <div>
                        <flux:label>Avg ME kW</flux:label>
                        <p class="text-sm">
                            {{ $selectedReport->engine->avg_me_kw !== null ? rtrim(rtrim(number_format((float) $selectedReport->engine->avg_me_kw, 3, '.', ''), '0'), '.') : '' }}
                        </p>
                    </div>
                    <div>
                        <flux:label>TDR (Nm)</flux:label>
                        <p class="text-sm">
                            {{ $selectedReport->engine->tdr !== null ? rtrim(rtrim(number_format((float) $selectedReport->engine->tdr, 3, '.', ''), '0'), '.') : '' }}
                        </p>
                    </div>
                    <div>
                        <flux:label>TST (Hrs)</flux:label>
                        <p class="text-sm">
                            {{ $selectedReport->engine->tst !== null ? rtrim(rtrim(number_format((float) $selectedReport->engine->tst, 3, '.', ''), '0'), '.') : '' }}
                        </p>
                    </div>
                    <div>
                        <flux:label>Slip (%)</flux:label>
                        <p class="text-sm">
                            {{ $selectedReport->engine->slip !== null ? rtrim(rtrim(number_format((float) $selectedReport->engine->slip, 3, '.', ''), '0'), '.') : '' }}
                        </p>
                    </div>
                </div>

                <flux:separator />

                <!-- ROB -->
                <flux:heading size="sm">ROB</flux:heading>
                <div class="grid grid-cols-4 gap-4">
                    @php
                        $robLabels = [
                            'hsfo' => 'HSFO (MT)',
                            'vlsfo' => 'VLSFO (MT)',
                            'biofuel' => 'BIO FUEL (MT)',
                            'lsmgo' => 'LSMGO (MT)',
                            'me_cc_oil' => 'ME CC OIL (LITRES)',
                            'mc_cyl_oil' => 'ME CYL OIL (LITRES)',
                            'ge_cc_oil' => 'GE CC OIL (LITRES)',
                            'fw' => 'FW (MT)',
                            'fw_produced' => 'FW Produced (MT)',
                        ];
                    @endphp

                    @foreach ($robLabels as $key => $label)
                        <div>
                            <flux:label>{{ $label }}</flux:label>
                            <p class="text-sm">
                                @php
                                    $value = optional($selectedReport->robs->first())->$key;
                                @endphp
                                {{ $value !== null ? rtrim(rtrim(number_format((float) $value, 3, '.', ''), '0'), '.') : '' }}
                            </p>
                        </div>
                    @endforeach
                </div>

                <flux:separator />

                @php
                    $fuelLabels = [
                        'hsfo' => 'HSFO (MT)',
                        'vlsfo' => 'VLSFO (MT)',
                        'biofuel' => 'BIO FUEL (MT)',
                        'lsmgo' => 'LSMGO (MT)',
                        'me_cc_oil' => 'ME CC OIL (LITRES)',
                        'mc_cyl_oil' => 'ME CYL OIL (LITRES)',
                        'ge_cc_oil' => 'GE CC OIL (LITRES)',
                        'fw' => 'FW (MT)',
                        'fw_produced' => 'FW Produced (MT)',
                    ];
                @endphp

                {{-- Received --}}
                <flux:heading size="sm">Received</flux:heading>
                <div class="grid grid-cols-4 gap-4">
                    @foreach ($fuelLabels as $key => $label)
                        <div>
                            <flux:label>{{ $label }}</flux:label>
                            <p class="text-sm">
                                @php
                                    $value = optional($selectedReport->received)->$key;
                                @endphp
                                {{ $value !== null ? rtrim(rtrim(number_format((float) $value, 3, '.', ''), '0'), '.') : '' }}
                            </p>
                        </div>
                    @endforeach
                </div>

                <flux:separator />

                {{-- Consumption --}}
                <flux:heading size="sm">Consumption</flux:heading>
                <div class="grid grid-cols-4 gap-4">
                    @foreach ($fuelLabels as $key => $label)
                        <div>
                            <flux:label>{{ $label }}</flux:label>
                            <p class="text-sm">
                                @php
                                    $value = optional($selectedReport->consumption)->$key;
                                @endphp
                                {{ $value !== null ? rtrim(rtrim(number_format((float) $value, 3, '.', ''), '0'), '.') : '' }}
                            </p>
                        </div>
                    @endforeach
                </div>

                <flux:separator />

                <!-- Remarks -->
                @if ($selectedReport->remarks)
                    <div class="pt-4">
                        <flux:heading size="sm">Remarks</flux:heading>
                        <p class="text-sm whitespace-pre-line">{{ $selectedReport->remarks->remarks }}</p>
                    </div>
                @endif

                <flux:separator />

                <!-- Master Information -->
                @if ($selectedReport->master_info)
                    <div class="pt-4">
                        <flux:heading size="sm">Master Information</flux:heading>
                        <p class="text-sm whitespace-pre-line">{{ $selectedReport->master_info->master_info }}</p>
                    </div>
                @endif

                <!-- Close Modal Button -->
                <div class="flex justify-end pt-4">
                    <flux:modal.close>
                        <flux:button variant="primary">Close</flux:button>
                    </flux:modal.close>
                </div>
            </div>
        </flux:modal>
    @endif
</div>
