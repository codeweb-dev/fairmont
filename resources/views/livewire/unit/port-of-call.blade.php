<form wire:submit.prevent="save" x-data="autoSaveHandler()">
    <div class="mb-6 flex items-center justify-between w-full">
        <h1 class="text-3xl font-bold">Port Of Call Report</h1>
        <div class="flex items-center gap-3">
            <flux:button icon:trailing="x-mark" variant="danger" wire:click="clearForm" @click="Toaster.success('Fields cleared successfully.')">
                Clear Fields
            </flux:button>
            <flux:button href="{{ route('table-port-of-call-report') }}" wire:navigate
                icon:trailing="arrow-uturn-left">
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
                    <flux:input label="Call Sign" wire:model="call_sign" x-on:input="scheduleAutoSave" />
                    <flux:input label="Flag" wire:model="flag" x-on:input="scheduleAutoSave" />
                    <flux:input label="Port of Registry" wire:model="port_of_registry" x-on:input="scheduleAutoSave" />

                    <flux:input label="Official Number" wire:model="official_number" x-on:input="scheduleAutoSave" />
                    <flux:input label="IMO Number" wire:model="imo_number" x-on:input="scheduleAutoSave" />
                    <flux:input label="Class Society" wire:model="class_society" x-on:input="scheduleAutoSave" />
                    <flux:input label="Class No" wire:model="class_no" x-on:input="scheduleAutoSave" />

                    <flux:input label="P&I Club" wire:model="pi_club" x-on:input="scheduleAutoSave" />
                    <flux:input label="LOA (Length Overall)" wire:model="loa" x-on:input="scheduleAutoSave" />
                    <flux:input label="LBP (Length Between Perpendiculars)" wire:model="lbp" x-on:input="scheduleAutoSave" />
                    <flux:input label="Breadth (extreme)" wire:model="breadth_extreme" x-on:input="scheduleAutoSave" />

                    <flux:input label="Depth (molded)" wire:model="depth_moulded" x-on:input="scheduleAutoSave" />
                    <flux:input label="Height (maximum)" wire:model="height_maximum" x-on:input="scheduleAutoSave" />
                    <flux:input label="Bridge Front - Bow" wire:model="bridge_front_bow" x-on:input="scheduleAutoSave" />
                    <flux:input label="Bridge Front - Stern" wire:model="bridge_front_stern" x-on:input="scheduleAutoSave" />

                    <flux:input label="Light Ship Displacement" wire:model="light_ship_displacement" x-on:input="scheduleAutoSave" />
                    <flux:input label="Keel Laid" type="datetime-local" wire:model="keel_laid" x-on:input="scheduleAutoSave" />
                    <flux:input label="Launched" type="datetime-local" wire:model="launched" x-on:input="scheduleAutoSave" />
                    <flux:input label="Delivered" type="datetime-local" wire:model="delivered" x-on:input="scheduleAutoSave" />
                    <flux:input label="Shipyard" wire:model="shipyard" x-on:input="scheduleAutoSave" />
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
                    <flux:input label="Voyage No" wire:model="ports.{{ $pIndex }}.voyage_no" x-on:input="scheduleAutoSave" />
                    <flux:input label="Cargo" wire:model="ports.{{ $pIndex }}.cargo" x-on:input="scheduleAutoSave" />
                    <flux:input label="Charterers" wire:model="ports.{{ $pIndex }}.charterers" x-on:input="scheduleAutoSave" />
                </div>

                @foreach ($port['agents'] as $aIndex => $agent)
                <div>
                    <div class="grid grid-cols-4 gap-3 items-end mt-2">
                        <flux:input label="Port of Calling" wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.port_of_calling" x-on:input="scheduleAutoSave" />
                        <flux:input label="Country" wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.country" x-on:input="scheduleAutoSave" />
                        <flux:input label="Purpose" wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.purpose" x-on:input="scheduleAutoSave" />
                        <flux:input label="ATA/ETA Date" type="datetime-local" wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.ata_eta_date" x-on:input="scheduleAutoSave" />
                        <flux:input label="Ship Info Date" type="datetime-local" wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.ship_info_date" x-on:input="scheduleAutoSave" />

                        <flux:select label="GMT Offset" wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.gmt" x-on:change="scheduleAutoSave">
                            <flux:select.option value="">Select GMT Offset</flux:select.option>
                            @foreach ($this->gmtOffsets as $offset)
                            <flux:select.option value="{{ $offset }}">{{ $offset }}</flux:select.option>
                            @endforeach
                        </flux:select>

                        <flux:input label="Duration (Days)" type="number" max="9999999.999"
                            wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.duration_days" x-on:input="scheduleAutoSave" />
                        <flux:input label="Total (Days)" type="number" max="9999999.999"
                            wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.total_days" x-on:input="scheduleAutoSave" />

                        <flux:button icon="plus" variant="filled" wire:click="addAgent({{ $pIndex }})">
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
                    <flux:textarea rows="8" wire:model="remarks" x-on:input="scheduleAutoSave" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Master Information <flux:badge size="sm">Required</flux:badge></flux:legend>
            <div class="space-y-6">
                <div class="w-full">
                    <flux:textarea rows="8" wire:model="master_info" required x-on:input="scheduleAutoSave" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="flex items-center justify-center w-full">
        <flux:button type="submit" icon="check">Submit</flux:button>
    </div>
</form>

<script>
function autoSaveHandler() {
    return {
        autoSaveTimeout: null,

        scheduleAutoSave() {
            if (this.autoSaveTimeout) {
                clearTimeout(this.autoSaveTimeout);
            }

            this.autoSaveTimeout = setTimeout(() => {
                this.triggerAutoSave();
            }, 2000);
        },

        async triggerAutoSave() {
            try {
                await this.$wire.call('autoSave');
            } catch (error) {
                console.error('Auto-save failed:', error);
            }
        }
    };
}
</script>

@push('scripts')
<script>
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('draftSaved', () => {
            console.log('Draft saved successfully');
        });
    });
</script>
@endpush
