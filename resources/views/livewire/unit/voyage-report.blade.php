<form wire:submit.prevent="save" x-data="autoSaveHandler()">
    <div class="mb-6 flex items-center justify-between w-full">
        <h1 class="text-3xl font-bold">
            Voyage Report
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
            <flux:button href="{{ route('table-voyage-report') }}" wire:navigate icon:trailing="arrow-uturn-left">
                Go Back
            </flux:button>
        </div>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Voyage Details</flux:legend>

            <div class="space-y-6">
                <div class="grid grid-cols-3 gap-x-4 gap-y-6">
                    <flux:input label="Vessel Name" badge="Required" disabled :value="$vesselName" />

                    <flux:input label="Voyage No" badge="Required" required wire:model.defer="voyage_no" x-on:input="scheduleAutoSave"  />

                    <flux:input label="Date" type="datetime-local" max="2999-12-31" badge="Required" required
                        wire:model.defer="all_fast_datetime" x-on:input="scheduleAutoSave"  />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Location</flux:legend>

            <div class="space-y-6">
                <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                    <flux:input label="Port of Departure COSP (Date and UTC)" type="datetime-local" max="2999-12-31"
                        wire:model.defer="port_departure" x-on:input="scheduleAutoSave" />
                    <flux:input label="Port of Arrival EOSP (Date and UTC)" type="datetime-local" max="2999-12-31"
                        wire:model.defer="port_arrival" x-on:input="scheduleAutoSave" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Off Hire</flux:legend>

            <div class="space-y-6">
                <div class="grid grid-cols-2 gap-x-4 gap-y-6">
                    <flux:input label="Off Hire Hours (Hrs)" type="number" max="9999999.999" step="0.01"
                        wire:model.defer="hire_hours" x-on:input="scheduleAutoSave" />
                    <flux:input label="Off Hire Reason" type="input" wire:model.defer="hire_reason" x-on:input="scheduleAutoSave" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Engine</flux:legend>

            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:input label="Avg ME RPM" type="number" max="9999999.999" step="0.01" wire:model.defer="avg_me_rpm" x-on:input="scheduleAutoSave" />
                    <flux:input label="Avg ME kW" type="number" max="9999999.999" step="0.01" wire:model.defer="avg_me_kw" x-on:input="scheduleAutoSave" />
                    <flux:input label="TDR (Nm)" type="number" max="9999999.999" step="0.01" wire:model.defer="tdr" x-on:input="scheduleAutoSave" />
                    <flux:input label="TST (Hrs)" type="number" max="9999999.999" step="0.01" wire:model.defer="tst" x-on:input="scheduleAutoSave" />
                    <flux:input label="Slip (pct)" type="number" max="9999999.999" step="0.01" wire:model.defer="slip" x-on:input="scheduleAutoSave" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>ROB</flux:legend>

            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:input label="HSFO (MT)" type="number" max="9999999.999" step="0.01" wire:model.defer="robs.hsfo" x-on:input="scheduleAutoSave" />
                    <flux:input label="VLSFO (MT)" type="number" max="9999999.999" step="0.01" wire:model.defer="robs.vlsfo" x-on:input="scheduleAutoSave" />
                    <flux:input label="BIO FUEL (MT)" type="number" max="9999999.999" step="0.01" wire:model.defer="robs.biofuel" x-on:input="scheduleAutoSave" />
                    <flux:input label="LSMGO (MT)" type="number" max="9999999.999" step="0.01" wire:model.defer="robs.lsmgo" x-on:input="scheduleAutoSave" />
                    <flux:input label="ME CC OIL (LITRES)" type="number" max="9999999.999" step="0.01"
                        wire:model.defer="robs.me_cc_oil" x-on:input="scheduleAutoSave" />
                    <flux:input label="ME CYL OIL (LITRES)" type="number" max="9999999.999" step="0.01"
                        wire:model.defer="robs.mc_cyl_oil" x-on:input="scheduleAutoSave" />
                    <flux:input label="GE CC OIL (LITRES)" type="number" max="9999999.999" step="0.01"
                        wire:model.defer="robs.ge_cc_oil" x-on:input="scheduleAutoSave" />
                    <flux:input label="FW (MT)" type="number" max="9999999.999" step="0.01" wire:model.defer="robs.fw" x-on:input="scheduleAutoSave" />
                    <flux:input label="FW Produced (MT)" type="number" max="9999999.999" step="0.01"
                        wire:model.defer="robs.fw_produced" x-on:input="scheduleAutoSave" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Received</flux:legend>

            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:input label="HSFO (MT)" type="number" max="9999999.999" step="0.01" wire:model.defer="received.hsfo" x-on:input="scheduleAutoSave" />
                    <flux:input label="VLSFO (MT)" type="number" max="9999999.999" step="0.01"
                        wire:model.defer="received.vlsfo" x-on:input="scheduleAutoSave" />
                    <flux:input label="BIO FUEL (MT)" type="number" max="9999999.999" step="0.01"
                        wire:model.defer="received.biofuel" x-on:input="scheduleAutoSave" />
                    <flux:input label="LSMGO (MT)" type="number" max="9999999.999" step="0.01"
                        wire:model.defer="received.lsmgo" x-on:input="scheduleAutoSave" />
                    <flux:input label="ME CC OIL (LITRES)" type="number" max="9999999.999" step="0.01"
                        wire:model.defer="received.me_cc_oil" x-on:input="scheduleAutoSave" />
                    <flux:input label="ME CYL OIL (LITRES)" type="number" max="9999999.999" step="0.01"
                        wire:model.defer="received.mc_cyl_oil" x-on:input="scheduleAutoSave" />
                    <flux:input label="GE CC OIL (LITRES)" type="number" max="9999999.999" step="0.01"
                        wire:model.defer="received.ge_cc_oil" x-on:input="scheduleAutoSave" />
                    <flux:input label="FW (MT)" type="number" max="9999999.999" step="0.01" wire:model.defer="received.fw" x-on:input="scheduleAutoSave" />
                    <flux:input label="FW Produced (MT)" type="number" max="9999999.999" step="0.01"
                        wire:model.defer="received.fw_produced" x-on:input="scheduleAutoSave" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Consumption</flux:legend>

            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:input label="HSFO (MT)" type="number" max="9999999.999" step="0.01"
                        wire:model.defer="consumption.hsfo" x-on:input="scheduleAutoSave" />
                    <flux:input label="VLSFO (MT)" type="number" max="9999999.999" step="0.01"
                        wire:model.defer="consumption.vlsfo" x-on:input="scheduleAutoSave" />
                    <flux:input label="BIO FUEL (MT)" type="number" max="9999999.999" step="0.01"
                        wire:model.defer="consumption.biofuel" x-on:input="scheduleAutoSave" />
                    <flux:input label="LSMGO (MT)" type="number" max="9999999.999" step="0.01"
                        wire:model.defer="consumption.lsmgo" x-on:input="scheduleAutoSave" />
                    <flux:input label="ME CC OIL (LITRES)" type="number" max="9999999.999" step="0.01"
                        wire:model.defer="consumption.me_cc_oil" x-on:input="scheduleAutoSave" />
                    <flux:input label="ME CYL OIL (LITRES)" type="number" max="9999999.999" step="0.01"
                        wire:model.defer="consumption.mc_cyl_oil" x-on:input="scheduleAutoSave" />
                    <flux:input label="GE CC OIL (LITRES)" type="number" max="9999999.999" step="0.01"
                        wire:model.defer="consumption.ge_cc_oil" x-on:input="scheduleAutoSave" />
                    <flux:input label="FW (MT)" type="number" max="9999999.999" step="0.01" wire:model.defer="consumption.fw" x-on:input="scheduleAutoSave" />
                    <flux:input label="FW Produced (MT)" type="number" max="9999999.999" step="0.01"
                        wire:model.defer="consumption.fw_produced" x-on:input="scheduleAutoSave" />
                </div>
            </div>
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
