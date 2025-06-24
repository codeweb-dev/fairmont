<form wire:submit.prevent="save">
    <div class="mb-6 flex items-center justify-between w-full">
        <h1 class="text-3xl font-bold">Departure Report</h1>

        <div class="flex items-center gap-3">
            <flux:button icon:trailing="x-mark" variant="danger" wire:click="clearForm">
                Clear Fields
            </flux:button>
            <flux:button icon="folder-arrow-down" wire:click="saveDraft" variant="outline">
                Save Draft
            </flux:button>
            <flux:button href="{{ route('table-departure-report') }}" wire:navigate icon:trailing="arrow-uturn-left">
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
                    <flux:input label="Voyage No" badge="Required" required wire:model.defer="voyage_no" />
                    <flux:input
                        :label="$port_gmt_offset === 'Pilot Station' ? 'COSP Date/Time (LT)' : 'SBE Date/Time (LT)'"
                        type="datetime-local" max="2999-12-31" badge="Required" wire:model.defer="all_fast_datetime"
                        required />

                    <flux:select label="GMT Offset" badge="Required" wire:model.defer="gmt_offset" required>
                        <flux:select.option value="">Select</flux:select.option>
                        @foreach ($this->gmtOffsets as $offset)
                            <flux:select.option value="{{ $offset }}">{{ $offset }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input label="Latitude" badge="Required" required wire:model.defer="port" />
                    <flux:input label="Longitude" badge="Required" required wire:model.defer="bunkering_port" />
                    <flux:select label="Departure Type" badge="Required" required wire:model.live="port_gmt_offset">
                        <flux:select.option value="" disabled selected>Select Report Type</flux:select.option>
                        <flux:select.option value="Pilot Station">Pilot Station</flux:select.option>
                        <flux:select.option value="At Berth">At Berth</flux:select.option>
                        <flux:select.option value="From Anchorage">From Anchorage</flux:select.option>
                        <flux:select.option value="From Drifting">From Drifting</flux:select.option>
                    </flux:select>
                    <flux:input label="Departure Port" badge="Required" required wire:model.defer="supplier" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Details Since Last Report</flux:legend>
            <div class="space-y-6">
                <!-- All inputs in a 4-column grid, as in the image -->
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <!-- Row 1 -->
                    <flux:input label="CP/Ordered Speed (Kts)" wire:model.defer='cp_ordered_speed' />
                    <flux:input label="Obs. Distance (NM)" wire:model.defer='obs_distance' />
                    <flux:input label="Steaming Time (Hrs)" wire:model.defer='steaming_time' />
                    <flux:input label="Avg Speed (Kts)" wire:model.defer='avg_speed' />
                    <!-- Row 2 -->
                    <flux:input label="Distance to go (NM)" wire:model.defer='distance_to_go' />
                    <flux:input label="Avg RPM" wire:model.defer='avg_rpm' />
                    <flux:input label="Engine Distance (NM)" wire:model.defer='engine_distance' />
                    <flux:input label="Slip (%)" wire:model.defer='maneuvering_hours' />
                    <!-- Row 3 -->
                    <flux:input label="Avg Power (KW)" wire:model.defer='avg_power' />
                    <flux:input label="Course (Deg)" wire:model.defer='course' />
                    <flux:input label="Logged Distance (NM)" wire:model.defer='logged_distance' />
                    <flux:input label="Speed Through Water (Kts)" wire:model.defer='speed_through_water' />
                    <!-- Row 4: ETA fields, use col-span-2 to fill the row if desired -->
                    <div>
                        <flux:input label="Next Port" wire:model.defer="next_port" />
                    </div>
                    <div>
                        <flux:input label="ETA Next Port (LT)" type="datetime-local" wire:model.defer="eta_next_port" />
                    </div>
                    <div>
                        <flux:select label="ETA GMT Offset" wire:model.defer="eta_gmt_offset" required>
                            <flux:select.option value="">Select</flux:select.option>
                            @foreach ($this->gmtOffsets as $offset)
                                <flux:select.option value="{{ $offset }}">{{ $offset }}</flux:select.option>
                            @endforeach
                        </flux:select>
                    </div>
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Departure Conditions</flux:legend>
            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:select label="Condition" required wire:model.defer="condition" required>
                        <flux:select.option value="">Select</flux:select.option>
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
            <flux:legend>Voyage Itinerary</flux:legend>
            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:input label="Next Port" wire:model.defer="next_port_voyage" />

                    <flux:select label="Via" required wire:model.defer="via">
                        <flux:select.option value="">Select</flux:select.option>
                        <flux:select.option>Direct</flux:select.option>
                        <flux:select.option>Cape Horn</flux:select.option>
                        <flux:select.option>Cape of Good Hope</flux:select.option>
                        <flux:select.option>Gibraltar</flux:select.option>
                        <flux:select.option>Magellan Strait</flux:select.option>
                        <flux:select.option>Panama Canal</flux:select.option>
                        <flux:select.option>Suez Canal</flux:select.option>
                    </flux:select>

                    <flux:input label="ETA (LT)" type="datetime-local" wire:model.defer="eta_lt" />

                    <flux:select label="GMT Offset" required wire:model.defer="gmt_offset_voyage">
                        <flux:select.option value="">Select</flux:select.option>
                        @foreach ($this->gmtOffsets as $offset)
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
                                {{-- <flux:select wire:model="rob_data.{{ $type }}.summary.me_cyl_grade" required>
                                    <flux:select.option>TBN 100</flux:select.option>
                                    <flux:select.option>TBN 70</flux:select.option>
                                    <flux:select.option>TBN 40</flux:select.option>
                                </flux:select> --}}
                                <flux:radio.group wire:model="rob_data.{{ $type }}.summary.me_cyl_grade">
                                    <flux:radio value="TBN 100" label="TBN 100" checked />
                                    <flux:radio value="TBN 70" label="TBN 70" />
                                    <flux:radio value="TBN 40" label="TBN 40" />
                                </flux:radio.group>
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
        </flux:modal>
    @endforeach

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
