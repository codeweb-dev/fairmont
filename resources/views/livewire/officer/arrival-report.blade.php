<div>
    <div class="mb-6 flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
        <h1 class="text-3xl font-bold">Arrival Reports</h1>

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

            @if (count($selectedReports) > 0)
                <div>
                    <flux:button wire:click="exportSelected" icon:trailing="inbox-arrow-down" variant="filled">
                        Export Selected ({{ count($selectedReports) }})
                    </flux:button>
                </div>
            @endif
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
                <th class="px-3 py-3">Unit</th>
                <th class="px-3 py-3">Date/Time (LT)</th>
                <th class="px-3 py-3"></th>
            </tr>
        </thead>

        @foreach ($reports as $report)
            <tr class="hover:bg-white/5 bg-black/5 transition-all">
                <td class="px-3 py-4">
                    <flux:checkbox wire:model.live="selectedReports" value="{{ $report->id }}" />
                </td>
                <td class="px-3 py-4">{{ $report->report_type }}</td>
                <td class="px-3 py-4">{{ $report->vessel->name }}</td>
                <td class="px-3 py-4">{{ $report->unit->name }}</td>
                <td class="px-3 py-4">{{ \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') }}
                </td>
                <td class="px-3 py-4">
                    <flux:dropdown>
                        <flux:button icon:trailing="ellipsis-horizontal" size="xs" variant="ghost" />

                        <flux:menu>
                            <flux:menu.radio.group>
                                <flux:modal.trigger name="view-arrival-{{ $report->id }}">
                                    <flux:menu.item icon="eye">
                                        View Details
                                    </flux:menu.item>
                                </flux:modal.trigger>
                            </flux:menu.radio.group>
                        </flux:menu>
                    </flux:dropdown>

                    <flux:modal name="view-arrival-{{ $report->id }}" class="min-w-[28rem] md:w-[64rem]">
                        <div class="space-y-6">
                            <flux:heading size="lg">Arrival Report Details</flux:heading>

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
                                    <p class="text-sm">
                                        {{ \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') }}
                                    </p>
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
                                    <flux:label>Arrival Type</flux:label>
                                    <p class="text-sm">{{ $report->port_gmt_offset }}</p>
                                </div>
                                <div>
                                    <flux:label>Arrival Port</flux:label>
                                    <p class="text-sm">{{ $report->supplier }}</p>
                                </div>
                                <div>
                                    <flux:label>Anchored Hours</flux:label>
                                    <p class="text-sm">{{ $report->call_sign ?? 'N/A' }}</p>
                                </div>
                                <div>
                                    <flux:label>Drifting Hours</flux:label>
                                    <p class="text-sm">{{ $report->flag ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <flux:separator />

                            @if ($report->noon_report)
                                <flux:heading size="sm">Details Since Last Report</flux:heading>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <flux:label>CP/Ordered Speed (Kts)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->cp_ordered_speed }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Allowed M/E Cons. at C/P Speed</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->me_cons_cp_speed }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Allowed M/E Cons. at C/P Speed</flux:label>
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
                                        <flux:label>Distance sailed from last port (NM)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->distance_to_go }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Breakdown (Hrs)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->breakdown }}</p>
                                    </div>
                                    <div>
                                        <flux:label>M/E Revs Counter (Noon to Noon)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->maneuvering_hours }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Avg RPM</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->avg_rpm }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Engine Distance (NM)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->engine_distance }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Slip (%)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->next_port }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Avg Power (KW)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->avg_power }}</p>
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
                                        <flux:label>Course (Deg)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->course }}</p>
                                    </div>
                                </div>

                                <flux:separator />

                                <flux:heading size="sm">Arrival Conditions</flux:heading>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <flux:label>Condition</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->condition }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Displacement (MT)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->displacement }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Cargo Name</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->cargo_name }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Cargo Weight (MT)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->cargo_weight }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Ballast Weight (MT)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->ballast_weight }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Fresh Water (MT)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->fresh_water }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Fwd Draft (m)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->fwd_draft }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Aft Draft (m)</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->aft_draft }}</p>
                                    </div>
                                    <div>
                                        <flux:label>GM</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->gm }}</p>
                                    </div>
                                </div>
                            @endif

                            <flux:separator />

                            @if ($report->rob_fuel_reports && $report->rob_fuel_reports->count())
                                <flux:heading size="sm">ROB Summary</flux:heading>

                                @foreach ($report->rob_fuel_reports as $fuel)
                                    <div class="border border-zinc-700 rounded-md p-4 mb-4">
                                        <flux:label class="text-base font-semibold mb-2 block">{{ $fuel->fuel_type }}
                                        </flux:label>
                                        <div class="grid grid-cols-2 gap-4 text-sm">
                                            <div>
                                                <flux:label>Previous</flux:label>
                                                <p>{{ $fuel->previous }}</p>
                                            </div>
                                            <div>
                                                <flux:label>Current</flux:label>
                                                <p>{{ $fuel->current }}</p>
                                            </div>

                                            <div>
                                                <flux:label>M/E Propulsion</flux:label>
                                                <p>{{ $fuel->me_propulsion }}</p>
                                            </div>
                                            <div>
                                                <flux:label>A/E Cons.</flux:label>
                                                <p>{{ $fuel->ae_cons }}</p>
                                            </div>
                                            <div>
                                                <flux:label>Boiler Cons.</flux:label>
                                                <p>{{ $fuel->boiler_cons }}</p>
                                            </div>
                                            <div>
                                                <flux:label>Incinerators</flux:label>
                                                <p>{{ $fuel->incinerators }}</p>
                                            </div>

                                            <div>
                                                <flux:label>M/E 24</flux:label>
                                                <p>{{ $fuel->me_24 }}</p>
                                            </div>
                                            <div>
                                                <flux:label>A/E 24</flux:label>
                                                <p>{{ $fuel->ae_24 }}</p>
                                            </div>
                                            <div>
                                                <flux:label>Total Cons.</flux:label>
                                                <p>{{ $fuel->total_cons }}</p>
                                            </div>
                                        </div>

                                        <flux:separator class="my-3" />

                                        <flux:label class="text-sm font-semibold mb-2 block">Lube Oils</flux:label>
                                        <div class="grid grid-cols-3 gap-4 text-sm">
                                            <div>
                                                <flux:label>ME CYL Grade</flux:label>
                                                <p>{{ $fuel->me_cyl_grade }}</p>
                                            </div>
                                            <div>
                                                <flux:label>Qty</flux:label>
                                                <p>{{ $fuel->me_cyl_qty }}</p>
                                            </div>
                                            <div>
                                                <flux:label>Hrs</flux:label>
                                                <p>{{ $fuel->me_cyl_hrs }}</p>
                                            </div>
                                            <div>
                                                <flux:label>Cons.</flux:label>
                                                <p>{{ $fuel->me_cyl_cons }}</p>
                                            </div>

                                            <div>
                                                <flux:label>ME CC Qty</flux:label>
                                                <p>{{ $fuel->me_cc_qty }}</p>
                                            </div>
                                            <div>
                                                <flux:label>ME CC Hrs</flux:label>
                                                <p>{{ $fuel->me_cc_hrs }}</p>
                                            </div>
                                            <div>
                                                <flux:label>ME CC Cons.</flux:label>
                                                <p>{{ $fuel->me_cc_cons }}</p>
                                            </div>

                                            <div>
                                                <flux:label>AE CC Qty</flux:label>
                                                <p>{{ $fuel->ae_cc_qty }}</p>
                                            </div>
                                            <div>
                                                <flux:label>AE CC Hrs</flux:label>
                                                <p>{{ $fuel->ae_cc_hrs }}</p>
                                            </div>
                                            <div>
                                                <flux:label>AE CC Cons.</flux:label>
                                                <p>{{ $fuel->ae_cc_cons }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif

                            <flux:separator />

                            @if ($report->master_info)
                                <flux:heading size="sm">Master Information</flux:heading>
                                <p class="text-sm whitespace-pre-line">{{ $report->master_info->master_info }}</p>
                            @endif

                            <flux:separator />

                            @if ($report->remarks)
                                <flux:heading size="sm">Remarks</flux:heading>
                                <p class="text-sm whitespace-pre-line">{{ $report->remarks->remarks }}</p>
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
