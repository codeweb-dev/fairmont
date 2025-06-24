<form wire:submit.prevent="save">
    <div class="mb-6 flex items-center justify-between w-full">
        <h1 class="text-3xl font-bold">KPI Report</h1>

        <div class="flex items-center gap-3">
            <flux:button icon:trailing="x-mark" variant="danger" wire:click="clearForm">
                Clear Fields
            </flux:button>
            <flux:button icon="folder-arrow-down" wire:click="saveDraft" variant="outline">
                Save Draft
            </flux:button>
            <flux:button href="{{ route('table-kpi-report') }}" wire:navigate icon:trailing="arrow-uturn-left">
                Go Back
            </flux:button>
        </div>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Vessel Information</flux:legend>

            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:input label="Vessel Name" badge="Required" disabled :value="$vesselName" />

                    <flux:select label="Fleet" badge="Required" required wire:model.defer="port">
                        <flux:select.option value="">Select Fleet</flux:select.option>
                        <flux:select.option value="1">1</flux:select.option>
                        <flux:select.option value="2">2</flux:select.option>
                        <flux:select.option value="3">3</flux:select.option>
                        <flux:select.option value="4">4</flux:select.option>
                        <flux:select.option value="5">5</flux:select.option>
                        <flux:select.option value="6">6</flux:select.option>
                        <flux:select.option value="FSOA">FSOA</flux:select.option>
                    </flux:select>

                    <flux:select label="Vessel Type" badge="Required" required wire:model.defer="gmt_offset">
                        <flux:select.option value="">Select Vessel Type</flux:select.option>
                        <flux:select.option value="Bulk">Bulk</flux:select.option>
                        <flux:select.option value="Container">Container</flux:select.option>
                        <flux:select.option value="Reefer">Reefer</flux:select.option>
                        <flux:select.option value="Tanker">Tanker</flux:select.option>
                        <flux:select.option value="Gas">Gas</flux:select.option>
                        <flux:select.option value="PCC">PCC</flux:select.option>
                        <flux:select.option value="PCTC">PCTC</flux:select.option>
                    </flux:select>

                    <flux:input label="Reporting Period" type="datetime-local" max="2999-12-31" badge="Required"
                        required wire:model.defer="all_fast_datetime" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Waste Management</flux:legend>

            <div class="grid grid-cols-2 gap-4">
                <flux:input label="Plastics Landed Ashore" wire:model.defer="plastics_landed_ashore" />
                <flux:input label="Plastics Incinerated" wire:model.defer="plastics_incinerated" />

                <flux:input label="Food Disposed at Sea" wire:model.defer="food_disposed_sea" />
                <flux:input label="Food Landed Ashore" wire:model.defer="food_landed_ashore" />

                <flux:input label="Domestic Waste Landed Ashore" wire:model.defer="domestic_landed_ashore" />
                <flux:input label="Domestic Waste Incinerated" wire:model.defer="domestic_incinerated" />

                <flux:input label="Cooking Oil Landed Ashore" wire:model.defer="cooking_oil_landed_ashore" />
                <flux:input label="Cooking Oil Incinerated" wire:model.defer="cooking_oil_incinerated" />

                <flux:input label="Incinerator Ash Landed Ashore" wire:model.defer="incinerator_ash_landed_ashore" />
                <flux:input label="Incinerator Ash Incinerated" wire:model.defer="incinerator_ash_incinerated" />

                <flux:input label="Operational Waste Landed Ashore" wire:model.defer="operational_landed_ashore" />
                <flux:input label="Operational Waste Incinerated" wire:model.defer="operational_incinerated" />

                <flux:input label="E-Waste Landed Ashore" wire:model.defer="ewaste_landed_ashore" />
                <flux:input label="Cargo Residues Landed Ashore" wire:model.defer="cargo_residues_landed_ashore" />

                <flux:input label="Total Garbage Disposed at Sea" wire:model.defer="total_garbage_disposed_sea" />
                <flux:input label="Total Garbage Landed Ashore" wire:model.defer="total_garbage_landed_ashore" />

                <flux:input label="Sludge Landed Ashore" wire:model.defer="sludge_landed_ashore" />
                <flux:input label="Sludge Incinerated" wire:model.defer="sludge_incinerated" />
                <flux:input label="Sludge Generated" wire:model.defer="sludge_generated" />
                <flux:input label="Fuel Consumed" wire:model.defer="fuel_consumed" />

                <flux:input label="Sludge to Bunker Ratio" wire:model.defer="sludge_bunker_ratio" />
                <flux:input label="Sludge Remarks" wire:model.defer="sludge_remarks" />

                <flux:input label="Bilge Discharged OWS" wire:model.defer="bilge_discharged_ows" />
                <flux:input label="Bilge Landed Ashore" wire:model.defer="bilge_landed_ashore" />
                <flux:input label="Bilge Generated" wire:model.defer="bilge_generated" />

                <flux:input label="Paper Consumption" wire:model.defer="paper_consumption" />
                <flux:input label="Printer Cartridges" wire:model.defer="printer_cartridges" />
                <flux:input label="Consumption Remarks" wire:model.defer="consumption_remarks" />

                <flux:input label="Fresh Water Generated" wire:model.defer="fresh_water_generated" />
                <flux:input label="Fresh Water Consumed" wire:model.defer="fresh_water_consumed" />

                <flux:input label="Ballast Exchanges" wire:model.defer="ballast_exchanges" />
                <flux:input label="Ballast Operations" wire:model.defer="ballast_operations" />
                <flux:input label="De-Ballast Operations" wire:model.defer="deballast_operations" />
                <flux:input label="Ballast Intake" wire:model.defer="ballast_intake" />
                <flux:input label="Ballast Out" wire:model.defer="ballast_out" />
                <flux:input label="Ballast Exchange Amount" wire:model.defer="ballast_exchange_amount" />

                <flux:input label="Propeller Cleanings" wire:model.defer="propeller_cleanings" />
                <flux:input label="Hull Cleanings" wire:model.defer="hull_cleanings" />
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Voyage Report</flux:legend>

            <div class="space-y-6">
                <div class="grid grid-cols-3 gap-x-4 gap-y-6">
                    <flux:input label="Total Sailing Days" wire:model.defer="call_sign" />
                    <flux:input label="Eco Speed Sailing Days" wire:model.defer="flag" />
                    <flux:input label="Full Speed Sailing Days" wire:model.defer="port_of_registry" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Crew</flux:legend>

            <div class="space-y-6">
                <div class="grid grid-cols-3 gap-x-4 gap-y-6">
                    <flux:input label="No. of Fatalities" wire:model.defer="official_number" />
                    <flux:input label="LTI (Lost Time Injuries)" wire:model.defer="imo_number" />
                    <flux:input label="No. of Recordable Injuries" wire:model.defer="class_society" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>MACN</flux:legend>

            <div class="space-y-6">
                <div class="w-full">
                    <flux:input label="No. of Corruption/Bribery/Entertainment for Port Officials"
                        wire:model.defer="class_no" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Inspection</flux:legend>

            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:input label="Number of PSC Inspections" wire:model.defer="pi_club" />
                    <flux:input label="PSC No. of Deficiencies" wire:model.defer="loa" />
                    <flux:input label="PSC Detentions (if any)" wire:model.defer="lbp" />
                    <flux:input label="Number of Flag State Inspections" wire:model.defer="breadth_extreme" />

                    <flux:input label="Flag No. of Deficiencies" wire:model.defer="depth_moulded" />
                    <flux:input label="Third Party Inspections (Charterers, Owners, RISQ, Others)"
                        wire:model.defer="height_maximum" />
                    <flux:input label="Third Party No. of Deficiencies" wire:model.defer="bridge_front_bow" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Overall Remarks</flux:legend>
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
