<form wire:submit.prevent="save">
    <div class="mb-6 flex items-center justify-between w-full">
        <flux:heading size="xl" class="font-bold">Bunkering</flux:heading>

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
            <flux:legend>Bunkering Details</flux:legend>

            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:input label="Vessel Name" badge="Required" disabled :value="$vesselName" />

                    <flux:input label="Voyage No" badge="Required" required wire:model.defer="voyage_no" />

                    <flux:input label="Bunkering Port" badge="Required" required wire:model.defer="bunkering_port" />

                    <flux:select label="Supplier" badge="Required" required wire:model.defer="supplier">
                        <flux:select.option value="" disabled selected>Select</flux:select.option>
                        @foreach ($_supplier as $supplier)
                            <flux:select.option value="{{ $supplier }}">{{ $supplier }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input label="Port ETD (LT)" type="date" max="2999-12-31" badge="Required" required
                        wire:model.defer="port_etd" />

                    <flux:select label="Port GMT Offset" badge="Required" required wire:model.defer="port_gmt_offset">
                        <flux:select.option value="" disabled selected>Select</flux:select.option>
                        @foreach ($gmtOffsets as $offset)
                            <flux:select.option value="{{ $offset }}">{{ $offset }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input label="Bunker Completed (LT)" type="date" max="2999-12-31" badge="Required" required
                        wire:model.defer="bunker_completed" />

                    <flux:select label="Bunker GMT Offset" badge="Required" required
                        wire:model.defer="bunker_gmt_offset">
                        <flux:select.option value="" disabled selected>Select</flux:select.option>
                        @foreach ($gmtOffsets as $offset)
                            <flux:select.option value="{{ $offset }}">{{ $offset }}</flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Bunker Type Quantity Taken (in MT)</flux:legend>
            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:input type="number" label="HSFO Quantity (MT)" wire:model.defer="hsfo_quantity" />
                    <flux:select label="HSFO Viscosity (CST)" required wire:model.defer="hsfo_viscosity">
                        <flux:select.option value="" selected disabled>Select</flux:select.option>
                        <flux:select.option value="Less than 80">Less than 80</flux:select.option>
                        <flux:select.option value="Greater than 80">Greater than 80</flux:select.option>
                    </flux:select>

                    <flux:input type="number" label="BIOFUEL Quantity (MT)" wire:model.defer="biofuel_quantity" />
                    <flux:select label="BIOFUEL Viscosity (CST)" required wire:model.defer="biofuel_viscosity">
                        <flux:select.option value="" selected disabled>Select</flux:select.option>
                        <flux:select.option value="Less than 80">Less than 80</flux:select.option>
                        <flux:select.option value="Greater than 80">Greater than 80</flux:select.option>
                    </flux:select>

                    <flux:input type="number" label="VLSFO Quantity (MT)" wire:model.defer="vlsfo_quantity" />
                    <flux:select label="VLSFO Viscosity (CST)" required wire:model.defer="vlsfo_viscosity">
                        <flux:select.option value="" selected disabled>Select</flux:select.option>
                        <flux:select.option value="Less than 80">Less than 80</flux:select.option>
                        <flux:select.option value="Greater than 80">Greater than 80</flux:select.option>
                    </flux:select>

                    <flux:input type="number" label="LSMGO Quantity (MT)" wire:model.defer="lsmgo_quantity" />
                    <flux:select label="LSMGO Viscosity (CST)" required wire:model.defer="lsmgo_viscosity">
                        <flux:select.option value="" selected disabled>Select</flux:select.option>
                        <flux:select.option value="Less than 80">Less than 80</flux:select.option>
                        <flux:select.option value="Greater than 80">Greater than 80</flux:select.option>
                    </flux:select>
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Associated Information</flux:legend>
            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:select label="In Port vs Off Shore Delivery" required wire:model.defer="port_delivery">
                        <flux:select.option value="" disabled selected>Select</flux:select.option>
                        @foreach ($gmtOffsets as $offset)
                            <flux:select.option value="{{ $offset }}">{{ $offset }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input type="date" label="EOSP (LT)" wire:model.defer="eosp" />

                    <flux:select label="EOSP GMT Offset" required wire:model.defer="eosp_gmt">
                        <flux:select.option value="" disabled selected>Select</flux:select.option>
                        @foreach ($gmtOffsets as $offset)
                            <flux:select.option value="{{ $offset }}">{{ $offset }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input type="date" label="Barge Alongside (LT)" wire:model.defer="barge" />

                    <flux:select label="Barge Alongside GMT Offset" required wire:model.defer="barge_gmt">
                        <flux:select.option value="" disabled selected>Select</flux:select.option>
                        @foreach ($gmtOffsets as $offset)
                            <flux:select.option value="{{ $offset }}">{{ $offset }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input type="date" label="COSP (LT)" wire:model.defer="cosp" />

                    <flux:select label="COSP GMT Offset" required wire:model.defer="cosp_gmt">
                        <flux:select.option value="" disabled selected>Select</flux:select.option>
                        @foreach ($gmtOffsets as $offset)
                            <flux:select.option value="{{ $offset }}">{{ $offset }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input type="date" label="Anchor Dropped (LT)" wire:model.defer="anchor" />

                    <flux:select label="Anchor Dropped GMT Offset" required wire:model.defer="anchor_gmt">
                        <flux:select.option value="" disabled selected>Select</flux:select.option>
                        @foreach ($gmtOffsets as $offset)
                            <flux:select.option value="{{ $offset }}">{{ $offset }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input type="date" label="Pumping Completed (LT)" wire:model.defer="pumping" />

                    <flux:select label="Pumping Completed GMT Offset" required wire:model.defer="pumping_gmt">
                        <flux:select.option value="" disabled selected>Select</flux:select.option>
                        @foreach ($gmtOffsets as $offset)
                            <flux:select.option value="{{ $offset }}">{{ $offset }}</flux:select.option>
                        @endforeach
                    </flux:select>
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

    <div class="flex items-center justify-center w-full">
        <flux:button type="submit" icon="check">
            Submit
        </flux:button>
    </div>
</form>
