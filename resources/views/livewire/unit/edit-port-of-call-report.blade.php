<form wire:submit.prevent="update">
    <div class="mb-6 flex items-center justify-between w-full">
        <h1 class="text-3xl font-bold">Edit Port Of Call Report</h1>

        <div class="flex items-center gap-3">
            <flux:button href="{{ route('table-port-of-call-report') }}" wire:navigate icon:trailing="arrow-uturn-left">
                Go Back
            </flux:button>
        </div>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Vessel Details</flux:legend>
            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:input label="Vessel Name" disabled :value="$vesselName" />
                    <flux:input label="Call Sign" wire:model="call_sign" />
                    <flux:input label="Flag" wire:model="flag" />
                    <flux:input label="Port of Registry" wire:model="port_of_registry" />

                    <flux:input label="Official Number" wire:model="official_number" />
                    <flux:input label="IMO Number" wire:model="imo_number" />
                    <flux:input label="Class Society" wire:model="class_society" />
                    <flux:input label="Class No" wire:model="class_no" />

                    <flux:input label="P&I Club" wire:model="pi_club" />
                    <flux:input label="LOA (Length Overall)" wire:model="loa" />
                    <flux:input label="LBP (Length Between Perpendiculars)" wire:model="lbp" />
                    <flux:input label="Breadth (extreme)" wire:model="breadth_extreme" />

                    <flux:input label="Depth (molded)" wire:model="depth_moulded" />
                    <flux:input label="Height (maximum)" wire:model="height_maximum" />
                    <flux:input label="Bridge Front - Bow" wire:model="bridge_front_bow" />
                    <flux:input label="Bridge Front - Stern" wire:model="bridge_front_stern" />

                    <flux:input label="Light Ship Displacement" wire:model="light_ship_displacement" />
                    <flux:input label="Keel Laid" type="datetime-local" wire:model="keel_laid" />
                    <flux:input label="Launched" type="datetime-local" wire:model="launched" />
                    <flux:input label="Delivered" type="datetime-local" wire:model="delivered" />
                    <flux:input label="Shipyard" wire:model="shipyard" />
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
                            <div class="grid grid-cols-4 gap-3 items-end mt-2">
                                <flux:input label="Port of Calling"
                                    wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.port_of_calling" />
                                <flux:input label="Country"
                                    wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.country" />
                                <flux:input label="Purpose"
                                    wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.purpose" />
                                <flux:input label="ATA/ETA Date" type="datetime-local"
                                    wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.ata_eta_date" />
                                <flux:input label="Ship Info Date" type="datetime-local"
                                    wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.ship_info_date" />

                                <flux:select label="GMT Offset"
                                    wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.gmt">
                                    <flux:select.option value="">Select GMT Offset</flux:select.option>
                                    @foreach ($this->gmtOffsets as $offset)
                                        <flux:select.option value="{{ $offset }}">{{ $offset }}
                                        </flux:select.option>
                                    @endforeach
                                </flux:select>

                                <flux:input label="Duration (Days)" type="number" max="9999999.999"
                                    wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.duration_days" />
                                <flux:input label="Total (Days)" type="number" max="9999999.999"
                                    wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.total_days" />

                                <flux:button icon="plus" variant="filled"
                                    wire:click="addAgent({{ $pIndex }})">
                                    Add Agent
                                </flux:button>

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
                        @if (count($ports) > 1)
                            <flux:button variant="danger" wire:click="removePort({{ $pIndex }})">
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
            <flux:legend>Remarks</flux:legend>
            <div class="space-y-6">
                <div class="w-full">
                    <flux:textarea rows="8" wire:model="remarks" />
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
                    <flux:textarea rows="8" wire:model="master_info" required />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="flex items-center justify-center w-full">
        <flux:button type="submit" icon="check">Update Report</flux:button>
    </div>
</form>
