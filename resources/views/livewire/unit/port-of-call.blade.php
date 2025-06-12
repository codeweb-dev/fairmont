<form wire:submit.prevent="save">
    <div class="mb-6 flex items-center justify-between w-full">
        <flux:heading size="xl" class="font-bold">Port Of Call</flux:heading>

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
                    <!-- Row 1 -->
                    <flux:input label="Vessel Name" badge="Required" disabled :value="$vesselName" />
                    <flux:input label="Call Sign" required wire:model.defer="call_sign" />
                    <flux:input label="Flag" required wire:model.defer="flag" />
                    <flux:input label="Port of Registry" required wire:model.defer="port_of_registry" />

                    <!-- Row 2 -->
                    <flux:input label="Official Number" required wire:model.defer="official_number" />
                    <flux:input label="IMO Number" required wire:model.defer="imo_number" />
                    <flux:input label="Class Society" required wire:model.defer="class_society" />
                    <flux:input label="Class No" required wire:model.defer="class_no" />

                    <!-- Row 3 -->
                    <flux:input label="P&I Club" required wire:model.defer="pi_club" />
                    <flux:input label="LOA (Length Overall)" required wire:model.defer="loa" />
                    <flux:input label="LBP (Length Between Perpendiculars)" required wire:model.defer="lbp" />
                    <flux:input label="Breadth (extreme)" required wire:model.defer="breadth_extreme" />

                    <!-- Row 4 -->
                    <flux:input label="Depth (molded)" required wire:model.defer="depth_moulded" />
                    <flux:input label="Height (maximum)" required wire:model.defer="height_maximum" />
                    <flux:input label="Bridge Front - Bow" required wire:model.defer="bridge_front_bow" />
                    <flux:input label="Bridge Front - Stern" required wire:model.defer="bridge_front_stern" />

                    <!-- Row 5 -->
                    <flux:input label="Light Ship Displacement" required wire:model.defer="light_ship_displacement" />
                    <flux:input label="Keel Laid" type="date" required wire:model.defer="keel_laid" />
                    <flux:input label="Launched" type="date" required wire:model.defer="launched" />
                    <flux:input label="Delivered" type="date" required wire:model.defer="delivered" />

                    <flux:input label="Shipyard" required wire:model.defer="shipyard" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Deliverables</flux:legend>

            <flux:button wire:click="addPort" class="mb-6">Add New Port</flux:button>

            @foreach ($ports as $pIndex => $port)
                <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md space-y-6">
                    <div class="grid grid-cols-3 gap-4">
                        <flux:input label="Voyage No" wire:model="ports.{{ $pIndex }}.voyage_no" />
                        <flux:input label="Cargo" wire:model="ports.{{ $pIndex }}.cargo" />
                        <flux:input label="Charterers" wire:model="ports.{{ $pIndex }}.charterers" />
                    </div>

                    @foreach ($port['agents'] as $aIndex => $agent)
                        <div>
                            <div class="grid grid-cols-6 gap-3 items-end mt-2">
                                <flux:input label="Port of Calling"
                                    wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.port_of_calling" />
                                <flux:input label="Country"
                                    wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.country" />
                                <flux:input label="Purpose"
                                    wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.purpose" />
                                <flux:input label="ATA/ETA Date" type="date"
                                    wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.ata_eta_date" />
                                <flux:input label="ATA/ETA Time" type="time"
                                    wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.ata_eta_time" />
                                <flux:input label="Ship Info Date" type="date"
                                    wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.ship_info_date" />
                                <flux:input label="Ship Info Time" type="time"
                                    wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.ship_info_time" />
                                <flux:input label="GMT"
                                    wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.gmt" />
                                <flux:input label="Duration (Days)" type="number"
                                    wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.duration_days" />
                                <flux:input label="Total (Days)" type="number"
                                    wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.total_days" />
                                @if (count($port['agents']) > 1)
                                    <flux:button variant="danger" class="w-full" icon="trash"
                                        wire:click="removeAgent({{ $pIndex }}, {{ $aIndex }})" />
                                @endif
                            </div>

                            @if (count($port['agents']) > 1)
                                <flux:separator class="my-6" />
                            @endif
                        </div>
                    @endforeach

                    <div class="flex items-center gap-3 mt-4">
                        <flux:button icon="plus" variant="filled" size="sm"
                            wire:click="addAgent({{ $pIndex }})">
                            Add Agent
                        </flux:button>

                        @if (count($ports) > 1)
                            <flux:button variant="danger" size="sm"
                                wire:click="removePort({{ $pIndex }})">
                                Remove Port
                            </flux:button>
                        @endif
                    </div>
                </div>
            @endforeach
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
