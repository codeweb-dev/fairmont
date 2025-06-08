<form wire:submit.prevent="save">
    <div class="mb-6 flex items-center justify-between w-full">
        <flux:heading size="xl" class="font-bold">All Fast</flux:heading>

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

    {{-- Voyage Details --}}
    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Voyage Details</flux:legend>

            <div class="space-y-6">
                <div class="grid grid-cols-3 gap-x-4 gap-y-6">
                    <flux:input label="Vessel Name" badge="Required" disabled :value="$vesselName" />

                    <flux:input label="Voyage No" badge="Required" required wire:model.defer="voyage_no" />

                    <flux:input label="All Fast Date/Time (LT)" type="date" badge="Required" max="2999-12-31"
                        required wire:model.defer="all_fast_datetime" />

                    <flux:select label="GMT Offset" badge="Required" required wire:model.defer="gmt_offset">
                        <flux:select.option value="" selected disabled>Select</flux:select.option>
                        <flux:select.option value="GMT-12:00">GMT-12:00</flux:select.option>
                        <flux:select.option value="GMT-11:00">GMT-11:00</flux:select.option>
                        <flux:select.option value="GMT-10:00">GMT-10:00</flux:select.option>
                        <flux:select.option value="GMT-09:30">GMT-09:30</flux:select.option>
                        <flux:select.option value="GMT-09:00">GMT-09:00</flux:select.option>
                        <flux:select.option value="GMT-08:00">GMT-08:00</flux:select.option>
                        <flux:select.option value="GMT-07:00">GMT-07:00</flux:select.option>
                        <flux:select.option value="GMT-06:00">GMT-06:00</flux:select.option>
                        <flux:select.option value="GMT-05:00">GMT-05:00</flux:select.option>
                        <flux:select.option value="GMT-04:30">GMT-04:30</flux:select.option>
                        <flux:select.option value="GMT-04:00">GMT-04:00</flux:select.option>
                        <flux:select.option value="GMT-03:30">GMT-03:30</flux:select.option>
                        <flux:select.option value="GMT-03:00">GMT-03:00</flux:select.option>
                        <flux:select.option value="GMT-02:30">GMT-02:30</flux:select.option>
                        <flux:select.option value="GMT-02:00">GMT-02:00</flux:select.option>
                        <flux:select.option value="GMT-01:00">GMT-01:00</flux:select.option>
                        <flux:select.option value="GMT">GMT</flux:select.option>
                        <flux:select.option value="GMT+01:00">GMT+01:00</flux:select.option>
                        <flux:select.option value="GMT+02:00">GMT+02:00</flux:select.option>
                        <flux:select.option value="GMT+02:30">GMT+02:30</flux:select.option>
                        <flux:select.option value="GMT+03:00">GMT+03:00</flux:select.option>
                        <flux:select.option value="GMT+03:30">GMT+03:30</flux:select.option>
                        <flux:select.option value="GMT+04:00">GMT+04:00</flux:select.option>
                        <flux:select.option value="GMT+04:30">GMT+04:30</flux:select.option>
                        <flux:select.option value="GMT+05:00">GMT+05:00</flux:select.option>
                        <flux:select.option value="GMT+05:30">GMT+05:30</flux:select.option>
                        <flux:select.option value="GMT+06:00">GMT+06:00</flux:select.option>
                        <flux:select.option value="GMT+06:30">GMT+06:30</flux:select.option>
                        <flux:select.option value="GMT+07:00">GMT+07:00</flux:select.option>
                        <flux:select.option value="GMT+08:00">GMT+08:00</flux:select.option>
                        <flux:select.option value="GMT+09:00">GMT+09:00</flux:select.option>
                        <flux:select.option value="GMT+09:30">GMT+09:30</flux:select.option>
                        <flux:select.option value="GMT+10:00">GMT+10:00</flux:select.option>
                        <flux:select.option value="GMT+10:30">GMT+10:30</flux:select.option>
                        <flux:select.option value="GMT+11:00">GMT+11:00</flux:select.option>
                        <flux:select.option value="GMT+11:30">GMT+11:30</flux:select.option>
                        <flux:select.option value="GMT+12:00">GMT+12:00</flux:select.option>
                        <flux:select.option value="GMT+12:45">GMT+12:45</flux:select.option>
                        <flux:select.option value="GMT+13:00">GMT+13:00</flux:select.option>
                        <flux:select.option value="GMT+13:45">GMT+13:45</flux:select.option>
                        <flux:select.option value="GMT+14:00">GMT+14:00</flux:select.option>
                    </flux:select>

                    <flux:input label="Port" badge="Required" required wire:model.defer="port" />
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
                                    <flux:input type="number" wire:model="robs.{{ $index }}.hsfo"
                                        placeholder="HSFO (MT)" />
                                </td>
                                <td class="p-2">
                                    <flux:input type="number" wire:model="robs.{{ $index }}.biofuel"
                                        placeholder="BIOFUEL (MT)" />
                                </td>
                                <td class="p-2">
                                    <flux:input type="number" wire:model="robs.{{ $index }}.vlsfo"
                                        placeholder="VLSFO (MT)" />
                                </td>
                                <td class="p-2">
                                    <flux:input type="number" wire:model="robs.{{ $index }}.lsmgo"
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

    {{-- Submit Button --}}
    <div class="flex items-center justify-center w-full">
        <flux:button type="submit" icon="check">
            Submit
        </flux:button>
    </div>
</form>
