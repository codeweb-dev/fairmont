<div>
    <div class="mb-6 flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
        <h1 class="text-3xl font-bold">Voyage Reports</h1>

        <div class="flex items-center gap-3">
            <div class="max-w-64">
                <flux:input wire:model.live="search" placeholder="Search by keyword" icon="magnifying-glass" />
            </div>
            <div class="max-w-18">
                <flux:select wire:model.live="perPage" placeholder="Rows per page">
                    @foreach ($pages as $page)
                        <flux:select.option value="{{ $page }}">{{ $page }}</flux:select.option>
                    @endforeach
                </flux:select>
            </div>
        </div>
    </div>

    <x-admin-components.table>
        <thead class="border-b dark:border-white/10 border-black/10 hover:bg-white/5 bg-black/5 transition-all">
            <tr>
                <th class="px-3 py-3">Report Type</th>
                <th class="px-3 py-3">Vessel</th>
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
                <td class="px-3 py-4">{{ $report->report_type }}</td>
                <td class="px-3 py-4">{{ $report->vessel->name }}</td>
                <td class="px-3 py-4">
                    {{ \Carbon\Carbon::parse($report->created_at)->timezone('Asia/Manila')->format('M d, Y h:i A') }}
                </td>
                <td class="px-3 py-4">{{ $report->unit->name }}</td>
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

                                <flux:modal.trigger name="delete-report-{{ $report->id }}">
                                    <flux:menu.item icon="trash" variant="danger">
                                        Delete
                                    </flux:menu.item>
                                </flux:modal.trigger>
                            </flux:menu.radio.group>
                        </flux:menu>
                    </flux:dropdown>

                    <flux:modal name="view-voyage-{{ $report->id }}" class="max-w-6xl">
                        <div class="space-y-6">
                            <flux:heading size="lg">Voyage Report Details</flux:heading>

                            <!-- Bunkering Details -->
                            <flux:heading size="sm">Voyage Details</flux:heading>
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
                                        {{ \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') }}
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
                                        {{ $report->location->port_departure ? \Carbon\Carbon::parse($report->location->port_departure)->format('M d, Y h:i A') : '' }}
                                    </p>
                                </div>
                                <div>
                                    <flux:label>Port of Arrival EOSP</flux:label>
                                    <p class="text-sm">
                                        {{ $report->location->port_arrival ? \Carbon\Carbon::parse($report->location->port_arrival)->format('M d, Y h:i A') : '' }}
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
                                    <p class="text-sm">
                                        {{ $report->engine->avg_me_rpm !== null ? rtrim(rtrim(number_format((float) $report->engine->avg_me_rpm, 3, '.', ''), '0'), '.') : '' }}
                                    </p>
                                </div>
                                <div>
                                    <flux:label>Avg ME kW</flux:label>
                                    <p class="text-sm">
                                        {{ $report->engine->avg_me_kw !== null ? rtrim(rtrim(number_format((float) $report->engine->avg_me_kw, 3, '.', ''), '0'), '.') : '' }}
                                    </p>
                                </div>
                                <div>
                                    <flux:label>TDR (Nm)</flux:label>
                                    <p class="text-sm">
                                        {{ $report->engine->tdr !== null ? rtrim(rtrim(number_format((float) $report->engine->tdr, 3, '.', ''), '0'), '.') : '' }}
                                    </p>
                                </div>
                                <div>
                                    <flux:label>TST (Hrs)</flux:label>
                                    <p class="text-sm">
                                        {{ $report->engine->tst !== null ? rtrim(rtrim(number_format((float) $report->engine->tst, 3, '.', ''), '0'), '.') : '' }}
                                    </p>
                                </div>
                                <div>
                                    <flux:label>Slip (%)</flux:label>
                                    <p class="text-sm">
                                        {{ $report->engine->slip !== null ? rtrim(rtrim(number_format((float) $report->engine->slip, 3, '.', ''), '0'), '.') : '' }}
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
                                                $value = optional($report->robs->first())->$key;
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
                                                $value = optional($report->received)->$key;
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
                                                $value = optional($report->consumption)->$key;
                                            @endphp
                                            {{ $value !== null ? rtrim(rtrim(number_format((float) $value, 3, '.', ''), '0'), '.') : '' }}
                                        </p>
                                    </div>
                                @endforeach
                            </div>

                            <flux:separator />

                            <!-- Remarks -->
                            @if ($report->remarks)
                                <div class="pt-4">
                                    <flux:heading size="sm">Remarks</flux:heading>
                                    <p class="text-sm whitespace-pre-line">{{ $report->remarks->remarks }}</p>
                                </div>
                            @endif

                            <flux:separator />

                            <!-- Master Information -->
                            @if ($report->master_info)
                                <div class="pt-4">
                                    <flux:heading size="sm">Master Information</flux:heading>
                                    <p class="text-sm whitespace-pre-line">{{ $report->master_info->master_info }}</p>
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

                    <flux:modal name="delete-report-{{ $report->id }}" class="min-w-[22rem]">
                        <div class="space-y-6">
                            <div>
                                <flux:heading size="lg">Soft Delete Report?</flux:heading>
                                <flux:text class="mt-2">
                                    Are you sure you want to delete the Voyage Report? <br> This report will not be permanently deleted and can be restored if needed.
                                </flux:text>
                            </div>

                            <div class="flex gap-2">
                                <flux:spacer />
                                <flux:modal.close>
                                    <flux:button variant="ghost">Cancel</flux:button>
                                </flux:modal.close>
                                <flux:button type="button" variant="danger" wire:click="delete({{ $report->id }})">
                                    Move to Trash
                                </flux:button>
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
