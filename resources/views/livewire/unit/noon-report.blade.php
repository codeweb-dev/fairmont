<form wire:submit.prevent="save">
    <div class="mb-6 flex items-center justify-between w-full">
        <flux:heading size="xl" class="font-bold">Noon Report</flux:heading>

        <div class="flex items-center gap-3">
            <flux:button icon:trailing="x-mark" variant="danger" wire:click="clearForm">
                Clear Fields
            </flux:button>
            {{-- <flux:button icon="folder-arrow-down">
                Save Draft
            </flux:button>
            <flux:button icon="arrow-down-tray" type="button" wire:click="export">
                Export Data
            </flux:button> --}}
        </div>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Voyage Details</flux:legend>

            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:input label="Vessel Name" badge="Required" disabled :value="$vesselName" />
                    <flux:input label="Voyage No" badge="Required" required wire:model.defer="voyage_no" />
                    <flux:select label="Report Type" badge="Required" required wire:model.live="port_gmt_offset">
                        <flux:select.option value="" disabled selected>Select Report Type</flux:select.option>
                        <flux:select.option value="At Sea">At Sea</flux:select.option>
                        <flux:select.option value="In Port">In Port</flux:select.option>
                        <flux:select.option value="At Anchorage">At Anchorage</flux:select.option>
                        <flux:select.option value="At Drifting">At Drifting</flux:select.option>
                    </flux:select>
                    <flux:input label="Date/Time (LT)" type="date" max="2999-12-31" badge="Required" required
                        wire:model.defer="all_fast_datetime" />
                    <flux:select label="GMT Offset" badge="Required" wire:model.defer="gmt_offset" required>
                        <flux:select.option value="" disabled selected>Select</flux:select.option>

                        @foreach ($gmtOffsets as $offset)
                            <flux:select.option value="{{ $offset }}">{{ $offset }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:input label="Latitude" badge="Required" required wire:model.defer="port" />
                    <flux:input label="Longitude" badge="Required" required wire:model.defer="bunkering_port" />

                    @if ($port_gmt_offset === 'In Port')
                        <flux:input label="Port of Departure" badge="Required" required wire:model.defer="supplier" />
                    @endif
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Details Since Last Report</flux:legend>
            <div class="space-y-6">
                @if ($port_gmt_offset === 'At Sea')
                    <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                        <!-- Row 1 -->
                        <flux:input label="CP/Ordered Speed (Kts)" wire:model.defer="cp_ordered_speed" />
                        <flux:input label="Allowed M/E Cons. at C/P Speed" wire:model.defer="me_cons_cp_speed" />
                        <flux:input label="Obs. Distance (NM)" wire:model.defer="obs_distance" />
                        <flux:input label="Steaming Time (Hrs)" wire:model.defer="steaming_time" />

                        <!-- Row 2 -->
                        <flux:input label="Avg Speed (Kts)" wire:model.defer="avg_speed" />
                        <flux:input label="Distance to go (NM)" wire:model.defer="distance_to_go" />
                        <flux:input label="Course (Deg)" wire:model.defer="course" />
                        <flux:input label="Breakdown (Hrs)" wire:model.defer="breakdown" />

                        <!-- Row 3 -->
                        <flux:input label="Avg RPM" wire:model.defer="avg_rpm" />
                        <flux:input label="Engine Distance (NM)" wire:model.defer="engine_distance" />
                        <flux:input label="Slip (%)" wire:model.defer="slip" />
                        <flux:input label="M/E Output (% MCR)" wire:model.defer="me_output_mcr" />

                        <!-- Row 4 -->
                        <flux:input label="Avg Power (KW)" wire:model.defer="avg_power" />
                        <flux:input label="Logged Distance (NM)" wire:model.defer="logged_distance" />
                        <flux:input label="Speed Through Water (Kts)" wire:model.defer="speed_through_water" />
                        <flux:input label="Next Port" wire:model.defer="next_port" />

                        <!-- Row 5 -->
                        <flux:input label="ETA Next Port (LT)" type="date" wire:model.defer="eta_next_port" />

                        <flux:select label="ETA GMT Offset" badge="Required" required wire:model.defer="eta_gmt_offset">
                            <flux:select.option value="" disabled selected>Select</flux:select.option>
                            @foreach ($gmtOffsets as $offset)
                                <flux:select.option value="{{ $offset }}">{{ $offset }}</flux:select.option>
                            @endforeach
                        </flux:select>

                        <flux:input label="Anchored Hours" wire:model.defer="anchored_hours" />
                        <flux:input label="Drifting Hours" wire:model.defer="drifting_hours" />
                    </div>
                @else
                    <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                        <!-- Row 1 -->
                        <flux:input label="CP/Ordered Speed (Kts)" wire:model.defer="cp_ordered_speed" />
                        <flux:input label="Allowed M/E Cons. at C/P Speed" wire:model.defer="me_cons_cp_speed" />
                        <flux:input label="Steaming Time (Hrs)" wire:model.defer="steaming_time" />
                        <flux:input label="Avg Speed (Kts)" wire:model.defer="avg_speed" />

                        <!-- Row 2 -->
                        <flux:input label="Course (DEG)" wire:model.defer="course" />
                        <flux:input label="Breakdown (Hrs)" wire:model.defer="breakdown" />
                        <flux:input label="Avg RPM" wire:model.defer="avg_rpm" />
                        <flux:input label="Engine Distance (NM)" wire:model.defer="engine_distance" />

                        <!-- Row 3 -->
                        <flux:input label="Slip (%)" wire:model.defer="slip" />
                        <flux:input label="M/E Output (% MCR)" wire:model.defer="me_output_mcr" />
                        <flux:input label="Anchored Hours" wire:model.defer="anchored_hours" />
                        <flux:input label="Drifting Hours" wire:model.defer="drifting_hours" />

                        <!-- Row 4 -->
                        @if ($port_gmt_offset === 'In Port')
                            <flux:input label="Maneuvering Hours" wire:model.defer="maneuvering_hours" />
                        @endif
                    </div>
                @endif
            </div>
        </flux:fieldset>
    </div>

    @if ($port_gmt_offset === 'At Sea')
        <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
            <flux:fieldset>
                <flux:legend>Voyage Itinerary</flux:legend>
                <div class="space-y-6">
                    <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                        <flux:input label="Next Port" wire:model.defer="next_port_voyage" />

                        <flux:select label="Via" badge="Required" required wire:model.defer="via">
                            <flux:select.option value="Direct">Direct</flux:select.option>
                            <flux:select.option>Cape Horn</flux:select.option>
                            <flux:select.option>Cape of Good Hope</flux:select.option>
                            <flux:select.option>Gibraltar</flux:select.option>
                            <flux:select.option>Magellan Strait</flux:select.option>
                            <flux:select.option>Panama Canal</flux:select.option>
                            <flux:select.option>Suez Canal</flux:select.option>
                        </flux:select>

                        <flux:input label="ETA (LT)" type="date" wire:model.defer="eta_lt" />

                        <flux:select label="GMT Offset" badge="Required" required
                            wire:model.defer="gmt_offset_voyage">
                            <flux:select.option value="" disabled selected>Select</flux:select.option>
                            @foreach ($gmtOffsets as $offset)
                                <flux:select.option value="{{ $offset }}">{{ $offset }}
                                </flux:select.option>
                            @endforeach
                        </flux:select>

                        <flux:input label="Distance to go" wire:model.defer="distance_to_go_voyage" />
                        <flux:input label="Projected Speed (kts)" wire:model.defer="projected_speed" />
                    </div>
                </div>
            </flux:fieldset>
        </div>
    @endif

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Noon Conditions</flux:legend>
            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:select label="Condition" badge="Required" required wire:model.defer="condition">
                        <flux:select.option value="Ballast">Ballast</flux:select.option>
                        <flux:select.option value="Laden">Laden</flux:select.option>
                    </flux:select>

                    <flux:input label="Displacement (MT)" wire:model.defer="displacement" />
                    <flux:input label="Cargo Name" wire:model.defer="cargo_name" />
                    <flux:input label="Cargo Weight (MT)" wire:model.defer="cargo_weight" />

                    <flux:input label="Ballast Weight (MT)" wire:model.defer="ballast_weight" />
                    <flux:input label="Fresh Water (MT)" wire:model.defer="fresh_water" />
                    <flux:input label="Fwd Draft (m)" wire:model.defer="fwd_draft" />
                    <flux:input label="Aft Draft (m)" wire:model.defer="aft_draft" />

                    <flux:input label="GM" wire:model.defer="gm" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Average Weather</flux:legend>
            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:input label="Wind Force (Bft.) (T)" wire:model.defer="wind_force_average_weather" />

                    <flux:select label="Swell" badge="Required" required wire:model.defer="swell">
                        <flux:select.option value="00 NO SWELL">00 NO SWELL</flux:select.option>
                        <flux:select.option value="01 LOW SWELL, SHORT OR AVERAGE LENGTH">01 LOW SWELL, SHORT OR
                            AVERAGE LENGTH</flux:select.option>
                        <flux:select.option value="02 LOW SWELL, LONG">02 LOW SWELL, LONG</flux:select.option>
                        <flux:select.option value="03 MODERATE SWELL, SHORT">03 MODERATE SWELL, SHORT
                        </flux:select.option>
                        <flux:select.option value="04 MODERATE SWELL, AVERAGE LENGTH">04 MODERATE SWELL, AVERAGE LENGTH
                        </flux:select.option>
                        <flux:select.option value="05 MODERATE SWELL, LONG">05 MODERATE SWELL, LONG
                        </flux:select.option>
                        <flux:select.option value="06 HEAVY SWELL, SHORT">06 HEAVY SWELL, SHORT</flux:select.option>
                        <flux:select.option value="07 HEAVY SWELL, AVERAGE LENGTH">07 HEAVY SWELL, AVERAGE LENGTH
                        </flux:select.option>
                        <flux:select.option value="08 HEAVY SWELL, LONG">08 HEAVY SWELL, LONG</flux:select.option>
                        <flux:select.option value="09 PROFUSE SWELL">09 PROFUSE SWELL</flux:select.option>
                        <flux:select.option value="10 NOT APPLICABLE">10 NOT APPLICABLE</flux:select.option>
                    </flux:select>

                    <flux:input label="Sea Currents (Kts) (Rel.)" wire:model.defer="sea_current" />
                    <flux:input label="Sea Temp (Deg. C)" wire:model.defer="sea_temp" />

                    <flux:select label="Observed Wind Dir. (T)" badge="Required" required
                        wire:model.defer="observed_wind">
                        <flux:select.option value="" disabled selected>Select</flux:select.option>
                        @foreach ($directions as $direction)
                            <flux:select.option value="{{ $direction }}">{{ $direction }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input label="Wind Sea Height (m)" wire:model.defer="wind_sea_height" />

                    <flux:select label="Sea Current Direction (Rel.)" badge="Required" required
                        wire:model.defer="sea_current_direction">
                        <flux:select.option value="">Select..</flux:select.option>
                        <flux:select.option value="Favorable">Favorable</flux:select.option>
                        <flux:select.option value="Againts">Againts</flux:select.option>
                    </flux:select>

                    <flux:input label="Swell Height (m)" wire:model.defer="swell_height" />

                    <flux:select label="Observed Sea Dir. (T)" badge="Required" required
                        wire:model.defer="observed_sea">
                        <flux:select.option value="" disabled selected>Select</flux:select.option>
                        @foreach ($directions as $direction)
                            <flux:select.option value="{{ $direction }}">{{ $direction }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input label="Air Temp (Deg. C)" wire:model.defer="air_temp" />

                    <flux:select label="Observed Swell Dir. (T)" badge="Required" required
                        wire:model.defer="observed_swell">
                        <flux:select.option value="" disabled selected>Select</flux:select.option>
                        @foreach ($directions as $direction)
                            <flux:select.option value="{{ $direction }}">{{ $direction }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input label="Sea DS" wire:model.defer="sea_ds" />
                    <flux:input label="Atm. Pressure (millibar)" wire:model.defer="atm_pressure" class="w-full" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Bad Weather Details</flux:legend>
            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:input label="Wind force (Bft.) >0 hrs (since last report)"
                        wire:model.defer="wind_force_previous" />
                    <flux:input label="Wind Force (Bft.) (continuous)" wire:model.defer="wind_force_current" />
                    <flux:input label="Sea State (DS) >0 hrs (since last report)"
                        wire:model.defer="sea_state_previous" />
                    <flux:input label="Sea State (continuous)" wire:model.defer="sea_state_current" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Wind Force/Dir for every six hours</flux:legend>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="text-white">
                            <th class="px-4 py-2">Time (LT)</th>
                            <th class="px-4 py-2">Wind Force (Bft.)</th>
                            <th class="px-4 py-2">Wind Direction (T)</th>
                            <th class="px-4 py-2">Swell Height (m)</th>
                            <th class="px-4 py-2">Swell Direction (T)</th>
                            <th class="px-4 py-2">Wind Sea Height (m)</th>
                            <th class="px-4 py-2">Sea Direction (T)</th>
                            <th class="px-4 py-2">Sea DS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($weather_blocks as $idx => $block)
                            <tr>
                                <td class="px-4 py-2 font-semibold">{{ $block['time_block'] }}</td>

                                <td class="px-4 py-2">
                                    <flux:select wire:model.defer="weather_blocks.{{ $idx }}.wind_force"
                                        label="" required>
                                        <flux:select.option value="" disabled selected>Select
                                        </flux:select.option>
                                        @foreach ($winds as $wind)
                                            <flux:select.option value="{{ $wind }}">{{ $wind }}
                                            </flux:select.option>
                                        @endforeach
                                    </flux:select>
                                </td>

                                <td class="px-4 py-2">
                                    <flux:select wire:model.defer="weather_blocks.{{ $idx }}.wind_direction"
                                        label="" required>
                                        <flux:select.option value="" disabled selected>Select
                                        </flux:select.option>
                                        @foreach ($directions as $direction)
                                            <flux:select.option value="{{ $direction }}">{{ $direction }}
                                            </flux:select.option>
                                        @endforeach
                                    </flux:select>
                                </td>

                                <td class="px-4 py-2">
                                    <flux:input wire:model.defer="weather_blocks.{{ $idx }}.swell_height"
                                        label="" />
                                </td>

                                <td class="px-4 py-2">
                                    <flux:select wire:model.defer="weather_blocks.{{ $idx }}.swell_direction"
                                        label="" required>
                                        <flux:select.option value="" disabled selected>Select
                                        </flux:select.option>
                                        @foreach ($directions as $direction)
                                            <flux:select.option value="{{ $direction }}">{{ $direction }}
                                            </flux:select.option>
                                        @endforeach
                                    </flux:select>
                                </td>

                                <td class="px-4 py-2">
                                    <flux:input wire:model.defer="weather_blocks.{{ $idx }}.wind_sea_height"
                                        label="" />
                                </td>

                                <td class="px-4 py-2">
                                    <flux:select wire:model.defer="weather_blocks.{{ $idx }}.sea_direction"
                                        label="" required>
                                        <flux:select.option value="" disabled selected>Select
                                        </flux:select.option>
                                        @foreach ($directions as $direction)
                                            <flux:select.option value="{{ $direction }}">{{ $direction }}
                                            </flux:select.option>
                                        @endforeach
                                    </flux:select>
                                </td>

                                <td class="px-4 py-2">
                                    <flux:select wire:model.defer="weather_blocks.{{ $idx }}.sea_ds"
                                        label="" required>
                                        <flux:select.option value="" disabled selected>Select
                                        </flux:select.option>
                                        @foreach ($seas as $sea)
                                            <flux:select.option value="{{ $sea }}">{{ $sea }}
                                            </flux:select.option>
                                        @endforeach
                                    </flux:select>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>ROB Details</flux:legend>

            <!-- Grade Buttons trigger modals -->
            <div class="flex space-x-6 mb-6 gap-3 items-center justify-center">
                @foreach (array_keys($rob_data) as $type)
                    <flux:modal.trigger name="rob-modal-{{ strtolower($type) }}">
                        <flux:button variant="primary">{{ $type }}</flux:button>
                    </flux:modal.trigger>
                @endforeach
            </div>
        </flux:fieldset>
    </div>

    @foreach (array_keys($rob_data) as $type)
        <flux:modal name="rob-modal-{{ strtolower($type) }}" class="max-w-full">
            <div class="space-y-8">
                <flux:heading size="lg">ROB Details - {{ $type }}</flux:heading>

                <!-- Tank Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full mb-8">
                        <thead>
                            <tr class="bg-zinc-800 text-white">
                                <th class="px-4 py-2">Tank No.</th>
                                <th class="px-4 py-2">Description</th>
                                <th class="px-4 py-2">Fuel Grade</th>
                                <th class="px-4 py-2">Capacity</th>
                                <th class="px-4 py-2">Unit</th>
                                <th class="px-4 py-2">ROB (MT)</th>
                                <th class="px-4 py-2">Supply Date (LT)</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rob_data[$type]['tanks'] as $index => $row)
                                <tr wire:key="{{ $type }}-{{ $index }}">
                                    <td class="px-4 py-2 w-10">
                                        <flux:input disabled placeholder="Tank No."
                                            wire:model="rob_data.{{ $type }}.tanks.{{ $index }}.tank_no" class="w-10" />
                                    </td>
                                    <td class="px-4 py-2">
                                        <flux:input
                                            wire:model="rob_data.{{ $type }}.tanks.{{ $index }}.description" />
                                    </td>
                                    <td class="px-4 py-2">
                                        <flux:select
                                            wire:model="rob_data.{{ $type }}.tanks.{{ $index }}.grade">
                                            <flux:select.option>{{ $type }}</flux:select.option>
                                            @foreach (array_keys($rob_data) as $other)
                                                @if ($other !== $type)
                                                    <flux:select.option>{{ $other }}</flux:select.option>
                                                @endif
                                            @endforeach
                                        </flux:select>
                                    </td>
                                    <td class="px-4 py-2">
                                        <flux:input
                                            wire:model="rob_data.{{ $type }}.tanks.{{ $index }}.capacity" />
                                    </td>
                                    <td class="px-4 py-2">
                                        <flux:select
                                            wire:model="rob_data.{{ $type }}.tanks.{{ $index }}.unit">
                                            <flux:select.option>MT</flux:select.option>
                                            <flux:select.option>L</flux:select.option>
                                            <flux:select.option>GAL</flux:select.option>
                                        </flux:select>
                                    </td>
                                    <td class="px-4 py-2">
                                        <flux:input
                                            wire:model="rob_data.{{ $type }}.tanks.{{ $index }}.rob" />
                                    </td>
                                    <td class="px-4 py-2">
                                        <flux:input type="date"
                                            wire:model="rob_data.{{ $type }}.tanks.{{ $index }}.supply_date" />
                                    </td>
                                    <td class="px-4 py-2">
                                        <flux:button icon="minus" variant="danger"
                                            wire:click="removeRobRow('{{ $type }}', {{ $index }})" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="flex items-end justify-end w-full">
                        <flux:button icon="plus" wire:click="addRobRow('{{ $type }}')" variant="primary">
                            Add Row
                        </flux:button>
                    </div>
                </div>

                <!-- ROB/Consumption Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full mb-8">
                        <thead>
                            <tr class="bg-zinc-800 text-white">
                                <th rowspan="2" class="px-4 py-2">Bunker Type</th>
                                <th colspan="2" class="px-4 py-2">ROB (in MT)</th>
                                <th colspan="4" class="px-4 py-2">Consumption</th>
                                <th colspan="2" class="px-4 py-2">Cons./24 hr</th>
                                <th rowspan="2" class="px-4 py-2">Total Cons.</th>
                            </tr>
                            <tr class="bg-zinc-800 text-white">
                                <th class="px-4 py-2">Previous</th>
                                <th class="px-4 py-2">Current</th>
                                <th class="px-4 py-2">M/E Propulsion</th>
                                <th class="px-4 py-2">A/E cons.</th>
                                <th class="px-4 py-2">Boiler cons.</th>
                                <th class="px-4 py-2">Incinerators</th>
                                <th class="px-4 py-2">M/E 24</th>
                                <th class="px-4 py-2">A/E 24</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-4 py-2 font-semibold">{{ $type }} (MT)</td>
                                <td class="px-4 py-2">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.previous" />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.current" />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.me_propulsion" />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.ae_cons" />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.boiler_cons" />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.incinerators" />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.me_24" />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.ae_24" />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.total_cons" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Oil Table -->
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                            <tr class="bg-zinc-800 text-white">
                                <th colspan="3" class="px-4 py-2">ME CYL</th>
                                <th colspan="3" class="px-4 py-2">ME CC</th>
                                <th colspan="3" class="px-4 py-2">AE CC</th>
                            </tr>
                            <tr class="bg-zinc-800 text-white">
                                <th class="px-4 py-2">Oil Grade</th>
                                <th class="px-4 py-2">Oil Quantity</th>
                                <th class="px-4 py-2">Total Runn Hrs.</th>
                                <th class="px-4 py-2">Oil Cons.</th>
                                <th class="px-4 py-2">Oil Quantity</th>
                                <th class="px-4 py-2">Total Run Hrs.</th>
                                <th class="px-4 py-2">Oil Cons.</th>
                                <th class="px-4 py-2">Oil Quantity</th>
                                <th class="px-4 py-2">Total Run Hrs.</th>
                                <th class="px-4 py-2">Oil Cons.</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <!-- ME CYL -->
                                <td class="px-4 py-2">
                                    <flux:select wire:model="rob_data.{{ $type }}.summary.me_cyl_grade">
                                        <flux:select.option>TBN 100</flux:select.option>
                                        <flux:select.option>TBN 70</flux:select.option>
                                        <flux:select.option>TBN 40</flux:select.option>
                                    </flux:select>
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.me_cyl_qty" />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.me_cyl_hrs" />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.me_cyl_cons" />
                                </td>
                                <!-- ME CC -->
                                <td class="px-4 py-2">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.me_cc_cons" />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.me_cc_qty" />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.me_cc_hrs" />
                                </td>
                                <!-- AE CC -->
                                <td class="px-4 py-2">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.ae_cc_cons" />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.ae_cc_qty" />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.ae_cc_hrs" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </flux:modal>
    @endforeach

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Bad Weather Details</flux:legend>
            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:input label="Wind force (Bft.) >0 hrs (since last report)"
                        wire:model.defer="wind_force_previous" />
                    <flux:input label="Wind Force (Bft.) (continuous)" wire:model.defer="wind_force_current" />
                    <flux:input label="Sea State (DS) >0 hrs (since last report)"
                        wire:model.defer="sea_state_previous" />
                    <flux:input label="Sea State (continuous)" wire:model.defer="sea_state_current" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Diesel Engine</flux:legend>
            <div class="space-y-6">
                <div class="grid grid-cols-3 gap-x-4 gap-y-6">
                    <flux:input label="DG1 Run Hours" wire:model.defer='dg1_run_hours' />
                    <flux:input label="DG2 Run Hours" wire:model.defer='dg2_run_hours' />
                    <flux:input label="DG3 Run Hours" wire:model.defer='dg3_run_hours' />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Remarks</flux:legend>
            <div class="space-y-6">
                <div class="w-full">
                    <flux:textarea rows="8" wire:model.defer="remarks" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Master's Info</flux:legend>
            <div class="space-y-6">
                <div class="w-full">
                    <flux:textarea rows="8" wire:model.defer="master_info" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="flex items-center justify-center w-full">
        <flux:button type="submit" icon="check">
            Submit
        </flux:button>
    </div>
</form>
