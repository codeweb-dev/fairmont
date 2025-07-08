<form wire:submit.prevent="save">
    <div class="mb-6 flex items-center justify-between w-full">
        <h1 class="text-3xl font-bold">Arrival Report</h1>

        <div class="flex items-center gap-3">
            <flux:button icon:trailing="x-mark" variant="danger" wire:click="clearForm"
                @click="Toaster.success('Fields cleared successfully.')">
                Clear Fields
            </flux:button>
            <flux:button icon="folder-arrow-down" wire:click="saveDraft" variant="outline"
                @click="Toaster.success('Draft saved successfully.')">
                Save Draft
            </flux:button>
            <flux:button href="{{ route('table-arrival-report') }}" wire:navigate icon:trailing="arrow-uturn-left">
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
                        :label="$port_gmt_offset === 'Pilot Station' ? 'EOSP Date/Time (LT)' : 'FWE Date/Time (LT)'"
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
                    <flux:select label="Arrival Type" badge="Required" required wire:model.live="port_gmt_offset">
                        <flux:select.option value="" disabled selected>Select Report Type</flux:select.option>
                        <flux:select.option value="Pilot Station">Pilot Station</flux:select.option>
                        <flux:select.option value="At Berth">At Berth</flux:select.option>
                        <flux:select.option value="To Anchorage">To Anchorage</flux:select.option>
                        <flux:select.option value="At Drifting">At Drifting</flux:select.option>
                    </flux:select>
                    <flux:input label="Arrival Port" badge="Required" required wire:model.defer="supplier" />

                    @if ($port_gmt_offset === 'Pilot Station')
                        <flux:input label="Anchored Hours" badge="Required" required wire:model.defer="call_sign" />
                        <flux:input label="Drifting Hours" badge="Required" required wire:model.defer="flag" />
                    @endif
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Details Since Last Report</flux:legend>
            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <!-- Row 1 -->
                    <flux:input label="CP/Ordered Speed (Kts)" wire:model.defer='cp_ordered_speed' />
                    <flux:input label="Allowed M/E Cons. at C/P Speed" wire:model.defer='me_cons_cp_speed' />
                    <flux:input label="Obs. Distance (NM)" wire:model.defer='obs_distance' />
                    <flux:input label="Steaming Time (Hrs)" wire:model.defer='steaming_time' />
                    <!-- Row 2 -->
                    <flux:input label="Avg Speed (Kts)" wire:model.defer='avg_speed' />
                    <flux:input label="Distance sailed from last port (NM)" wire:model.defer='distance_to_go' />
                    <flux:input label="Breakdown (Hrs)" wire:model.defer='breakdown' />
                    <flux:input label="M/E Revs Counter (Noon to Noon)" wire:model.defer='maneuvering_hours' />
                    <!-- Row 3 -->
                    <flux:input label="Avg RPM" wire:model.defer='avg_rpm' />
                    <flux:input label="Engine Distance (NM)" wire:model.defer='engine_distance' />
                    <flux:input label="Slip (%)" wire:model.defer='next_port' />
                    <flux:input label="Avg Power (KW)" wire:model.defer='avg_power' />
                    <!-- Row 4 -->
                    <flux:input label="Logged Distance (NM)" wire:model.defer='logged_distance' />
                    <flux:input label="Speed Through Water (Kts)" wire:model.defer='speed_through_water' />
                    <flux:input label="Course (Deg)" wire:model.defer='course' />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Arrival Conditions</flux:legend>
            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:select label="Condition" wire:model.defer="condition">
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
                        <tr class="border border-zinc-200 dark:border-zinc-700">
                            <th rowspan="2" class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">Bunker
                                Type</th>
                            <th colspan="2" class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">ROB (in
                                MT)</th>
                            <th colspan="4" class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                Consumption</th>
                            <th colspan="2" class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                Cons./24 hr</th>
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
                            <td class="px-4 py-2 font-semibold border-r border-zinc-200 dark:border-zinc-700">
                                {{ $type }} (MT)</td>
                            <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                <flux:input wire:model="rob_data.{{ $type }}.summary.previous" />
                            </td>
                            <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                <flux:input wire:model="rob_data.{{ $type }}.summary.current" />
                            </td>
                            <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                <flux:input wire:model="rob_data.{{ $type }}.summary.me_propulsion" />
                            </td>
                            <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                <flux:input wire:model="rob_data.{{ $type }}.summary.ae_cons" />
                            </td>
                            <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                <flux:input wire:model="rob_data.{{ $type }}.summary.boiler_cons" />
                            </td>
                            <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                <flux:input wire:model="rob_data.{{ $type }}.summary.incinerators" />
                            </td>
                            <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                <flux:input wire:model="rob_data.{{ $type }}.summary.me_24" />
                            </td>
                            <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
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
                        <tr class="border border-zinc-200 dark:border-zinc-700">
                            <th colspan="3" class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">ME CYL
                            </th>
                            <th colspan="3" class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">ME CC
                            </th>
                            <th colspan="3" class="px-4 py-2">AE CC</th>
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
                    <tbody>
                        <tr class="border border-zinc-200 dark:border-zinc-700">
                            <!-- ME CYL -->
                            <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                <flux:select wire:model="rob_data.{{ $type }}.summary.me_cyl_grade"
                                    placeholder="Select">
                                    <flux:select.option>TBN 100</flux:select.option>
                                    <flux:select.option>TBN 70</flux:select.option>
                                    <flux:select.option>TBN 40</flux:select.option>
                                </flux:select>
                            </td>
                            <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                <flux:input wire:model="rob_data.{{ $type }}.summary.me_cyl_qty" />
                            </td>
                            <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                <flux:input wire:model="rob_data.{{ $type }}.summary.me_cyl_hrs" />
                            </td>
                            <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                <flux:input wire:model="rob_data.{{ $type }}.summary.me_cyl_cons" />
                            </td>
                            <!-- ME CC -->
                            <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                <flux:input wire:model="rob_data.{{ $type }}.summary.me_cc_cons" />
                            </td>
                            <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                <flux:input wire:model="rob_data.{{ $type }}.summary.me_cc_qty" />
                            </td>
                            <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                <flux:input wire:model="rob_data.{{ $type }}.summary.me_cc_hrs" />
                            </td>
                            <!-- AE CC -->
                            <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
                                <flux:input wire:model="rob_data.{{ $type }}.summary.ae_cc_cons" />
                            </td>
                            <td class="px-4 py-2 border-r border-zinc-200 dark:border-zinc-700">
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
            <flux:legend>Master Information <flux:badge size="sm">Required</flux:badge>
            </flux:legend>
            <div class="space-y-6">
                <div class="w-full">
                    <flux:textarea rows="8" wire:model.defer="master_info" required />
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
