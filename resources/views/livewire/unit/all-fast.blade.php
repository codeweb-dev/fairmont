<div>
    <div class="mb-6 flex items-center justify-between w-full">
        <flux:heading size="xl" class="font-bold">All Fast</flux:heading>

        <div class="flex items-center gap-3">
            <flux:button icon:trailing="x-mark" variant="danger">Clear Fields</flux:button>
            <flux:button icon="folder-arrow-down">Save Draft</flux:button>
            <flux:button icon="arrow-down-tray">Export Data</flux:button>
        </div>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Voyage Details</flux:legend>

            <div class="space-y-6">
                <div class="grid grid-cols-3 gap-x-4 gap-y-6">
                    <flux:select label="Vessel Name" badge="Required" required>
                        <option selected>Select Vessel</option>
                        <!-- ... -->
                    </flux:select>
                    <flux:input label="Voyage No" badge="Required" required />
                    <flux:input label="All Fast Date/Time (LT)" type="date" max="2999-12-31" badge="Required"
                        required />
                    <flux:select label="GMT Offset" badge="Required" required>
                        <option selected>Select</option>
                        <!-- ... -->
                    </flux:select>
                    <flux:input label="Port" badge="Required" required />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>All Fast ROBs</flux:legend>

            <div class="mb-4">
                <flux:button icon="plus" wire:click="addRow">
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
                                    <flux:input wire:model="robs.{{ $index }}.hsfo" placeholder="HSFO (MT)" />
                                </td>
                                <td class="p-2">
                                    <flux:input wire:model="robs.{{ $index }}.biofuel" placeholder="BIOFUEL (MT)" />
                                </td>
                                <td class="p-2">
                                    <flux:input wire:model="robs.{{ $index }}.vlsfo" placeholder="VLSFO (MT)" />
                                </td>
                                <td class="p-2">
                                    <flux:input wire:model="robs.{{ $index }}.lsmgo"
                                        placeholder="LSMGO (MT)" />
                                </td>
                                <td class="p-2">
                                    <flux:button variant="danger" size="xs" icon="trash"
                                        wire:click="removeRow({{ $index }})" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </flux:fieldset>
    </div>
</div>
