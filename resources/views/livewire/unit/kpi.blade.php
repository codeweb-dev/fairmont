<form wire:submit.prevent="save">
    <div class="mb-6 flex items-center justify-between w-full">
        <h1 class="text-3xl font-bold">KPI Report</h1>

        <div class="flex items-center gap-3">
            <flux:button icon:trailing="x-mark" variant="danger" wire:click="clearForm"
                @click="Toaster.success('Fields cleared successfully.')">
                Clear Fields
            </flux:button>
            <flux:button icon="folder-arrow-down" wire:click="saveDraft" variant="outline"
                @click="Toaster.success('Draft saved successfully.')">
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

                    <flux:input label="Fleet" badge="Required" required wire:model.defer="port" />

                    <flux:input label="Vessel Type" badge="Required" required wire:model.defer="gmt_offset" />

                    <flux:input label="Reporting Period" type="datetime-local" max="2999-12-31" badge="Required"
                        required wire:model.defer="all_fast_datetime" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Waste Management</flux:legend>

            <flux:separator />

            <div class="grid grid-cols-2 gap-4 mt-3">
                <div class="col-span-2">
                    <flux:heading>Plastics</flux:heading>
                </div>
                <flux:input label="Total Landed Ashore (m3)" wire:model.defer="plastics_landed_ashore" />
                <flux:input label="Total Incinerated (m3)" wire:model.defer="plastics_incinerated" />

                <div class="col-span-2">
                    <flux:separator class="my-3" />
                </div>

                <div class="col-span-2">
                    <flux:heading>Food Waste</flux:heading>
                </div>
                <flux:input label="Total Disposed at Sea (m3)" wire:model.defer="food_disposed_sea" />
                <flux:input label="Total Landed Ashore (m3)" wire:model.defer="food_landed_ashore" />

                <div class="col-span-2">
                    <flux:separator class="my-3" />
                </div>

                <div class="col-span-2">
                    <flux:heading>Domestic Waste</flux:heading>
                </div>
                <flux:input label="Total Landed Ashore (m3)" wire:model.defer="domestic_landed_ashore" />
                <flux:input label="Total Incinerated (m3)" wire:model.defer="domestic_incinerated" />

                <div class="col-span-2">
                    <flux:separator class="my-3" />
                </div>

                <div class="col-span-2">
                    <flux:heading>Cooking Oil</flux:heading>
                </div>
                <flux:input label="Total Landed Ashore (m3)" wire:model.defer="cooking_oil_landed_ashore" />
                <flux:input label="Total Incinerated (m3)" wire:model.defer="cooking_oil_incinerated" />

                <div class="col-span-2">
                    <flux:separator class="my-3" />
                </div>

                <div class="col-span-2">
                    <flux:heading>Incinerator Ash</flux:heading>
                </div>
                <flux:input label="Total Landed Ashore (m3)" wire:model.defer="incinerator_ash_landed_ashore" />
                <flux:input label="Total Incinerated (m3)" wire:model.defer="incinerator_ash_incinerated" />

                <div class="col-span-2">
                    <flux:separator class="my-3" />
                </div>

                <div class="col-span-2">
                    <flux:heading>Operational Waste</flux:heading>
                </div>
                <flux:input label="Total Landed Ashore (m3)" wire:model.defer="operational_landed_ashore" />
                <flux:input label="Total Incinerated (m3)" wire:model.defer="operational_incinerated" />

                <div class="col-span-2">
                    <flux:separator class="my-3" />
                </div>

                <div class="col-span-2">
                    <flux:heading class="mb-3">E-Waste</flux:heading>

                    <flux:input label="Total Landed Ashore (m3)" wire:model.defer="ewaste_landed_ashore" />
                </div>

                <div class="col-span-2">
                    <flux:separator class="my-3" />
                </div>

                <div class="col-span-2">
                    <flux:heading class="mb-3">Cargo Residues J/K</flux:heading>

                    <flux:input label="Total Landed Ashore (m3)" wire:model.defer="cargo_residues_landed_ashore" />
                </div>

                <div class="col-span-2">
                    <flux:separator class="my-3" />
                </div>

                <div class="col-span-2">
                    <flux:heading>Total Garbage</flux:heading>
                </div>
                <flux:input label="Total Disposed at Sea (m3)" wire:model.defer="total_garbage_disposed_sea" />
                <flux:input label="Total Garbage Landed Ashore (m3)" wire:model.defer="total_garbage_landed_ashore" />

                <div class="col-span-2">
                    <flux:separator class="my-3" />
                </div>

                <div class="col-span-2">
                    <flux:heading>Sludge & Bunker</flux:heading>
                </div>
                <flux:input label="Total Landed Ashore (m3)" wire:model.defer="sludge_landed_ashore" />
                <flux:input label="Total Incinerated (m3)" wire:model.defer="sludge_incinerated" />
                <flux:input label="Total Quantity of Sludge Generated (m3)" wire:model.defer="sludge_generated" />
                <flux:input label="Total Fuel Consumed (MT)" wire:model.defer="fuel_consumed" />

                <flux:input label="Ratio of Sludge Generated to Bunkers Consumed" wire:model.defer="sludge_bunker_ratio" />
                <flux:input label="Remarks (if target exceeded)" wire:model.defer="sludge_remarks" />

                <div class="col-span-2">
                    <flux:separator class="my-3" />
                </div>

                <div class="col-span-2">
                    <flux:heading>Bilge Water</flux:heading>
                </div>
                <flux:input label="Total Bilge Water Discharged Through OWS (m3)" wire:model.defer="bilge_discharged_ows" />
                <flux:input label="Total Bilge Water Landed to Shore (m3)" wire:model.defer="bilge_landed_ashore" />
                <flux:input label="Total Bilge Water Generated (m3)" wire:model.defer="bilge_generated" />

                <div class="col-span-2">
                    <flux:separator class="my-3" />
                </div>

                <div class="col-span-2">
                    <flux:heading>Consumption</flux:heading>
                </div>
                <flux:input label="Paper Consumption (reams)" wire:model.defer="paper_consumption" />
                <flux:input label="Printer Cartridges (units)" wire:model.defer="printer_cartridges" />
                <flux:input label="Remarks (if target exceeded)" wire:model.defer="consumption_remarks" />

                <div class="col-span-2">
                    <flux:separator class="my-3" />
                </div>

                <div class="col-span-2">
                    <flux:heading>Fresh Water</flux:heading>
                </div>
                <flux:input label="Fresh Water Generated (m3)" wire:model.defer="fresh_water_generated" />
                <flux:input label="Fresh Water Consumed (m3)" wire:model.defer="fresh_water_consumed" />

                <div class="col-span-2">
                    <flux:separator class="my-3" />
                </div>

                <div class="col-span-2">
                    <flux:heading>Ballast Water</flux:heading>
                </div>
                <flux:input label="Number of Ballast Water Exchanges Performed" wire:model.defer="ballast_exchanges" />
                <flux:input label="Number of Ballast Operations" wire:model.defer="ballast_operations" />
                <flux:input label="Number of De-Ballast Operations" wire:model.defer="deballast_operations" />
                <flux:input label="Total Water Intake During Ballasting (m3)" wire:model.defer="ballast_intake" />
                <flux:input label="Total Water Out During De-Ballasting (m3)" wire:model.defer="ballast_out" />
                <flux:input label="Total Ballast Water Exchange Amount (m3)" wire:model.defer="ballast_exchange_amount" />

                <div class="col-span-2">
                    <flux:separator class="my-3" />
                </div>

                <div class="col-span-2">
                    <flux:heading>Hull Management</flux:heading>
                </div>
                <flux:input label="Total Number of Propeller Cleanings" wire:model.defer="propeller_cleanings" />
                <flux:input label="Total Number of Hull Cleanings" wire:model.defer="hull_cleanings" />
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Sailing Days</flux:legend>

            <div class="space-y-6">
                <div class="grid grid-cols-3 gap-x-4 gap-y-6">
                    <flux:input label="Total" wire:model.defer="call_sign" />
                    <flux:input label="Eco Speed" wire:model.defer="flag" />
                    <flux:input label="Full Speed" wire:model.defer="port_of_registry" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Crew Matter</flux:legend>

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
            <flux:legend>Corruption</flux:legend>

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
