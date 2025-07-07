<div>
    <div class="flex flex-col gap-6 mb-6">
        <div class="flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
            <h1 class="text-3xl font-bold">
                Departure Reports
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
            </div>
        </div>

        <div class="flex gap-3 justify-end items-center w-full">
            @if (count($selectedReports) > 0)
                <div>
                    <flux:button wire:click="exportSelected" icon:trailing="inbox-arrow-down" variant="filled">
                        Export Selected ({{ count($selectedReports) }})
                    </flux:button>
                </div>
            @endif

            @if ($dateRange)
                <div>
                    <flux:button wire:click="$set('dateRange', null)" variant="danger" icon="x-circle">
                        Clear Filter
                    </flux:button>
                </div>
            @endif

            <div x-data="{
                fp: null
            }" x-init="fp = flatpickr($refs.rangeInput, {
                mode: 'range',
                dateFormat: 'Y-m-d',
                onChange: function(selectedDates, dateStr) {
                    $wire.set('dateRange', dateStr || null);
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
                <th class="px-3 py-3">Vessel</th>
                <th class="px-3 py-3">Voyage No</th>
                <th class="px-3 py-3">Departure Type</th>
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
                <td class="px-3 py-4">{{ $report->port_gmt_offset }}</td>
                <td class="px-3 py-4">{{ \Carbon\Carbon::parse($report->created_at)->format('M d, Y h:i A') }}
                <td class="px-3 py-4">{{ $report->unit->name }}</td>
                </td>
                <td class="px-3 py-4">
                    <flux:dropdown>
                        <flux:button icon:trailing="ellipsis-horizontal" size="xs" variant="ghost" />

                        <flux:menu>
                            <flux:menu.radio.group>
                                <flux:modal.trigger name="view-departure-{{ $report->id }}">
                                    <flux:menu.item icon="eye">
                                        View Details
                                    </flux:menu.item>
                                </flux:modal.trigger>
                            </flux:menu.radio.group>
                        </flux:menu>
                    </flux:dropdown>

                    <flux:modal name="view-departure-{{ $report->id }}" class="max-w-screen-lg">
                        <div class="space-y-6">
                            <flux:heading size="lg">Departure Report Details</flux:heading>
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
                                    <flux:label>Date/Time (LT)</flux:label>
                                    <p class="text-sm">{{ $report->all_fast_datetime }}</p>
                                </div>
                                <div>
                                    <flux:label>GMT Offset</flux:label>
                                    <p class="text-sm">{{ $report->gmt_offset }}</p>
                                </div>
                                <div>
                                    <flux:label>Latitude</flux:label>
                                    <p class="text-sm">{{ $report->port }}</p>
                                </div>
                                <div>
                                    <flux:label>Longitude</flux:label>
                                    <p class="text-sm">{{ $report->bunkering_port }}</p>
                                </div>
                                <div>
                                    <flux:label>Departure Type</flux:label>
                                    <p class="text-sm">{{ $report->port_gmt_offset }}</p>
                                </div>
                                <div>
                                    <flux:label>Departure Port</flux:label>
                                    <p class="text-sm">{{ $report->supplier }}</p>
                                </div>
                            </div>

                            <flux:separator />

                            @if ($report->noon_report)
                                <flux:heading size="sm">Details Since Last Report</flux:heading>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <flux:label>CP/Ordered Speed</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->cp_ordered_speed }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Obs. Distance (NM)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->obs_distance }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Steaming Time (Hrs)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->steaming_time }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Avg Speed (Kts)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->avg_speed }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Distance to go (NM)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->distance_to_go }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Average RPM</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->avg_rpm }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Engine Distance</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->engine_distance }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Slip (%)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->maneuvering_hours }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Average Power (RPM)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->avg_power }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Course (Deg)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->course }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Logged Distance (NM)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->logged_distance }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Speed Through Water (Kts)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->speed_through_water }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Next Port</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->next_port }}</p>
                                    </div>
                                    <div>
                                        <flux:label>ETA Next Port (LT)</flux:label>
                                        <p class="text-sm">
                                            {{ $report->noon_report->eta_next_port ? \Carbon\Carbon::parse($report->noon_report->eta_next_port)->format('M d, Y h:i A') : '' }}
                                        </p>
                                    </div>
                                    <div>
                                        <flux:label>ETA GMT Offset</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->eta_gmt_offset }}</p>
                                    </div>
                                </div>

                                <flux:separator />
                                <flux:heading size="sm">Departure Conditions</flux:heading>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <flux:label>Condition</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->condition }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Displacement</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->displacement }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Cargo Name</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->cargo_name }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Cargo Weight</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->cargo_weight }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Ballast Weight</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->ballast_weight }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Fresh Water</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->fresh_water }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Fwd Draft</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->fwd_draft }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Aft Draft</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->aft_draft }}</p>
                                    </div>
                                    <div>
                                        <flux:label>GM</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->gm }}</p>
                                    </div>
                                </div>

                                <flux:separator />
                                <flux:heading size="sm">Voyage Itinerary</flux:heading>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <flux:label>Next Port</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->next_port_voyage }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Via</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->via }}</p>
                                    </div>
                                    <div>
                                        <flux:label>ETA (LT)</flux:label>
                                        <p class="text-sm">
                                            {{ $report->noon_report->eta_lt ? \Carbon\Carbon::parse($report->noon_report->eta_lt)->format('M d, Y h:i A') : '' }}
                                        </p>
                                    </div>
                                    <div>
                                        <flux:label>GMT Offset</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->gmt_offset_voyage }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Distance to Go</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->distance_to_go_voyage }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Projected Speed</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->projected_speed }}</p>
                                    </div>
                                </div>
                            @endif

                            <flux:separator />

                            @if ($report->rob_fuel_reports && $report->rob_fuel_reports->count())
                                <div>
                                    <flux:label class="mb-2">ROB Summary</flux:label>

                                    @foreach ($report->rob_fuel_reports->groupBy('fuel_type') as $fuelType => $fuels)
                                        <p class="font-semibold mt-4">{{ $fuelType }}</p>

                                        <table
                                            class="w-full text-sm border-collapse border border-zinc-200 dark:border-zinc-700 mb-6">
                                            <thead>
                                                <tr>
                                                    <th class="p-2 border text-center" rowspan="2">Bunker Type</th>
                                                    <th class="p-2 border text-center" colspan="2">ROB (in MT)</th>
                                                    <th class="p-2 border text-center" colspan="4">Consumption</th>
                                                    <th class="p-2 border text-center" colspan="2">Cons./24hr</th>
                                                    <th class="p-2 border text-center" rowspan="2">Total Cons.</th>
                                                </tr>
                                                <tr>
                                                    <th class="p-2 border">Previous</th>
                                                    <th class="p-2 border">Current</th>
                                                    <th class="p-2 border">M/E Propulsion</th>
                                                    <th class="p-2 border">A/E Cons.</th>
                                                    <th class="p-2 border">Boiler Cons.</th>
                                                    <th class="p-2 border">Incinerators</th>
                                                    <th class="p-2 border">M/E 24</th>
                                                    <th class="p-2 border">A/E 24</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($fuels as $fuel)
                                                    <tr>
                                                        <td class="p-2 border">{{ $fuel->fuel_type ?? 'N/A' }} (MT)
                                                        </td>
                                                        <td class="p-2 border">{{ $fuel->previous ?? 'N/A' }}</td>
                                                        <td class="p-2 border">{{ $fuel->current ?? 'N/A' }}</td>
                                                        <td class="p-2 border">{{ $fuel->me_propulsion ?? 'N/A' }}
                                                        </td>
                                                        <td class="p-2 border">{{ $fuel->ae_cons ?? 'N/A' }}</td>
                                                        <td class="p-2 border">{{ $fuel->boiler_cons ?? 'N/A' }}</td>
                                                        <td class="p-2 border">{{ $fuel->incinerators ?? 'N/A' }}</td>
                                                        <td class="p-2 border">{{ $fuel->me_24 ?? 'N/A' }}</td>
                                                        <td class="p-2 border">{{ $fuel->ae_24 ?? 'N/A' }}</td>
                                                        <td class="p-2 border">{{ $fuel->total_cons ?? 'N/A' }}</td>
                                                    </tr>

                                                    {{-- Lube Oils Section --}}
                                                    <tr class="bg-zinc-100 dark:bg-zinc-800 text-center font-semibold">
                                                        <td colspan="4" class="p-2 border">ME CYL</td>
                                                        <td colspan="3" class="p-2 border">ME CC</td>
                                                        <td colspan="3" class="p-2 border">AE CC</td>
                                                    </tr>
                                                    <tr>
                                                        <th class="p-2 border">Oil Grade</th>
                                                        <th class="p-2 border">Oil Quantity</th>
                                                        <th class="p-2 border">Total Run Hrs.</th>
                                                        <th class="p-2 border">Oil Cons.</th>

                                                        <th class="p-2 border">Oil Quantity</th>
                                                        <th class="p-2 border">Total Run Hrs.</th>
                                                        <th class="p-2 border">Oil Cons.</th>

                                                        <th class="p-2 border">Oil Quantity</th>
                                                        <th class="p-2 border">Total Run Hrs.</th>
                                                        <th class="p-2 border">Oil Cons.</th>
                                                    </tr>
                                                    <tr>
                                                        <td class="p-2 border">{{ $fuel->me_cyl_grade ?? 'N/A' }}</td>
                                                        <td class="p-2 border">{{ $fuel->me_cyl_qty ?? 'N/A' }}</td>
                                                        <td class="p-2 border">{{ $fuel->me_cyl_hrs ?? 'N/A' }}</td>
                                                        <td class="p-2 border">{{ $fuel->me_cyl_cons ?? 'N/A' }}</td>

                                                        <td class="p-2 border">{{ $fuel->me_cc_qty ?? 'N/A' }}</td>
                                                        <td class="p-2 border">{{ $fuel->me_cc_hrs ?? 'N/A' }}</td>
                                                        <td class="p-2 border">{{ $fuel->me_cc_cons ?? 'N/A' }}</td>

                                                        <td class="p-2 border">{{ $fuel->ae_cc_qty ?? 'N/A' }}</td>
                                                        <td class="p-2 border">{{ $fuel->ae_cc_hrs ?? 'N/A' }}</td>
                                                        <td class="p-2 border">{{ $fuel->ae_cc_cons ?? 'N/A' }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endforeach
                                </div>
                            @endif

                            <flux:separator />

                            @if ($report->remarks)
                                <flux:heading size="sm">Remarks</flux:heading>
                                <p class="text-sm whitespace-pre-line">{{ $report->remarks->remarks }}</p>
                            @endif

                            <flux:separator />

                            @if ($report->master_info)
                                <flux:heading size="sm">Master Information</flux:heading>
                                <p class="text-sm whitespace-pre-line">{{ $report->master_info->master_info }}</p>
                            @endif

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
