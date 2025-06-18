<div>
    <div class="mb-6 flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
        <h1 class="text-3xl font-bold">Arrival Reports</h1>

        <div class="flex items-center gap-3">
            <div class="max-w-64">
                <flux:input wire:model.live="search" placeholder="Search reports..." icon="magnifying-glass" />
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

    <x-admin-components.table :headers="['Report Type', 'Vessel', 'Unit', 'Voyage No', 'Arrival Port', 'Port GMT Offset', 'Date/Time (LT)', '']">
        @foreach ($reports as $report)
            <tr class="hover:bg-white/5 bg-black/5 transition-all">
                <td class="px-3 py-4">{{ $report->report_type }}</td>
                <td class="px-3 py-4">{{ $report->vessel->name }}</td>
                <td class="px-3 py-4">{{ $report->unit->name }}</td>
                <td class="px-3 py-4">{{ $report->voyage_no }}</td>
                <td class="px-3 py-4">{{ $report->supplier }}</td>
                <td class="px-3 py-4">{{ $report->port_gmt_offset }}</td>
                <td class="px-3 py-4">{{ \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y H:i') }}</td>
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

                                <flux:modal.trigger name="">
                                    <flux:menu.item icon="trash" variant="danger">
                                        Delete
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
                                    <flux:label>Unit</flux:label>
                                    <p class="text-sm">{{ $report->unit->name }}</p>
                                </div>
                                <div>
                                    <flux:label>Voyage No</flux:label>
                                    <p class="text-sm">{{ $report->voyage_no }}</p>
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
                                    <flux:label>Anchored Hours</flux:label>
                                    <p class="text-sm">{{ $report->call_sign ?? '-' }}</p>
                                </div>
                                <div>
                                    <flux:label>Drifting Hours</flux:label>
                                    <p class="text-sm">{{ $report->flag ?? '-' }}</p>
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
                                        <flux:label>Allowed M/E Cons.</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->me_cons_cp_speed }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Observed Distance</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->obs_distance }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Steaming Time</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->steaming_time }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Average Speed</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->avg_speed }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Distance to Go</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->distance_to_go }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Breakdown Hours</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->breakdown }}</p>
                                    </div>
                                    <div>
                                        <flux:label>M/E Revs Counter</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->maneuvering_hours }}</p>
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
                                        <flux:label>Slip %</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->slip }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Average Power</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->avg_power }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Logged Distance</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->logged_distance }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Speed Through Water</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->speed_through_water }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Course</flux:label>
                                        <p class="text-sm">{{ $report->noon_report->course }}</p>
                                    </div>
                                </div>

                                <flux:separator />

                                <flux:heading size="sm">Noon Conditions</flux:heading>
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
                                <flux:heading size="sm">Master's Info</flux:heading>
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
