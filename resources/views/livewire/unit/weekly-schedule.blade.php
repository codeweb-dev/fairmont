<form wire:submit.prevent="save" x-data="autoSaveHandler()">
    <div class="mb-6 flex items-center justify-between w-full">
        <h1 class="text-3xl font-bold">
            Weekly Schedule Report
        </h1>

        <div class="flex items-center gap-3">
            <flux:button icon:trailing="x-mark" variant="danger" wire:click="clearForm"
                @click="Toaster.success('Fields cleared successfully.')">
                Clear Fields
            </flux:button>
            {{-- <flux:button icon="folder-arrow-down" wire:click="saveDraft" variant="outline"
                @click="Toaster.success('Draft saved successfully.')">
                Save Draft
            </flux:button> --}}
            <flux:button href="{{ route('table-weekly-schedule-report') }}" wire:navigate
                icon:trailing="arrow-uturn-left">
                Go Back
            </flux:button>
        </div>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Schedule Details</flux:legend>

            <div class="space-y-6">
                <div class="grid grid-cols-3 gap-x-4 gap-y-6">
                    <flux:input label="Vessel Name" badge="Required" disabled :value="$vesselName" />

                    <flux:input label="Voyage No" badge="Required" required wire:model.defer="voyage_no" x-on:input="scheduleAutoSave" />

                    <flux:input label="Date" type="datetime-local" max="2999-12-31" badge="Required" required
                        wire:model.defer="all_fast_datetime" x-on:input="scheduleAutoSave" />
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
                        <flux:input label="Port" wire:model="ports.{{ $pIndex }}.port" x-on:input="scheduleAutoSave" />
                        <flux:select label="Activity" wire:model="ports.{{ $pIndex }}.activity" x-on:input="scheduleAutoSave">
                            <flux:select.option value="">Select</flux:select.option>
                            <flux:select.option value="Loading">Loading</flux:select.option>
                            <flux:select.option value="Bunkering">Bunkering</flux:select.option>
                            <flux:select.option value="Discharging">Discharging</flux:select.option>
                        </flux:select>
                        <flux:input type="datetime-local" label="ETA/ETB" wire:model="ports.{{ $pIndex }}.eta_etb" x-on:input="scheduleAutoSave" />
                        <flux:input type="datetime-local" label="ETCD" wire:model="ports.{{ $pIndex }}.etcd" x-on:input="scheduleAutoSave"/>
                        <flux:input label="Cargo" wire:model="ports.{{ $pIndex }}.cargo" x-on:input="scheduleAutoSave" />
                        <flux:input label="Cargo Qty" wire:model="ports.{{ $pIndex }}.cargo_qty" x-on:input="scheduleAutoSave" />
                        <flux:input label="Remarks" wire:model="ports.{{ $pIndex }}.remarks" x-on:input="scheduleAutoSave" />
                    </div>

                    <flux:heading size="sm" class="pt-4">Agent(s)</flux:heading>

                    @foreach ($port['agents'] as $aIndex => $agent)
                        <div
                            class="{{ count($port['agents']) > 1 ? 'grid-cols-7' : 'grid-cols-6' }} grid  gap-3 items-end">
                            <flux:input label="Agent's Name"
                                wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.name" x-on:input="scheduleAutoSave" />
                            <flux:input label="Address"
                                wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.address" x-on:input="scheduleAutoSave" />
                            <flux:input label="PIC Name"
                                wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.pic_name" x-on:input="scheduleAutoSave" />
                            <flux:input label="Telephone"
                                wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.telephone" x-on:input="scheduleAutoSave" />
                            <flux:input label="Mobile"
                                wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.mobile" x-on:input="scheduleAutoSave" />
                            <flux:input label="Email" type="email"
                                wire:model="ports.{{ $pIndex }}.agents.{{ $aIndex }}.email" x-on:input="scheduleAutoSave" />
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
            <flux:legend>Remarks</flux:legend>
            <div class="space-y-6">
                <div class="w-full">
                    <flux:textarea rows="8" wire:model.defer="remarks" x-on:input="scheduleAutoSave" />
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
                    <flux:textarea rows="8" wire:model.defer="master_info" required x-on:input="scheduleAutoSave" />
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

<script>
function autoSaveHandler() {
    return {
        autoSaveTimeout: null,

        scheduleAutoSave() {
            // Clear existing timeout
            if (this.autoSaveTimeout) {
                clearTimeout(this.autoSaveTimeout);
            }

            // Set new timeout for 2 seconds after user stops typing
            this.autoSaveTimeout = setTimeout(() => {
                this.triggerAutoSave();
            }, 2000);
        },

        async triggerAutoSave() {
            try {
                // Call the Livewire autoSave method
                await this.$wire.call('autoSave');
            } catch (error) {
                console.error('Auto-save failed:', error);
                // You could show an error toaster here if needed
            }
        }
    };
}
</script>

@push('scripts')
<script>
    // Listen for the draftSaved event from Livewire
    document.addEventListener('livewire:initialized', () => {
        Livewire.on('draftSaved', () => {
            // Optional: Show additional feedback when manual save is triggered
            console.log('Draft saved successfully');
        });
    });
</script>
@endpush
