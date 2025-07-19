<form wire:submit.prevent="save">
    <div class="mb-6 flex items-center justify-between w-full">
        <h1 class="text-3xl font-bold">
            All Fast Report
        </h1>

        <div class="flex items-center gap-3">
            <flux:button icon:trailing="x-mark" variant="danger" wire:click="clearForm"
                @click="Toaster.success('Fields cleared successfully.')">
                Clear Fields
            </flux:button>
            <flux:button icon="folder-arrow-down" wire:click="saveDraft" variant="outline"
                @click="Toaster.success('Draft saved successfully.')">
                Save Draft
            </flux:button>
            <flux:button href="{{ route('table-all-fast-report') }}" wire:navigate icon:trailing="arrow-uturn-left">
                Go Back
            </flux:button>
        </div>
    </div>

    {{-- Voyage Details --}}
    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Voyage Details</flux:legend>

            <div class="space-y-6">
                <div class="grid grid-cols-3 gap-x-4 gap-y-6">
                    <flux:input label="Vessel Name" badge="Required" disabled :value="$vesselName" />

                    <flux:input label="Voyage No" badge="Required" required wire:model="voyage_no" />

                    <flux:input label="All Fast Date/Time (LT)" type="datetime-local" badge="Required" max="2999-12-31"
                        required wire:model="all_fast_datetime" />

                    <flux:select label="GMT Offset" badge="Required" wire:model="gmt_offset" required>
                        <flux:select.option value="">Select GMT Offset</flux:select.option>
                        @foreach ($this->gmtOffsets as $offset)
                            <flux:select.option value="{{ $offset }}">{{ $offset }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input label="Port" badge="Required" required wire:model="port" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    {{-- ROBs Section --}}
    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>All Fast ROBs</flux:legend>

            <div class="mb-4">
                <flux:button icon="plus" type="button" wire:click="addRow">
                    Add Row
                </flux:button>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left">
                    <thead>
                        <tr>
                            <th class="p-2">HSFO (MT)</th>
                            <th class="p-2">BIOFUEL (MT)</th>
                            <th class="p-2">VLSFO (MT)</th>
                            <th class="p-2">LSMGO (MT)</th>
                            <th class="p-2"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($robs as $index => $rob)
                            <tr>
                                <td class="p-2">
                                    <flux:input type="number" step="0.01" max="9999999.999" wire:model="robs.{{ $index }}.hsfo"
                                        placeholder="HSFO (MT)" />
                                </td>
                                <td class="p-2">
                                    <flux:input type="number" step="0.01" max="9999999.999" wire:model="robs.{{ $index }}.biofuel"
                                        placeholder="BIOFUEL (MT)" />
                                </td>
                                <td class="p-2">
                                    <flux:input type="number" step="0.01" max="9999999.999" wire:model="robs.{{ $index }}.vlsfo"
                                        placeholder="VLSFO (MT)" />
                                </td>
                                <td class="p-2">
                                    <flux:input type="number" step="0.01" max="9999999.999" wire:model="robs.{{ $index }}.lsmgo"
                                        placeholder="LSMGO (MT)" />
                                </td>
                                <td class="p-2">
                                    <flux:button variant="danger" size="xs" icon="trash" type="button"
                                        wire:click="removeRow({{ $index }})" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
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

    {{-- Submit Button --}}
    <div class="flex items-center justify-center w-full">
        <flux:button type="submit" icon="check">
            Submit
        </flux:button>
    </div>
</form>
