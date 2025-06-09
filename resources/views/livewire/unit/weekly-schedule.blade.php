<form wire:submit.prevent="save">
    <div class="mb-6 flex items-center justify-between w-full">
        <flux:heading size="xl" class="font-bold">Weekly Schedule</flux:heading>

        <div class="flex items-center gap-3">
            <flux:button icon:trailing="x-mark" variant="danger" wire:click="clearForm">
                Clear Fields
            </flux:button>
            <flux:button icon="folder-arrow-down">
                Save Draft
            </flux:button>
            <flux:button icon="arrow-down-tray" type="button" wire:click="export">
                Export Data
            </flux:button>
        </div>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Schedule Details</flux:legend>

            <div class="space-y-6">
                <div class="grid grid-cols-3 gap-x-4 gap-y-6">
                    <flux:input label="Vessel Name" badge="Required" disabled :value="$vesselName" />

                    <flux:input label="Voyage No" badge="Required" required wire:model.defer="voyage_no" />

                    <flux:input label="Date" type="date" max="2999-12-31" badge="Required" required
                        wire:model.defer="all_fast_datetime" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Agent's Details</flux:legend>

            <flux:button wire:click="addPort" class="mb-6">Add New Port</flux:button>

            @foreach ($ports as $pIndex => $port)
                <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md space-y-6">
                    <div class="flex items-center justify-between">
                        <flux:heading size="md">Port {{ $pIndex + 1 }}</flux:heading>

                        @if (count($ports) > 1)
                            <flux:button variant="danger" size="xs" wire:click="removePort({{ $pIndex }})">
                                Remove Port
                            </flux:button>
                        @endif
                    </div>

                    <div class="grid grid-cols-4 gap-4">
                        <flux:input label="Port" wire:model="ports.{{ $pIndex }}.port" />
                        <flux:select label="Activity" wire:model="ports.{{ $pIndex }}.activity">
                            <flux:select.option value="">Select</flux:select.option>
                            <flux:select.option value="Loading">Loading</flux:select.option>
                            <flux:select.option value="Bunkering">Bunkering</flux:select.option>
                            <flux:select.option value="Discharging">Discharging</flux:select.option>
                        </flux:select>
                        <flux:input type="datetime-local" label="ETA/ETB"
                            wire:model="ports.{{ $pIndex }}.eta_etb" />
                        <flux:input type="datetime-local" label="ETCD" wire:model="ports.{{ $pIndex }}.etcd" />
                        <flux:select label="Cargo" wire:model="ports.{{ $pIndex }}.cargo">
                            <flux:select.option value="">Select</flux:select.option>
                            <flux:select.option value="Oil">Oil</flux:select.option>
                            <flux:select.option value="Coal">Coal</flux:select.option>
                        </flux:select>
                        <flux:input label="Cargo Qty" wire:model="ports.{{ $pIndex }}.cargo_qty" />
                        <flux:input label="Remarks" wire:model="ports.{{ $pIndex }}.remarks" />
                    </div>

                    <flux:heading size="sm" class="pt-4">Agent(s)</flux:heading>

                    @foreach ($port['agents'] as $aIndex => $agent)
                        <div
                            class="{{ count($port['agents']) > 1 ? 'grid-cols-7' : 'grid-cols-6' }} grid  gap-3 items-end">
                            <flux:input label="Agent's Name"
                                wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.name" />
                            <flux:input label="Address"
                                wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.address" />
                            <flux:input label="PIC Name"
                                wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.pic_name" />
                            <flux:input label="Telephone"
                                wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.telephone" />
                            <flux:input label="Mobile"
                                wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.mobile" />
                            <flux:input label="Email" type="email"
                                wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.email" />
                            @if (count($port['agents']) > 1)
                                <flux:button variant="danger" class="w-full" icon="trash"
                                    wire:click="removeAgent({{ $pIndex }}, {{ $aIndex }})" />
                            @endif
                        </div>
                    @endforeach

                    <div class="mt-4">
                        <flux:button icon="plus" variant="filled" size="sm"
                            wire:click="addAgent({{ $pIndex }})">
                            Add Agent
                        </flux:button>
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
