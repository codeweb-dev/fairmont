<div>
    <div class="mb-6 flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
        <h1 class="text-3xl font-bold">Noon Reports</h1>

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

    <x-admin-components.table :headers="['Report Type', 'Vessel', 'Unit', 'Date/Time (LT)', '']">
        @foreach ($reports as $report)
            <tr class="hover:bg-white/5 bg-black/5 transition-all">
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
                                <flux:modal.trigger name="view-report-{{ $report->id }}">
                                    <flux:menu.item icon="eye">
                                        View Details
                                    </flux:menu.item>
                                </flux:modal.trigger>

                                <flux:modal.trigger name="edit-report-{{ $report->id }}">
                                    <flux:menu.item icon="pencil-square">
                                        Edit
                                    </flux:menu.item>
                                </flux:modal.trigger>
                            </flux:menu.radio.group>
                        </flux:menu>
                    </flux:dropdown>

                    <flux:modal name="view-report-{{ $report->id }}" class="max-w-screen-lg">
                        <div class="space-y-6">
                            <flux:heading size="lg">Noon Report</flux:heading>

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
                                    <flux:label>Report Type</flux:label>
                                    <p class="text-sm">{{ $report->report_type }}</p>
                                </div>
                                <div>
                                    <flux:label>Date</flux:label>
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
                                    <flux:label>Port of Departure</flux:label>
                                    <p class="text-sm">{{ $report->supplier }}</p>
                                </div>
                            </div>

                            <flux:separator />

                            <!-- Details Since Last Report -->
                            <div>
                                <flux:label class="text-lg font-bold mb-2">Details Since Last Report</flux:label>
                                <div class="grid grid-cols-4 gap-4">
                                    <div>
                                        <flux:label>CP/Ordered Speed (Kts)</flux:label>
                                        <p>{{ $report->noon_report->cp_ordered_speed ?? 'Empty' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Allowed M/E Cons. at C/P Speed</flux:label>
                                        <p>{{ $report->noon_report->me_cons_cp_speed ?? 'Empty' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Obs. Distance (NM)</flux:label>
                                        <p>{{ $report->noon_report->obs_distance ?? 'Empty' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Steaming Time (Hrs)</flux:label>
                                        <p>{{ $report->noon_report->steaming_time ?? 'Empty' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Avg Speed (Kts)</flux:label>
                                        <p>{{ $report->noon_report->avg_speed ?? 'Empty' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Distance to go (NM)</flux:label>
                                        <p>{{ $report->noon_report->distance_to_go ?? 'Empty' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Course (Deg)</flux:label>
                                        <p>{{ $report->noon_report->course ?? 'Empty' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Breakdown (Hrs)</flux:label>
                                        <p>{{ $report->noon_report->breakdown ?? 'Empty' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Average RPM</flux:label>
                                        <p>{{ $report->noon_report->avg_rpm ?? 'Empty' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Engine Distance (NM)</flux:label>
                                        <p>{{ $report->noon_report->engine_distance ?? 'Empty' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Slip (%)</flux:label>
                                        <p>{{ $report->noon_report->slip ?? 'Empty' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>M/E Output (% MCR)</flux:label>
                                        <p>{{ $report->noon_report->me_output_mcr ?? 'Empty' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Average Power (kW)</flux:label>
                                        <p>{{ $report->noon_report->avg_power ?? 'Empty' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Logged Distance (NM)</flux:label>
                                        <p>{{ $report->noon_report->logged_distance ?? 'Empty' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Speed Through Water (Kn)</flux:label>
                                        <p>{{ $report->noon_report->speed_through_water ?? 'Empty' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Next Port</flux:label>
                                        <p>{{ $report->noon_report->next_port ?? 'Empty' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>ETA Next Port</flux:label>
                                        <p>{{ $report->noon_report->eta_next_port ?? 'Empty' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>ETA GMT Offset</flux:label>
                                        <p>{{ $report->noon_report->eta_gmt_offset ?? 'Empty' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Anchored Hours</flux:label>
                                        <p>{{ $report->noon_report->anchored_hours ?? 'Empty' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Drifting Hours</flux:label>
                                        <p>{{ $report->noon_report->drifting_hours ?? 'Empty' }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Maneuvering Hours</flux:label>
                                        <p>{{ $report->noon_report->maneuvering_hours ?? 'Empty' }}</p>
                                    </div>
                                </div>
                            </div>

                            <flux:separator />

                            <!-- Noon Conditions -->
                            <div class="pt-4">
                                <flux:label class="font-bold text-lg mb-2">Noon Conditions</flux:label>
                                <div class="grid grid-cols-4 gap-4">
                                    <div>
                                        <flux:label>Condition</flux:label>
                                        <p>{{ $report->noon_report->condition }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Displacement (MT)</flux:label>
                                        <p>{{ $report->noon_report->displacement }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Cargo Name</flux:label>
                                        <p>{{ $report->noon_report->cargo_name }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Cargo Weight (MT)</flux:label>
                                        <p>{{ $report->noon_report->cargo_weight }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Ballast Weight (MT)</flux:label>
                                        <p>{{ $report->noon_report->ballast_weight }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Fresh Water (MT)</flux:label>
                                        <p>{{ $report->noon_report->fresh_water }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Fwd Draft (m)</flux:label>
                                        <p>{{ $report->noon_report->fwd_draft }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Aft Draft (m)</flux:label>
                                        <p>{{ $report->noon_report->aft_draft }}</p>
                                    </div>
                                    <div>
                                        <flux:label>GM</flux:label>
                                        <p>{{ $report->noon_report->gm }}</p>
                                    </div>
                                </div>
                            </div>

                            <flux:separator />

                            <div>
                                <flux:label class="text-lg font-bold mb-2">Average Weather</flux:label>
                                <div class="grid grid-cols-4 gap-4">
                                    <div>
                                        <flux:label>Wind Force (Bft.) (T)</flux:label>
                                        <p>{{ $report->noon_report->wind_force_average_weather }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Swell</flux:label>
                                        <p>{{ $report->noon_report->swell }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Sea Current (Kts) (Rel.)</flux:label>
                                        <p>{{ $report->noon_report->sea_current }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Sea Temp (Deg. °C)</flux:label>
                                        <p>{{ $report->noon_report->sea_temp }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Observed Wind Dir. (T)</flux:label>
                                        <p>{{ $report->noon_report->observed_wind }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Wind Sea Height (m)</flux:label>
                                        <p>{{ $report->noon_report->wind_sea_height }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Sea Current Direction. (Rel.)</flux:label>
                                        <p>{{ $report->noon_report->sea_current_direction }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Swell Height (m)</flux:label>
                                        <p>{{ $report->noon_report->swell_height }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Observed Sea Dir. (T)</flux:label>
                                        <p>{{ $report->noon_report->observed_sea }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Air Temp (Deg. °C)</flux:label>
                                        <p>{{ $report->noon_report->air_temp }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Observed Swell Dir. (T)</flux:label>
                                        <p>{{ $report->noon_report->observed_swell }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Sea DS</flux:label>
                                        <p>{{ $report->noon_report->sea_ds }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Atm. Pressure (millibar)</flux:label>
                                        <p>{{ $report->noon_report->atm_pressure }}</p>
                                    </div>
                                </div>
                            </div>

                            <flux:separator />

                            <div>
                                <flux:label class="text-lg font-bold mb-2">Bad Weather Details</flux:label>
                                <div class="grid grid-cols-4 gap-4">
                                    <div>
                                        <flux:label>Wind force (Bft.) >0 hrs (since last report)</flux:label>
                                        <p>{{ $report->noon_report->wind_force_previous }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Wind Force (Bft.) (continuous)</flux:label>
                                        <p>{{ $report->noon_report->wind_force_current }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Sea State (DS) >0 hrs (since last report)</flux:label>
                                        <p>{{ $report->noon_report->sea_state_previous }}</p>
                                    </div>
                                    <div>
                                        <flux:label>Sea State (continuous)</flux:label>
                                        <p>{{ $report->noon_report->sea_state_current }}</p>
                                    </div>
                                </div>
                            </div>

                            <flux:separator />

                            <div>
                                <flux:label class="text-lg font-bold mb-2">Wind & Sea (Every 6 Hours)</flux:label>
                                <div class="overflow-x-auto">
                                    <table class="min-w-full text-sm border-collapse border border-zinc-700">
                                        <thead>
                                            <tr class="bg-zinc-800 text-white">
                                                <th class="p-2 border">Time Block</th>
                                                <th class="p-2 border">Wind Force</th>
                                                <th class="p-2 border">Wind Dir</th>
                                                <th class="p-2 border">Swell Height</th>
                                                <th class="p-2 border">Swell Dir</th>
                                                <th class="p-2 border">Wind Sea Height</th>
                                                <th class="p-2 border">Sea Dir</th>
                                                <th class="p-2 border">Sea DS</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($report->weather_observations ?? [] as $block)
                                                <tr>
                                                    <td class="p-2 border">{{ $block->time_block }}</td>
                                                    <td class="p-2 border">{{ $block->wind_force }}</td>
                                                    <td class="p-2 border">{{ $block->wind_direction }}</td>
                                                    <td class="p-2 border">{{ $block->swell_height }}</td>
                                                    <td class="p-2 border">{{ $block->swell_direction }}</td>
                                                    <td class="p-2 border">{{ $block->wind_sea_height }}</td>
                                                    <td class="p-2 border">{{ $block->sea_direction }}</td>
                                                    <td class="p-2 border">{{ $block->sea_ds }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <flux:separator />

                            <!-- ROB Tanks -->
                            <div>
                                <flux:label class="mb-2">ROB Tanks</flux:label>
                                @foreach ($report->rob_tanks->groupBy('grade') as $grade => $tanks)
                                    <p class="font-semibold mt-4">{{ $grade }}</p>
                                    <table class="w-full text-sm border-collapse border border-zinc-700 mb-4">
                                        <thead>
                                            <tr class="bg-zinc-800 text-white">
                                                <th class="p-2 border">Tank No</th>
                                                <th class="p-2 border">Description</th>
                                                <th class="p-2 border">Fuel Grade</th>
                                                <th class="p-2 border">Capacity</th>
                                                <th class="p-2 border">Unit</th>
                                                <th class="p-2 border">ROB</th>
                                                <th class="p-2 border">Supply Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($tanks as $tank)
                                                <tr>
                                                    <td class="p-2 border">{{ $tank->tank_no }}</td>
                                                    <td class="p-2 border">{{ $tank->description }}</td>
                                                    <td class="p-2 border">{{ $tank->grade }}</td>
                                                    <td class="p-2 border">{{ $tank->capacity }}</td>
                                                    <td class="p-2 border">{{ $tank->unit }}</td>
                                                    <td class="p-2 border">{{ $tank->rob }}</td>
                                                    <td class="p-2 border">
                                                        {{ $tank->supply_date ? \Carbon\Carbon::parse($tank->supply_date)->format('M d, Y') : '-' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endforeach
                            </div>

                            <flux:separator />

                            <!-- ROB Summary -->
                            <div>
                                <flux:label class="mb-2">ROB Summary</flux:label>
                                <div class="w-full">
                                    @foreach ($report->rob_fuel_reports as $summary)
                                        <div
                                            class="grid grid-cols-2 border border-zinc-700 p-4 rounded-md bg-zinc-900/40">
                                            <div class="space-y-2">
                                                <p class="font-bold mb-2">{{ $summary->fuel_type }}</p>
                                                <p><strong>Previous:</strong> {{ $summary->previous }}</p>
                                                <p><strong>Current:</strong> {{ $summary->current }}</p>
                                                <p><strong>M/E Propulsion:</strong> {{ $summary->me_propulsion }}</p>
                                                <p><strong>A/E Cons.:</strong> {{ $summary->ae_cons }}</p>
                                                <p><strong>Boiler Cons.:</strong> {{ $summary->boiler_cons }}</p>
                                                <p><strong>Incinerators:</strong> {{ $summary->incinerators }}</p>
                                                <p><strong>M/E 24hr:</strong> {{ $summary->me_24 }}</p>
                                                <p><strong>A/E 24hr:</strong> {{ $summary->ae_24 }}</p>
                                                <p><strong>Total Cons.:</strong> {{ $summary->total_cons }}</p>
                                            </div>

                                            <div class="space-y-2">
                                                <p class="font-bold">ME CYL</p>
                                                <p><strong>Oil Grade:</strong> {{ $summary->me_cyl_grade }}</p>
                                                <p><strong>Oil Qty:</strong> {{ $summary->me_cyl_qty }}</p>
                                                <p><strong>Total Run Hrs.:</strong> {{ $summary->me_cyl_hrs }}</p>
                                                <p><strong>Oil Cons.:</strong> {{ $summary->me_cyl_cons }}</p>

                                                <p class="font-bold mt-4">ME CC</p>
                                                <p><strong>Oil Qty:</strong> {{ $summary->me_cc_qty }}</p>
                                                <p><strong>Total Run Hrs.:</strong> {{ $summary->me_cc_hrs }}</p>
                                                <p><strong>Oil Cons.:</strong> {{ $summary->me_cc_cons }}</p>

                                                <p class="font-bold mt-4">AE CC</p>
                                                <p><strong>Oil Qty:</strong> {{ $summary->ae_cc_qty }}</p>
                                                <p><strong>Total Run Hrs.:</strong> {{ $summary->ae_cc_hrs }}</p>
                                                <p><strong>Oil Cons.:</strong> {{ $summary->ae_cc_cons }}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <flux:separator />

                            <!-- Diesel Engine -->
                            <div>
                                <flux:label class="font-bold text-lg">Diesel Engine Hours</flux:label>
                                <div class="grid grid-cols-3 gap-4">
                                    <div>
                                        <flux:label>DG1 Run Hours</flux:label>
                                        <p>{{ $report->noon_report->dg1_run_hours }}</p>
                                    </div>
                                    <div>
                                        <flux:label>DG2 Run Hours</flux:label>
                                        <p>{{ $report->noon_report->dg2_run_hours }}</p>
                                    </div>
                                    <div>
                                        <flux:label>DG3 Run Hours</flux:label>
                                        <p>{{ $report->noon_report->dg3_run_hours }}</p>
                                    </div>
                                </div>
                            </div>

                            <flux:separator />

                            <!-- Remarks -->
                            <div>
                                <flux:label class="font-bold text-lg">Remarks</flux:label>
                                <p class="text-sm">{{ $report->remarks->remarks ?? '-' }}</p>
                            </div>

                            <flux:separator />

                            <!-- Master's Info -->
                            <div>
                                <flux:label class="font-bold text-lg">Master's Info</flux:label>
                                <p class="text-sm whitespace-pre-line">{{ $report->master_info->master_info ?? '-' }}
                                </p>
                            </div>

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
