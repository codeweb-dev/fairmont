<form wire:submit.prevent="save" x-data="autoSaveHandler()">
    <div class="mb-6 flex items-center justify-between w-full">
        <h1 class="text-3xl font-bold">Noon Report</h1>

        <div class="flex items-center gap-3">
            <flux:button icon:trailing="x-mark" variant="danger" wire:click="clearForm" @click="Toaster.success('Fields cleared successfully.')">
                Clear Fields
            </flux:button>
            {{-- <flux:button icon="folder-arrow-down" wire:click="saveDraft" variant="outline" @click="Toaster.success('Draft saved successfully.')">
                Save Draft
            </flux:button> --}}
            <flux:button href="{{ route('table-noon-report') }}" wire:navigate icon:trailing="arrow-uturn-left">
                Go Back
            </flux:button>
        </div>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Voyage Details</flux:legend>

            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:input label="Vessel Name" badge="Required" disabled :value="$vesselName" />
                    <flux:input label="Voyage No" badge="Required" required wire:model.defer="voyage_no" x-on:input="scheduleAutoSave" />
                    <flux:select label="Report Type" badge="Required" required wire:model.live="port_gmt_offset" x-on:input="scheduleAutoSave">
                        <flux:select.option value="">Select Report Type</flux:select.option>
                        <flux:select.option value="At Sea">At Sea</flux:select.option>
                        <flux:select.option value="In Port">In Port</flux:select.option>
                        <flux:select.option value="At Anchorage">At Anchorage</flux:select.option>
                        <flux:select.option value="At Drifting">At Drifting</flux:select.option>
                    </flux:select>
                    <flux:input label="Date/Time (LT)" type="datetime-local" max="2999-12-31" badge="Required" required
                        wire:model.defer="all_fast_datetime" x-on:input="scheduleAutoSave" />
                    <flux:select label="GMT Offset" required badge="Required" wire:model.defer="gmt_offset" required x-on:input="scheduleAutoSave">
                        <flux:select.option value="">Select GMT Offset</flux:select.option>
                        @foreach ($this->gmtOffsets as $offset)
                            <flux:select.option value="{{ $offset }}">{{ $offset }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:input label="Latitude" badge="Required" required wire:model.defer="port" x-on:input="scheduleAutoSave" />
                    <flux:input label="Longitude" badge="Required" required wire:model.defer="bunkering_port" x-on:input="scheduleAutoSave" />

                    @if ($port_gmt_offset === 'In Port')
                        <flux:input label="Port of Departure" badge="Required" required wire:model.defer="supplier" x-on:input="scheduleAutoSave" />
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
                    <div class="grid grid-cols-4 gap-x-4 gap-y-6" wire:key="at-sea-fields">
                        <!-- Row 1 -->
                        <flux:input label="CP/Ordered Speed (Kts)" wire:model.defer="cp_ordered_speed" x-on:input="scheduleAutoSave" />
                        <flux:input label="Allowed M/E Cons. at C/P Speed" wire:model.defer="me_cons_cp_speed" x-on:input="scheduleAutoSave" />
                        <flux:input label="Obs. Distance (NM)" wire:model.defer="obs_distance" x-on:input="scheduleAutoSave" />
                        <flux:input label="Steaming Time (Hrs)" wire:model.defer="steaming_time" x-on:input="scheduleAutoSave" />

                        <!-- Row 2 -->
                        <flux:input label="Avg Speed (Kts)" wire:model.defer="avg_speed" x-on:input="scheduleAutoSave" />
                        <flux:input label="Distance to go (NM)" wire:model.defer="distance_to_go" x-on:input="scheduleAutoSave" />
                        <flux:input label="Course (Deg)" wire:model.defer="course" x-on:input="scheduleAutoSave" />
                        <flux:input label="Breakdown (Hrs)" wire:model.defer="breakdown" x-on:input="scheduleAutoSave" />

                        <!-- Row 3 -->
                        <flux:input label="Avg RPM" wire:model.defer="avg_rpm" x-on:input="scheduleAutoSave" />
                        <flux:input label="Engine Distance (NM)" wire:model.defer="engine_distance" x-on:input="scheduleAutoSave" />
                        <flux:input label="Slip (%)" wire:model.defer="slip" x-on:input="scheduleAutoSave" />
                        <flux:input label="M/E Output (% MCR)" wire:model.defer="me_output_mcr" x-on:input="scheduleAutoSave" />

                        <!-- Row 4 -->
                        <flux:input label="Avg Power (KW)" wire:model.defer="avg_power" x-on:input="scheduleAutoSave" />
                        <flux:input label="Logged Distance (NM)" wire:model.defer="logged_distance" x-on:input="scheduleAutoSave" />
                        <flux:input label="Speed Through Water (Kts)" wire:model.defer="speed_through_water" x-on:input="scheduleAutoSave" />
                        <flux:input label="Next Port" wire:model.defer="next_port" x-on:input="scheduleAutoSave" />

                        <!-- Row 5 -->
                        <flux:input label="ETA Next Port (LT)" type="datetime-local" wire:model.defer="eta_next_port" x-on:input="scheduleAutoSave" />

                        <flux:select label="ETA GMT Offset" wire:model.defer="eta_gmt_offset" x-on:input="scheduleAutoSave">
                            <flux:select.option value="">Select</flux:select.option>
                            @foreach ($gmtOffsets as $offset)
                                <flux:select.option value="{{ $offset }}">{{ $offset }}</flux:select.option>
                            @endforeach
                        </flux:select>

                        <flux:input label="Anchored Hours" wire:model.defer="anchored_hours" x-on:input="scheduleAutoSave" />
                        <flux:input label="Drifting Hours" wire:model.defer="drifting_hours" x-on:input="scheduleAutoSave" />
                    </div>
                @else
                    <div class="grid grid-cols-4 gap-x-4 gap-y-6" wire:key="not-at-sea-fields">
                        <!-- Row 1 -->
                        <flux:input label="CP/Ordered Speed (Kts)" wire:model.defer="cp_ordered_speed" x-on:input="scheduleAutoSave" />
                        <flux:input label="Allowed M/E Cons. at C/P Speed" wire:model.defer="me_cons_cp_speed" x-on:input="scheduleAutoSave" />
                        <flux:input label="Steaming Time (Hrs)" wire:model.defer="steaming_time" x-on:input="scheduleAutoSave" />
                        <flux:input label="Avg Speed (Kts)" wire:model.defer="avg_speed" x-on:input="scheduleAutoSave" />

                        <!-- Row 2 -->
                        <flux:input label="Course (DEG)" wire:model.defer="course" x-on:input="scheduleAutoSave" />
                        <flux:input label="Breakdown (Hrs)" wire:model.defer="breakdown" x-on:input="scheduleAutoSave" />
                        <flux:input label="Avg RPM" wire:model.defer="avg_rpm" x-on:input="scheduleAutoSave" />
                        <flux:input label="Engine Distance (NM)" wire:model.defer="engine_distance" x-on:input="scheduleAutoSave" />

                        <!-- Row 3 -->
                        <flux:input label="Slip (%)" wire:model.defer="slip" x-on:input="scheduleAutoSave" />
                        <flux:input label="M/E Output (% MCR)" wire:model.defer="me_output_mcr" x-on:input="scheduleAutoSave" />
                        <flux:input label="Anchored Hours" wire:model.defer="anchored_hours" x-on:input="scheduleAutoSave" />
                        <flux:input label="Drifting Hours" wire:model.defer="drifting_hours" x-on:input="scheduleAutoSave" />

                        <!-- Row 4 -->
                        @if ($port_gmt_offset === 'In Port')
                            <flux:input label="Maneuvering Hours" wire:model.defer="maneuvering_hours" x-on:input="scheduleAutoSave" />
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
                        <flux:input label="Next Port" wire:model.defer="next_port_voyage" x-on:input="scheduleAutoSave" />

                        <flux:select label="Via" wire:model.defer="via" x-on:input="scheduleAutoSave">
                            <flux:select.option>Select</flux:select.option>
                            <flux:select.option>Direct</flux:select.option>
                            <flux:select.option>Cape Horn</flux:select.option>
                            <flux:select.option>Cape of Good Hope</flux:select.option>
                            <flux:select.option>Gibraltar</flux:select.option>
                            <flux:select.option>Magellan Strait</flux:select.option>
                            <flux:select.option>Panama Canal</flux:select.option>
                            <flux:select.option>Suez Canal</flux:select.option>
                        </flux:select>

                        <flux:input label="ETA (LT)" type="datetime-local" wire:model.defer="eta_lt" x-on:input="scheduleAutoSave" />

                        <flux:select label="GMT Offset" wire:model.defer="gmt_offset_voyage" x-on:input="scheduleAutoSave">
                            <flux:select.option value="">Select</flux:select.option>
                            @foreach ($gmtOffsets as $offset)
                                <flux:select.option value="{{ $offset }}">{{ $offset }}
                                </flux:select.option>
                            @endforeach
                        </flux:select>

                        <flux:input label="Distance to go" wire:model.defer="distance_to_go_voyage" x-on:input="scheduleAutoSave" />
                        <flux:input label="Projected Speed (kts)" wire:model.defer="projected_speed" x-on:input="scheduleAutoSave" />
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
                    <flux:select label="Condition" wire:model.defer="condition" x-on:input="scheduleAutoSave">
                        <flux:select.option value="">Select</flux:select.option>
                        <flux:select.option value="Ballast">Ballast</flux:select.option>
                        <flux:select.option value="Laden">Laden</flux:select.option>
                    </flux:select>

                    <flux:input label="Displacement (MT)" wire:model.defer="displacement" x-on:input="scheduleAutoSave" />
                    <flux:input label="Cargo Name" wire:model.defer="cargo_name" x-on:input="scheduleAutoSave" />
                    <flux:input label="Cargo Weight (MT)" wire:model.defer="cargo_weight" x-on:input="scheduleAutoSave" />

                    <flux:input label="Ballast Weight (MT)" wire:model.defer="ballast_weight" x-on:input="scheduleAutoSave" />
                    <flux:input label="Fresh Water (MT)" wire:model.defer="fresh_water" x-on:input="scheduleAutoSave" />
                    <flux:input label="Fwd Draft (m)" wire:model.defer="fwd_draft" x-on:input="scheduleAutoSave" />
                    <flux:input label="Aft Draft (m)" wire:model.defer="aft_draft" x-on:input="scheduleAutoSave" />

                    <flux:input label="GM" wire:model.defer="gm" x-on:input="scheduleAutoSave" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Average Weather</flux:legend>
            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:input label="Wind Force (Bft.) (T)" wire:model.defer="wind_force_average_weather" x-on:input="scheduleAutoSave" />

                    <flux:select label="Swell" wire:model.defer="swell" x-on:input="scheduleAutoSave">
                        <flux:select.option value="">Select</flux:select.option>
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

                    <flux:input label="Sea Currents (Kts) (Rel.)" wire:model.defer="sea_current" x-on:input="scheduleAutoSave" />
                    <flux:input label="Sea Temp (Deg. C)" wire:model.defer="sea_temp" x-on:input="scheduleAutoSave" />

                    <flux:select label="Observed Wind Dir. (T)" wire:model.defer="observed_wind" x-on:input="scheduleAutoSave">
                        <flux:select.option value="">Select</flux:select.option>
                        @foreach ($this->directions as $direction)
                            <flux:select.option value="{{ $direction }}">{{ $direction }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input label="Wind Sea Height (m)" wire:model.defer="wind_sea_height" x-on:input="scheduleAutoSave" />

                    <flux:select label="Sea Current Direction (Rel.)"
                        wire:model.defer="sea_current_direction" x-on:input="scheduleAutoSave">
                        <flux:select.option value="">Select</flux:select.option>
                        <flux:select.option value="Favorable">Favorable</flux:select.option>
                        <flux:select.option value="Againts">Againts</flux:select.option>
                    </flux:select>

                    <flux:input label="Swell Height (m)" wire:model.defer="swell_height" x-on:input="scheduleAutoSave" />

                    <flux:select label="Observed Sea Dir. (T)" wire:model.defer="observed_sea" x-on:input="scheduleAutoSave">
                        <flux:select.option value="">Select</flux:select.option>
                        @foreach ($this->directions as $direction)
                            <flux:select.option value="{{ $direction }}">{{ $direction }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input label="Air Temp (Deg. C)" wire:model.defer="air_temp" x-on:input="scheduleAutoSave" />

                    <flux:select label="Observed Swell Dir. (T)" wire:model.defer="observed_swell" x-on:input="scheduleAutoSave">
                        <flux:select.option value="">Select</flux:select.option>
                        @foreach ($this->directions as $direction)
                            <flux:select.option value="{{ $direction }}">{{ $direction }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input label="Sea DS" wire:model.defer="sea_ds" x-on:input="scheduleAutoSave" />
                    <flux:input label="Atm. Pressure (millibar)" wire:model.defer="atm_pressure" class="w-full" x-on:input="scheduleAutoSave" />
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
                        wire:model.defer="wind_force_previous" x-on:input="scheduleAutoSave" />
                    <flux:input label="Wind Force (Bft.) (continuous)" wire:model.defer="wind_force_current" x-on:input="scheduleAutoSave" />
                    <flux:input label="Sea State (DS) >0 hrs (since last report)"
                        wire:model.defer="sea_state_previous" x-on:input="scheduleAutoSave" />
                    <flux:input label="Sea State (continuous)" wire:model.defer="sea_state_current" x-on:input="scheduleAutoSave" />
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
                        <tr>
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
                                <td class="px-4 py-2 font-semibold text-sm w-36">{{ $block['time_block'] }}</td>

                                <td class="px-4 py-2">
                                    <flux:select wire:model.defer="weather_blocks.{{ $idx }}.wind_force"
                                        label="" x-on:input="scheduleAutoSave">
                                        <flux:select.option value="" disabled selected>Select
                                        </flux:select.option>
                                        @foreach ($this->winds as $wind)
                                            <flux:select.option value="{{ $wind }}">{{ $wind }}
                                            </flux:select.option>
                                        @endforeach
                                    </flux:select>
                                </td>

                                <td class="px-4 py-2">
                                    <flux:select wire:model.defer="weather_blocks.{{ $idx }}.wind_direction"
                                        label="" x-on:input="scheduleAutoSave">
                                        <flux:select.option value="" disabled selected>Select
                                        </flux:select.option>
                                        @foreach ($this->directions as $direction)
                                            <flux:select.option value="{{ $direction }}">{{ $direction }}
                                            </flux:select.option>
                                        @endforeach
                                    </flux:select>
                                </td>

                                <td class="px-4 py-2">
                                    <flux:input wire:model.defer="weather_blocks.{{ $idx }}.swell_height"
                                        label="" x-on:input="scheduleAutoSave" />
                                </td>

                                <td class="px-4 py-2">
                                    <flux:select wire:model.defer="weather_blocks.{{ $idx }}.swell_direction"
                                        label="" x-on:input="scheduleAutoSave">
                                        <flux:select.option value="" disabled selected>Select
                                        </flux:select.option>
                                        @foreach ($this->directions as $direction)
                                            <flux:select.option value="{{ $direction }}">{{ $direction }}
                                            </flux:select.option>
                                        @endforeach
                                    </flux:select>
                                </td>

                                <td class="px-4 py-2">
                                    <flux:input wire:model.defer="weather_blocks.{{ $idx }}.wind_sea_height"
                                        label="" x-on:input="scheduleAutoSave" />
                                </td>

                                <td class="px-4 py-2">
                                    <flux:select wire:model.defer="weather_blocks.{{ $idx }}.sea_direction"
                                        label="" x-on:input="scheduleAutoSave">
                                        <flux:select.option value="" disabled selected>Select
                                        </flux:select.option>
                                        @foreach ($this->directions as $direction)
                                            <flux:select.option value="{{ $direction }}">{{ $direction }}
                                            </flux:select.option>
                                        @endforeach
                                    </flux:select>
                                </td>

                                <td class="px-4 py-2">
                                    <flux:select wire:model.defer="weather_blocks.{{ $idx }}.sea_ds"
                                        label="" x-on:input="scheduleAutoSave">
                                        <flux:select.option value="" disabled selected>Select
                                        </flux:select.option>
                                        @foreach ($this->seas as $sea)
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
                            <tr class="border border-zinc-200 dark:border-zinc-700">
                                <th class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">Tank No.</th>
                                <th class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">Description</th>
                                <th class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">Fuel Grade</th>
                                <th class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">Capacity</th>
                                <th class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">Unit</th>
                                <th class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">ROB (MT)</th>
                                <th class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">Supply Date (LT)</th>
                                <th class="px-4 py-2">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rob_data[$type]['tanks'] as $index => $row)
                                <tr wire:key="{{ $type }}-{{ $index }}" class="border border-zinc-200 dark:border-zinc-700">
                                    <td class="px-4 py-2 w-10 border-r border-zinc-200 dark:border-zinc-700">
                                        <flux:input disabled placeholder="Tank No."
                                            wire:model="rob_data.{{ $type }}.tanks.{{ $index }}.tank_no"
                                            class="w-10" x-on:input="scheduleAutoSave" />
                                    </td>
                                    <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                        <flux:input
                                            wire:model="rob_data.{{ $type }}.tanks.{{ $index }}.description" x-on:input="scheduleAutoSave" />
                                    </td>
                                    <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                        <flux:select
                                            wire:model="rob_data.{{ $type }}.tanks.{{ $index }}.grade" class="cursor-not-allowed" disabled x-on:input="scheduleAutoSave">
                                            <flux:select.option>{{ $type }}</flux:select.option>
                                            @foreach (array_keys($rob_data) as $other)
                                                @if ($other !== $type)
                                                    <flux:select.option>{{ $other }}</flux:select.option>
                                                @endif
                                            @endforeach
                                        </flux:select>
                                    </td>
                                    <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                        <flux:input
                                            wire:model="rob_data.{{ $type }}.tanks.{{ $index }}.capacity" x-on:input="scheduleAutoSave" />
                                    </td>
                                    <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                        <flux:radio.group
                                            wire:model="rob_data.{{ $type }}.tanks.{{ $index }}.unit" x-on:input="scheduleAutoSave">
                                            <flux:radio value="MT" label="MT" checked />
                                            <flux:radio value="L" label="L" />
                                            <flux:radio value="GAL" label="GAL" />
                                        </flux:radio.group>
                                    </td>
                                    <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                        <flux:input
                                            wire:model="rob_data.{{ $type }}.tanks.{{ $index }}.rob" x-on:input="scheduleAutoSave" />
                                    </td>
                                    <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                        <flux:input type="datetime-local"
                                            wire:model="rob_data.{{ $type }}.tanks.{{ $index }}.supply_date" x-on:input="scheduleAutoSave" />
                                    </td>
                                    <td class="px-4 py-2">
                                        <flux:button icon="trash" variant="danger"
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
                    <table class="min-w-full border border-zinc-200 dark:border-zinc-700 mb-8">
                        <thead>
                            <tr class="border border-zinc-200 dark:border-zinc-700">
                                <th rowspan="2" class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">Bunker Type</th>
                                <th colspan="2" class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">ROB (in MT)</th>
                                <th colspan="4" class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">Consumption</th>
                                <th colspan="2" class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">Cons./24 hr</th>
                                <th rowspan="2" class="px-4 py-2">Total Cons.</th>
                            </tr>
                            <tr class="border border-zinc-200 dark:border-zinc-700">
                                <th class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">Previous</th>
                                <th class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">Current</th>
                                <th class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">M/E Propulsion</th>
                                <th class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">A/E cons.</th>
                                <th class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">Boiler cons.</th>
                                <th class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">Incinerators</th>
                                <th class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">M/E 24</th>
                                <th class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">A/E 24</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="border border-zinc-200 dark:border-zinc-700">
                                <td class="px-4 py-2 font-semibold border-r border-zinc-200 dark:border-zinc-700">{{ $type }} (MT)</td>
                                <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.previous" x-on:input="scheduleAutoSave" />
                                </td>
                                <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.current" x-on:input="scheduleAutoSave" />
                                </td>
                                <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.me_propulsion" x-on:input="scheduleAutoSave" />
                                </td>
                                <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.ae_cons" x-on:input="scheduleAutoSave" />
                                </td>
                                <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.boiler_cons" x-on:input="scheduleAutoSave" />
                                </td>
                                <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.incinerators" x-on:input="scheduleAutoSave" />
                                </td>
                                <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.me_24" x-on:input="scheduleAutoSave" />
                                </td>
                                <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.ae_24" x-on:input="scheduleAutoSave" />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.total_cons" x-on:input="scheduleAutoSave" />
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Oil Table -->
                <div class="overflow-x-auto mt-6">
                    <table class="min-w-full border border-zinc-200 dark:border-zinc-700">
                        <thead>
                            <tr class="border border-zinc-200 dark:border-zinc-700">
                                <th colspan="4" class="px-4 py-2 text-center border-r border-zinc-200 dark:border-zinc-700">ME CYL</th>
                                <th colspan="3" class="px-4 py-2 text-center border-r border-zinc-200 dark:border-zinc-700">ME CC</th>
                                <th colspan="3" class="px-4 py-2 text-center">AE CC</th>
                            </tr>
                            <tr class="border border-zinc-200 dark:border-zinc-700">
                                <th class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">Oil Grade</th>
                                <th class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">Oil Quantity</th>
                                <th class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">Total Runn Hrs.</th>
                                <th class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">Oil Cons.</th>
                                <th class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">Oil Quantity</th>
                                <th class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">Total Run Hrs.</th>
                                <th class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">Oil Cons.</th>
                                <th class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">Oil Quantity</th>
                                <th class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">Total Run Hrs.</th>
                                <th class="px-4 py-2">Oil Cons.</th>
                            </tr>
                        </thead>
                        <tbody class="border border-zinc-200 dark:border-zinc-700">
                            <tr class="border border-zinc-200 dark:border-zinc-700">
                                <!-- ME CYL -->
                                <td class="px-4 py-2  border-r border-zinc-200 dark:border-zinc-700">
                                    <flux:select wire:model="rob_data.{{ $type }}.summary.me_cyl_grade" placeholder="Select" x-on:input="scheduleAutoSave">
                                        <flux:select.option>TBN 100</flux:select.option>
                                        <flux:select.option>TBN 70</flux:select.option>
                                        <flux:select.option>TBN 40</flux:select.option>
                                    </flux:select>
                                </td>
                                <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.me_cyl_qty" x-on:input="scheduleAutoSave" />
                                </td>
                                <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.me_cyl_hrs" x-on:input="scheduleAutoSave" />
                                </td>
                                <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.me_cyl_cons" x-on:input="scheduleAutoSave" />
                                </td>
                                <!-- ME CC -->
                                <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.me_cc_cons" x-on:input="scheduleAutoSave" />
                                </td>
                                <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.me_cc_qty" x-on:input="scheduleAutoSave" />
                                </td>
                                <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.me_cc_hrs" x-on:input="scheduleAutoSave" />
                                </td>
                                <!-- AE CC -->
                                <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.ae_cc_cons" x-on:input="scheduleAutoSave" />
                                </td>
                                <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.ae_cc_qty" x-on:input="scheduleAutoSave" />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input wire:model="rob_data.{{ $type }}.summary.ae_cc_hrs" x-on:input="scheduleAutoSave" />
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
            <flux:legend>Diesel Engine</flux:legend>
            <div class="space-y-6">
                <div class="grid grid-cols-3 gap-x-4 gap-y-6">
                    <flux:input label="DG1 Run Hours" wire:model.defer='dg1_run_hours' x-on:input="scheduleAutoSave" />
                    <flux:input label="DG2 Run Hours" wire:model.defer='dg2_run_hours' x-on:input="scheduleAutoSave" />
                    <flux:input label="DG3 Run Hours" wire:model.defer='dg3_run_hours' x-on:input="scheduleAutoSave" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Remarks</flux:legend>
            <div class="space-y-6">
                <div class="w-full">
                    <flux:textarea rows="8" wire:model.defer="remarks" x-on:input="scheduleAutoSave" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Master Information <flux:badge size="sm">Required</flux:badge>
            </flux:legend>
            <div class="space-y-6">
                <div class="w-full">
                    <flux:textarea rows="8" wire:model.defer="master_info" required x-on:input="scheduleAutoSave" />
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

<script>
function autoSaveHandler() {
    return {
        autoSaveTimeout: null,

        scheduleAutoSave() {
            // Clear existing timeout
            if (this.autoSaveTimeout) {
                clearTimeout(this.autoSaveTimeout);
            }

            // Set new timeout for 2 seconds after user stops typing
            this.autoSaveTimeout = setTimeout(() => {
                this.triggerAutoSave();
            }, 2000);
        },

        async triggerAutoSave() {
            try {
                // Call the Livewire autoSave method
                await this.$wire.call('autoSave');
            } catch (error) {
                console.error('Auto-save failed:', error);
                // You could show an error toaster here if needed
            }
        }
    };
}
</script>

@push('scripts')
<script>
    // Listen for the draftSaved event from Livewire
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('draftSaved', () => {
            // Optional: Show additional feedback when manual save is triggered
            console.log('Draft saved successfully');
        });
    });
</script>
@endpush
