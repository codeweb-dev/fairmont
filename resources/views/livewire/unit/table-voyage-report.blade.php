<div>
    <div class="mb-6 flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
        <h1 class="text-3xl font-bold">
            Voyage Reports
        </h1>

        <div class="flex items-center gap-3">
            <div class="max-w-64">
                <flux:input wire:model.live="search" placeholder="Search by unit name..." icon="magnifying-glass" />
            </div>
            <div class="max-w-18">
                <flux:select wire:model.live="perPage" placeholder="Rows per page">
                    @foreach ($pages as $page)
                        <flux:select.option value="{{ $page }}">{{ $page }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>

            <div>
                <flux:button wire:click="export" icon:trailing="inbox-arrow-down">
                    Export Report
                </flux:button>
            </div>

            <div>
                <flux:button href="{{ route('voyage-report') }}" wire:navigate icon:trailing="plus">
                    Create Report
                </flux:button>
            </div>
        </div>
    </div>

    <x-admin-components.table :headers="['Report Type', 'Vessel', 'Unit', 'Voyage No', 'Date', '']">
        @foreach ($reports as $report)
            <tr class="hover:bg-white/5 bg-black/5 transition-all">
                <td class="px-3 py-4">{{ $report->report_type }}</td>
                <td class="px-3 py-4">{{ $report->vessel->name ?? '-' }}</td>
                <td class="px-3 py-4">{{ $report->unit->name ?? '-' }}</td>
                <td class="px-3 py-4">{{ $report->voyage_no }}</td>
                <td class="px-3 py-4">
                    {{ $report->all_fast_datetime ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') : '-' }}
                </td>
                <td class="px-3 py-4">
                    <flux:dropdown>
                        <flux:button icon:trailing="ellipsis-horizontal" size="xs" variant="ghost" />

                        <flux:menu>
                            <flux:menu.radio.group>
                                <flux:modal.trigger name="view-voyage-{{ $report->id }}">
                                    <flux:menu.item icon="eye">
                                        View Details
                                    </flux:menu.item>
                                </flux:modal.trigger>
                            </flux:menu.radio.group>
                        </flux:menu>
                    </flux:dropdown>

                    <flux:modal name="view-voyage-{{ $report->id }}" class="max-w-6xl">
                        <div class="space-y-6">
                            <flux:heading size="lg">Voyage Report Details</flux:heading>

                            <!-- Bunkering Details -->
                            <flux:heading size="sm">Bunkering Details</flux:heading>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <flux:label>Vessel</flux:label>
                                    <p class="text-sm">{{ $report->vessel->name }}</p>
                                </div>
                                <div>
                                    <flux:label>Voyage No</flux:label>
                                    <p class="text-sm">{{ $report->voyage_no }}</p>
                                </div>
                                <div>
                                    <flux:label>Date</flux:label>
                                    <p class="text-sm">
                                        {{ \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y') }}</p>
                                </div>
                            </div>

                            <flux:separator />

                            <!-- Location -->
                            <flux:heading size="sm">Location</flux:heading>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <flux:label>Port of Departure COSP</flux:label>
                                    <p class="text-sm">
                                        {{ \Carbon\Carbon::parse($report->location->port_departure)->format('M d, Y h:i A') }}
                                    </p>
                                </div>
                                <div>
                                    <flux:label>Port of Arrival EOSP</flux:label>
                                    <p class="text-sm">
                                        {{ \Carbon\Carbon::parse($report->location->port_arrival)->format('M d, Y h:i A') }}
                                    </p>
                                </div>
                            </div>

                            <flux:separator />

                            <!-- Off Hire -->
                            <flux:heading size="sm">Off Hire</flux:heading>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <flux:label>Off Hire Hours (Hrs)</flux:label>
                                    <p class="text-sm">{{ $report->off_hire->hire_hours }}</p>
                                </div>
                                <div>
                                    <flux:label>Off Hire Reason</flux:label>
                                    <p class="text-sm">{{ $report->off_hire->hire_reason }}</p>
                                </div>
                            </div>

                            <flux:separator />

                            <!-- Engine -->
                            <flux:heading size="sm">Engine</flux:heading>
                            <div class="grid grid-cols-4 gap-4">
                                <div>
                                    <flux:label>Avg ME RPM</flux:label>
                                    <p class="text-sm">{{ $report->engine->avg_me_rpm }}</p>
                                </div>
                                <div>
                                    <flux:label>Avg ME kW</flux:label>
                                    <p class="text-sm">{{ $report->engine->avg_me_kw }}</p>
                                </div>
                                <div>
                                    <flux:label>TDR (Nm)</flux:label>
                                    <p class="text-sm">{{ $report->engine->tdr }}</p>
                                </div>
                                <div>
                                    <flux:label>TST (Hrs)</flux:label>
                                    <p class="text-sm">{{ $report->engine->tst }}</p>
                                </div>
                                <div>
                                    <flux:label>Slip (%)</flux:label>
                                    <p class="text-sm">{{ $report->engine->slip }}</p>
                                </div>
                            </div>

                            <flux:separator />

                            <!-- ROB -->
                            <flux:heading size="sm">ROB</flux:heading>
                            <div class="grid grid-cols-4 gap-4">
                                @foreach (['hsfo', 'vlsfo', 'biofuel', 'lsmgo', 'me_cc_oil', 'mc_cyl_oil', 'ge_cc_oil', 'fw', 'fw_produced'] as $rob)
                                    <div>
                                        <flux:label>{{ strtoupper($rob) }}</flux:label>
                                        <p class="text-sm">{{ optional($report->robs->first())->$rob ?? '-' }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <flux:separator />

                            <!-- Received -->
                            <flux:heading size="sm">Received</flux:heading>
                            <div class="grid grid-cols-4 gap-4">
                                @foreach (['hsfo', 'vlsfo', 'biofuel', 'lsmgo', 'me_cc_oil', 'mc_cyl_oil', 'ge_cc_oil', 'fw', 'fw_produced'] as $recv)
                                    <div>
                                        <flux:label>{{ strtoupper($recv) }}</flux:label>
                                        <p class="text-sm">{{ $report->received->$recv ?? '-' }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <flux:separator />

                            <!-- Consumption -->
                            <flux:heading size="sm">Consumption</flux:heading>
                            <div class="grid grid-cols-4 gap-4">
                                @foreach (['hsfo', 'vlsfo', 'biofuel', 'lsmgo', 'me_cc_oil', 'mc_cyl_oil', 'ge_cc_oil', 'fw', 'fw_produced'] as $cons)
                                    <div>
                                        <flux:label>{{ strtoupper($cons) }}</flux:label>
                                        <p class="text-sm">{{ $report->consumption->$cons ?? '-' }}</p>
                                    </div>
                                @endforeach
                            </div>

                            <flux:separator />

                            <!-- Master's Info -->
                            @if ($report->master_info)
                                <div class="pt-4">
                                    <flux:heading size="sm">Master's Info</flux:heading>
                                    <p class="text-sm whitespace-pre-line">{{ $report->master_info->master_info }}</p>
                                </div>
                            @endif

                            <flux:separator />

                            <!-- Remarks -->
                            @if ($report->remarks)
                                <div class="pt-4">
                                    <flux:heading size="sm">Remarks</flux:heading>
                                    <p class="text-sm whitespace-pre-line">{{ $report->remarks->remarks }}</p>
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
                </td>
            </tr>
        @endforeach
    </x-admin-components.table>

    <div class="mt-6">
        {{ $reports->links() }}
    </div>
</div>
