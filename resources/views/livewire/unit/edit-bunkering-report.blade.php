<form wire:submit.prevent="update">
    <div class="mb-6 flex items-center justify-between w-full">
        <h1 class="text-3xl font-bold">
            Edit Bunker Report
        </h1>

        <div class="flex items-center gap-3">
            <flux:button icon:trailing="x-mark" variant="danger" wire:click="clearForm"
                @click="Toaster.success('Fields cleared successfully.')">
                Clear Fields
            </flux:button>
            <flux:button href="{{ route('table-bunkering-report') }}" wire:navigate icon:trailing="arrow-uturn-left">
                Go Back
            </flux:button>
        </div>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Bunkering Details</flux:legend>

            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:input label="Vessel Name" badge="Required" disabled :value="$vesselName" />

                    <flux:input label="Voyage No" badge="Required" required wire:model.defer="voyage_no" x-on:input="scheduleAutoSave" />

                    <flux:input label="Bunkering Port" badge="Required" required wire:model.defer="bunkering_port" x-on:input="scheduleAutoSave" />

                    <flux:input label="Supplier" badge="Required" required wire:model.defer="supplier" x-on:input="scheduleAutoSave" />

                    <flux:input label="Port ETD (LT)" type="datetime-local" max="2999-12-31" badge="Required" required
                        wire:model.defer="port_etd" x-on:input="scheduleAutoSave" />

                    <flux:select label="Port GMT Offset" badge="Required" required wire:model.defer="port_gmt_offset" x-on:input="scheduleAutoSave">
                        <flux:select.option value="">Select</flux:select.option>
                        @foreach ($this->gmtOffsets as $offset)
                            <flux:select.option value="{{ $offset }}">{{ $offset }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input label="Bunker Completed (LT)" type="datetime-local" max="2999-12-31" badge="Required"
                        required wire:model.defer="bunker_completed" x-on:input="scheduleAutoSave" />

                    <flux:select label="Bunker GMT Offset" badge="Required" required
                        wire:model.defer="bunker_gmt_offset" x-on:input="scheduleAutoSave">
                        <flux:select.option value="">Select</flux:select.option>
                        @foreach ($this->gmtOffsets as $offset)
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
                    <flux:input type="number" max="9999999.999" step="0.01" label="HSFO Quantity (MT)" wire:model.defer="hsfo_quantity" x-on:input="scheduleAutoSave" />
                    <flux:select label="HSFO Viscosity (CST)" wire:model.defer="hsfo_viscosity">
                        <flux:select.option value="">Select</flux:select.option>
                        <flux:select.option value="Less than 80">Less than 80</flux:select.option>
                        <flux:select.option value="Greater than 80">Greater than 80</flux:select.option>
                    </flux:select>

                    <flux:input type="number" max="9999999.999" step="0.01" label="BIOFUEL Quantity (MT)" wire:model.defer="biofuel_quantity" x-on:input="scheduleAutoSave" />
                    <flux:select label="BIOFUEL Viscosity (CST)" wire:model.defer="biofuel_viscosity" x-on:input="scheduleAutoSave">
                        <flux:select.option value="">Select</flux:select.option>
                        <flux:select.option value="Less than 80">Less than 80</flux:select.option>
                        <flux:select.option value="Greater than 80">Greater than 80</flux:select.option>
                    </flux:select>

                    <flux:input type="number" max="9999999.999" step="0.01" label="VLSFO Quantity (MT)" wire:model.defer="vlsfo_quantity" x-on:input="scheduleAutoSave" />
                    <flux:select label="VLSFO Viscosity (CST)" wire:model.defer="vlsfo_viscosity" x-on:input="scheduleAutoSave">
                        <flux:select.option value="">Select</flux:select.option>
                        <flux:select.option value="Less than 80">Less than 80</flux:select.option>
                        <flux:select.option value="Greater than 80">Greater than 80</flux:select.option>
                    </flux:select>

                    <flux:input type="number" max="9999999.999" step="0.01" label="LSMGO Quantity (MT)" wire:model.defer="lsmgo_quantity" x-on:input="scheduleAutoSave" />
                    <flux:select label="LSMGO Viscosity (CST)" wire:model.defer="lsmgo_viscosity" x-on:input="scheduleAutoSave">
                        <flux:select.option value="">Select</flux:select.option>
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
                    <flux:select label="In Port vs Off Shore Delivery" wire:model.defer="port_delivery">
                        <flux:select.option value="">Select</flux:select.option>
                        @foreach ($this->gmtOffsets as $offset)
                            <flux:select.option value="{{ $offset }}">{{ $offset }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input type="datetime-local" label="EOSP (LT)" wire:model.defer="eosp" />

                    <flux:select label="EOSP GMT Offset" wire:model.defer="eosp_gmt">
                        <flux:select.option value="">Select</flux:select.option>
                        @foreach ($this->gmtOffsets as $offset)
                            <flux:select.option value="{{ $offset }}">{{ $offset }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input type="datetime-local" label="Barge Alongside (LT)" wire:model.defer="barge" />

                    <flux:select label="Barge Alongside GMT Offset" wire:model.defer="barge_gmt">
                        <flux:select.option value="">Select</flux:select.option>
                        @foreach ($this->gmtOffsets as $offset)
                            <flux:select.option value="{{ $offset }}">{{ $offset }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input type="datetime-local" label="COSP (LT)" wire:model.defer="cosp" />

                    <flux:select label="COSP GMT Offset" wire:model.defer="cosp_gmt">
                        <flux:select.option value="">Select</flux:select.option>
                        @foreach ($this->gmtOffsets as $offset)
                            <flux:select.option value="{{ $offset }}">{{ $offset }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input type="datetime-local" label="Anchor Dropped (LT)" wire:model.defer="anchor" />

                    <flux:select label="Anchor Dropped GMT Offset" wire:model.defer="anchor_gmt">
                        <flux:select.option value="">Select</flux:select.option>
                        @foreach ($this->gmtOffsets as $offset)
                            <flux:select.option value="{{ $offset }}">{{ $offset }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input type="datetime-local" label="Pumping Completed (LT)" wire:model.defer="pumping" />

                    <flux:select label="Pumping Completed GMT Offset" wire:model.defer="pumping_gmt">
                        <flux:select.option value="">Select</flux:select.option>
                        @foreach ($this->gmtOffsets as $offset)
                            <flux:select.option value="{{ $offset }}">{{ $offset }}</flux:select.option>
                        @endforeach
                    </flux:select>
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
            Update Report
        </flux:button>
    </div>
</form>
