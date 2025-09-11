<div>
    <div class="flex flex-col gap-6 mb-6">
        <div class="flex flex-col md:flex-row gap-6 md:gap-0 items-center justify-between w-full">
            <h1 class="text-3xl font-bold">Noon Reports</h1>

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
                    <th class="px-3 py-3">Vessel Name</th>
                    <th class="px-3 py-3">Voyage No</th>
                    <th class="px-3 py-3">Noon Report Type</th>
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
                <tr class="hover:bg-white/5 bg-black/5 transition-all" wire:key="noon-row-{{ $report->id }}">
                    <td class="px-3 py-4">{{ $report->report_type }}</td>
                    <td class="px-3 py-4">{{ $report->vessel->name }}</td>
                    <td class="px-3 py-4">{{ $report->voyage_no }}</td>
                    <td class="px-3 py-4">{{ $report->port_gmt_offset }}</td>
                    <td class="px-3 py-4">
                        {{ \Carbon\Carbon::parse($report->created_at)->timezone('Asia/Manila')->format('M d, Y h:i A') }}
                    </td>
                    <td class="px-3 py-4">{{ $report->unit->name }}</td>
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

                                    <flux:modal.trigger name="delete-report-{{ $report->id }}">
                                        <flux:menu.item icon="trash" variant="danger">
                                            Delete
                                        </flux:menu.item>
                                    </flux:modal.trigger>
                                </flux:menu.radio.group>
                            </flux:menu>
                        </flux:dropdown>

                        <flux:modal name="view-report-{{ $report->id }}" class="max-w-screen"
                            wire:key="noon-view-modal-{{ $report->id }}">
                            <div class="space-y-6">
                                <flux:heading size="lg">Noon Report</flux:heading>

                                <div>
                                    <flux:label class="text-lg font-bold mb-2">Voyage Details</flux:label>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <flux:label>Vessel Name</flux:label>
                                            <p class="text-sm">{{ $report->vessel->name }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Voyage No</flux:label>
                                            <p class="text-sm">{{ $report->voyage_no }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Report Type</flux:label>
                                            <p class="text-sm">{{ $report->port_gmt_offset }}</p>
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
                                            <p class="text-sm">{{ $report->supplier ?? '' }}</p>
                                        </div>
                                    </div>
                                </div>

                                <flux:separator />

                                <!-- Details Since Last Report -->
                                <div>
                                    <flux:label class="text-lg font-bold mb-2">Details Since Last Report</flux:label>
                                    <div class="grid grid-cols-4 gap-4">
                                        <div>
                                            <flux:label>CP/Ordered Speed (Kts)</flux:label>
                                            <p>{{ $report->noon_report->cp_ordered_speed ?? '' }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Allowed M/E Cons. at C/P Speed</flux:label>
                                            <p>{{ $report->noon_report->me_cons_cp_speed ?? '' }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Obs. Distance (NM)</flux:label>
                                            <p>{{ $report->noon_report->obs_distance ?? '' }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Steaming Time (Hrs)</flux:label>
                                            <p>{{ $report->noon_report->steaming_time ?? '' }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Avg Speed (Kts)</flux:label>
                                            <p>{{ $report->noon_report->avg_speed ?? '' }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Distance to go (NM)</flux:label>
                                            <p>{{ $report->noon_report->distance_to_go ?? '' }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Course (Deg)</flux:label>
                                            <p>{{ $report->noon_report->course ?? '' }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Breakdown (Hrs)</flux:label>
                                            <p>{{ $report->noon_report->breakdown ?? '' }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Avg RPM</flux:label>
                                            <p>{{ $report->noon_report->avg_rpm ?? '' }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Engine Distance (NM)</flux:label>
                                            <p>{{ $report->noon_report->engine_distance ?? '' }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Slip (%)</flux:label>
                                            <p>{{ $report->noon_report->slip ?? '' }}</p>
                                        </div>
                                        <div>
                                            <flux:label>M/E Output (% MCR)</flux:label>
                                            <p>{{ $report->noon_report->me_output_mcr ?? '' }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Avg Power (kW)</flux:label>
                                            <p>{{ $report->noon_report->avg_power ?? '' }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Logged Distance (NM)</flux:label>
                                            <p>{{ $report->noon_report->logged_distance ?? '' }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Speed Through Water (Kts)</flux:label>
                                            <p>{{ $report->noon_report->speed_through_water ?? '' }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Next Port</flux:label>
                                            <p>{{ $report->noon_report->next_port ?? '' }}</p>
                                        </div>
                                        <div>
                                            <flux:label>ETA Next Port</flux:label>
                                            <p>{{ $report->noon_report->eta_next_port ? \Carbon\Carbon::parse($report->noon_report->eta_next_port)->format('M d, Y h:i A') : '' }}
                                            </p>
                                        </div>
                                        <div>
                                            <flux:label>ETA GMT Offset</flux:label>
                                            <p>{{ $report->noon_report->eta_gmt_offset ?? '' }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Anchored Hours</flux:label>
                                            <p>{{ $report->noon_report->anchored_hours ?? '' }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Drifting Hours</flux:label>
                                            <p>{{ $report->noon_report->drifting_hours ?? '' }}</p>
                                        </div>
                                        <div>
                                            <flux:label>Maneuvering Hours</flux:label>
                                            <p>{{ $report->noon_report->maneuvering_hours ?? '' }}</p>
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

                                <!-- Via -->
                                @isset($report->port_gmt_offset)
                                    @if (trim($report->port_gmt_offset) === 'At Sea')
                                        <!-- Via -->
                                        <div class="pt-4">
                                            <flux:label class="font-bold text-lg mb-2">Voyage Itinerary</flux:label>
                                            <div class="grid grid-cols-4 gap-4">
                                                <div>
                                                    <flux:label>Next Port</flux:label>
                                                    <p>{{ $report->noon_report->next_port_voyage }}</p>
                                                </div>
                                                <div>
                                                    <flux:label>Via</flux:label>
                                                    <p>{{ $report->noon_report->via }}</p>
                                                </div>
                                                <div>
                                                    <flux:label>ETA (LT)</flux:label>
                                                    <p>{{ $report->noon_report->eta_lt }}</p>
                                                </div>
                                                <div>
                                                    <flux:label>GMT Offset</flux:label>
                                                    <p>{{ $report->noon_report->gmt_offset_voyage }}</p>
                                                </div>
                                                <div>
                                                    <flux:label>Distance to go</flux:label>
                                                    <p>{{ $report->noon_report->distance_to_go_voyage }}</p>
                                                </div>
                                                <div>
                                                    <flux:label>Projected Speed (kts)</flux:label>
                                                    <p>{{ $report->noon_report->projected_speed }}</p>
                                                </div>
                                            </div>
                                        </div>

                                        <flux:separator />
                                    @endif
                                @endisset

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
                                        <table
                                            class="min-w-full text-sm border-collapse border border-zinc-200 dark:border-zinc-700">
                                            <thead>
                                                <tr>
                                                    <th class="p-2 border border-zinc-200 dark:border-zinc-700">Time
                                                        Block
                                                    </th>
                                                    <th class="p-2 border border-zinc-200 dark:border-zinc-700">Wind
                                                        Force
                                                    </th>
                                                    <th class="p-2 border border-zinc-200 dark:border-zinc-700">Wind Dir
                                                    </th>
                                                    <th class="p-2 border border-zinc-200 dark:border-zinc-700">Swell
                                                        Height
                                                    </th>
                                                    <th class="p-2 border border-zinc-200 dark:border-zinc-700">Swell
                                                        Dir
                                                    </th>
                                                    <th class="p-2 border border-zinc-200 dark:border-zinc-700">Wind Sea
                                                        Height</th>
                                                    <th class="p-2 border border-zinc-200 dark:border-zinc-700">Sea Dir
                                                    </th>
                                                    <th class="p-2 border border-zinc-200 dark:border-zinc-700">Sea DS
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($report->weather_observations ?? [] as $block)
                                                    <tr>
                                                        <td class="p-2 border border-zinc-200 dark:border-zinc-700">
                                                            {{ $block->time_block }}</td>
                                                        <td class="p-2 border border-zinc-200 dark:border-zinc-700">
                                                            {{ $block->wind_force }}</td>
                                                        <td class="p-2 border border-zinc-200 dark:border-zinc-700">
                                                            {{ $block->wind_direction }}</td>
                                                        <td class="p-2 border border-zinc-200 dark:border-zinc-700">
                                                            {{ $block->swell_height }}</td>
                                                        <td class="p-2 border border-zinc-200 dark:border-zinc-700">
                                                            {{ $block->swell_direction }}</td>
                                                        <td class="p-2 border border-zinc-200 dark:border-zinc-700">
                                                            {{ $block->wind_sea_height }}</td>
                                                        <td class="p-2 border border-zinc-200 dark:border-zinc-700">
                                                            {{ $block->sea_direction }}</td>
                                                        <td class="p-2 border border-zinc-200 dark:border-zinc-700">
                                                            {{ $block->sea_ds }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <flux:separator />

                                <!-- ROB Tanks -->
                                <div>
                                    <flux:label class="mb-2">ROB Summary</flux:label>
                                    @foreach ($report->rob_tanks->groupBy('grade') as $grade => $tanks)
                                        <p class="font-semibold mt-4">{{ $grade }}</p>
                                        <table
                                            class="w-full text-sm border-collapse border border-zinc-200 dark:border-zinc-700 mb-4">
                                            <thead>
                                                <tr>
                                                    <th class="p-2 border border-zinc-200 dark:border-zinc-700">Tank No
                                                    </th>
                                                    <th class="p-2 border border-zinc-200 dark:border-zinc-700">
                                                        Description
                                                    </th>
                                                    <th class="p-2 border border-zinc-200 dark:border-zinc-700">Fuel
                                                        Grade
                                                    </th>
                                                    <th class="p-2 border border-zinc-200 dark:border-zinc-700">Capacity
                                                    </th>
                                                    <th class="p-2 border border-zinc-200 dark:border-zinc-700">Unit
                                                    </th>
                                                    <th class="p-2 border border-zinc-200 dark:border-zinc-700">ROB (MT)
                                                    </th>
                                                    <th class="p-2 border border-zinc-200 dark:border-zinc-700">Supply
                                                        Date
                                                        (LT)
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach ($tanks as $tank)
                                                    <tr>
                                                        <td class="p-2 border border-zinc-200 dark:border-zinc-700">
                                                            {{ $tank->tank_no }}</td>
                                                        <td class="p-2 border border-zinc-200 dark:border-zinc-700">
                                                            {{ $tank->description }}</td>
                                                        <td class="p-2 border border-zinc-200 dark:border-zinc-700">
                                                            {{ $tank->grade }}</td>
                                                        <td class="p-2 border border-zinc-200 dark:border-zinc-700">
                                                            {{ $tank->capacity }}</td>
                                                        <td class="p-2 border border-zinc-200 dark:border-zinc-700">
                                                            {{ $tank->unit }}</td>
                                                        <td class="p-2 border border-zinc-200 dark:border-zinc-700">
                                                            {{ $tank->rob }}</td>
                                                        <td class="p-2 border border-zinc-200 dark:border-zinc-700">
                                                            {{ $tank->supply_date ? \Carbon\Carbon::parse($tank->supply_date)->format('M d, Y h:i A') : '-' }}
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @endforeach
                                </div>

                                <flux:separator />
                                <!-- Fuel Summary Table -->
                                <div class="overflow-x-auto mt-6">
                                    <table class="min-w-full border border-zinc-200 dark:border-zinc-700">
                                        <thead>
                                            <tr>
                                                <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700 text-center"
                                                    rowspan="2">Bunker Type</th>
                                                <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700 text-center"
                                                    colspan="2">ROB (in MT)</th>
                                                <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700 text-center"
                                                    colspan="4">Consumption</th>
                                                <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700 text-center"
                                                    colspan="2">Cons./24hr</th>
                                                <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700 text-center"
                                                    rowspan="2">Total Cons.</th>
                                            </tr>
                                            <tr class="border border-zinc-200 dark:border-zinc-700">
                                                <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                    Previous
                                                </th>
                                                <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                    Current
                                                </th>
                                                <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">M/E
                                                    Propulsion</th>
                                                <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">A/E
                                                    Cons.
                                                </th>
                                                <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                    Boiler
                                                    Cons.</th>
                                                <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                    Incinerators</th>
                                                <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">M/E
                                                    24hr
                                                </th>
                                                <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">A/E
                                                    24hr
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($report->rob_fuel_reports as $summary)
                                                <tr class="border border-zinc-200 dark:border-zinc-700">
                                                    <td
                                                        class="px-4 py-2 font-semibold border border-zinc-200 dark:border-zinc-700">
                                                        {{ $summary->fuel_type }}
                                                    </td>
                                                    <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                        {{ $summary->previous }}</td>
                                                    <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                        {{ $summary->current }}</td>
                                                    <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                        {{ $summary->me_propulsion }}</td>
                                                    <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                        {{ $summary->ae_cons }}</td>
                                                    <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                        {{ $summary->boiler_cons }}</td>
                                                    <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                        {{ $summary->incinerators }}</td>
                                                    <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                        {{ $summary->me_24 }}</td>
                                                    <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                        {{ $summary->ae_24 }}</td>
                                                    <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                        {{ $summary->total_cons }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Lube Oil Table -->
                                <div class="overflow-x-auto mt-10">
                                    <table class="min-w-full border border-zinc-200 dark:border-zinc-700">
                                        <thead>
                                            <tr class="border-zinc-200 dark:border-zinc-700 text-center font-semibold">
                                                <td colspan="4"
                                                    class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                    ME CYL</td>
                                                <td colspan="3"
                                                    class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                    ME CC</td>
                                                <td colspan="3"
                                                    class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                    AE CC</td>
                                            </tr>
                                            <tr class="border border-zinc-200 dark:border-zinc-700">
                                                <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">Oil
                                                    Grade
                                                </th>

                                                <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">Oil
                                                    Quantity</th>
                                                <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">Total
                                                    Runn Hrs.</th>
                                                <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">Oil
                                                    Cons.
                                                </th>

                                                <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">Oil
                                                    Quantity</th>
                                                <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">Total
                                                    Runn Hrs.</th>
                                                <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">Oil
                                                    Cons.</th>

                                                <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">Oil
                                                    Quantity</th>
                                                <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">Total
                                                    Runn Hrs.</th>
                                                <th class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">Oil
                                                    Cons.</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($report->rob_fuel_reports as $summary)
                                                <tr class="border border-zinc-200 dark:border-zinc-700">
                                                    <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                        {{ $summary->me_cyl_grade }}</td>
                                                    <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                        {{ $summary->me_cyl_qty }}</td>
                                                    <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                        {{ $summary->me_cyl_hrs }}</td>
                                                    <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                        {{ $summary->me_cyl_cons }}</td>

                                                    <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                        {{ $summary->me_cc_cons }}</td>
                                                    <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                        {{ $summary->me_cc_qty }}</td>
                                                    <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                        {{ $summary->me_cc_hrs }}</td>

                                                    <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                        {{ $summary->ae_cc_cons }}</td>
                                                    <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                        {{ $summary->ae_cc_qty }}</td>
                                                    <td class="px-4 py-2 border border-zinc-200 dark:border-zinc-700">
                                                        {{ $summary->ae_cc_hrs }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
                                    <p class="text-sm">{{ $report->remarks->remarks ?? '' }}</p>
                                </div>

                                <flux:separator />

                                <!-- Master Information -->
                                <div>
                                    <flux:label class="font-bold text-lg">Master Information</flux:label>
                                    <p class="text-sm whitespace-pre-line">
                                        {{ $report->master_info->master_info ?? '-' }}
                                    </p>
                                </div>

                                <div class="flex justify-end pt-4">
                                    <flux:modal.close>
                                        <flux:button variant="primary">Close</flux:button>
                                    </flux:modal.close>
                                </div>
                            </div>
                        </flux:modal>

                        <flux:modal name="delete-report-{{ $report->id }}" class="min-w-[22rem]"
                        wire:key="noon-delete-modal-{{ $report->id }}">
                            <div class="space-y-6">
                                <div>
                                    <flux:heading size="lg">Soft Delete Report?</flux:heading>
                                    <flux:text class="mt-2">
                                        Are you sure you want to delete the Noon Report? <br> This report will not be
                                        permanently deleted and can be restored if needed.
                                    </flux:text>
                                </div>

                                <div class="flex gap-2">
                                    <flux:spacer />
                                    <flux:modal.close>
                                        <flux:button variant="ghost">Cancel</flux:button>
                                    </flux:modal.close>
                                    <flux:button type="button" variant="danger"
                                        wire:click="delete({{ $report->id }})">
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
</div>
