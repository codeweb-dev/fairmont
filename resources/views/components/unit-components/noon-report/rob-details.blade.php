@php
    $bunkerTypes = ['HSFO', 'BIOFUEL', 'VLSFO', 'LSMGO'];
@endphp

<div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
    <flux:fieldset>
        <flux:legend>ROB Details</flux:legend>

        <!-- Grade Buttons trigger modals -->
        <div class="flex space-x-6 mb-6 gap-3 items-center justify-center">
            @foreach ($bunkerTypes as $type)
                <flux:modal.trigger name="rob-modal-{{ strtolower($type) }}">
                    <flux:button variant="primary">{{ $type }}</flux:button>
                </flux:modal.trigger>
            @endforeach
        </div>
    </flux:fieldset>
</div>

<!-- All tables are now INSIDE the modal for each bunker type -->
@foreach ($bunkerTypes as $type)
    <flux:modal name="rob-modal-{{ strtolower($type) }}" class="max-w-full">
        <div class="space-y-8">
            <flux:heading size="lg">ROB Details - {{ $type }}</flux:heading>

            <!-- Tank Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full mb-8">
                    <thead>
                        <tr class="bg-zinc-800 text-white">
                            <th class="px-4 py-2">Tank No.</th>
                            <th class="px-4 py-2">Description</th>
                            <th class="px-4 py-2">Fuel Grade</th>
                            <th class="px-4 py-2">Capacity</th>
                            <th class="px-4 py-2">Unit</th>
                            <th class="px-4 py-2">ROB (MT)</th>
                            <th class="px-4 py-2">Supply Date (LT)</th>
                            <th class="px-4 py-2">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-4 py-2 font-semibold">1</td>
                            <td class="px-4 py-2"><flux:input placeholder="Enter tank name here" /></td>
                            <td class="px-4 py-2">
                                <flux:select placeholder="Select" required>
                                    <flux:select.option>HSFO</flux:select.option>
                                    <flux:select.option>BIOFUEL</flux:select.option>
                                    <flux:select.option>VLSFO</flux:select.option>
                                    <flux:select.option>LSMGO</flux:select.option>
                                </flux:select>
                            </td>
                            <td class="px-4 py-2"><flux:input placeholder="Enter tank capacity" /></td>
                            <td class="px-4 py-2">
                                <flux:select required>
                                    <flux:select.option selected>MT</flux:select.option>
                                    <flux:select.option>L</flux:select.option>
                                    <flux:select.option>GAL</flux:select.option>
                                </flux:select>
                            </td>
                            <td class="px-4 py-2"><flux:input /></td>
                            <td class="px-4 py-2"><flux:input type="date" /></td>
                            <td class="px-4 py-2"><flux:button icon="plus" /></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- ROB/Consumption Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full mb-8">
                    <thead>
                        <tr class="bg-zinc-800 text-white">
                            <th rowspan="2" class="px-4 py-2">Bunker Type</th>
                            <th colspan="2" class="px-4 py-2">ROB (in MT)</th>
                            <th colspan="4" class="px-4 py-2">Consumption</th>
                            <th colspan="2" class="px-4 py-2">Cons./24 hr</th>
                            <th rowspan="2" class="px-4 py-2">Total Cons.</th>
                        </tr>
                        <tr class="bg-zinc-800 text-white">
                            <th class="px-4 py-2">Previous</th>
                            <th class="px-4 py-2">Current</th>
                            <th class="px-4 py-2">M/E Propulsion</th>
                            <th class="px-4 py-2">A/E cons.</th>
                            <th class="px-4 py-2">Boiler cons.</th>
                            <th class="px-4 py-2">Incinerators</th>
                            <th class="px-4 py-2">M/E 24</th>
                            <th class="px-4 py-2">A/E 24</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-4 py-2 font-semibold">{{ $type }} (MT)</td>
                            <td class="px-4 py-2"><flux:input /></td>
                            <td class="px-4 py-2"><flux:input value="0.000" /></td>
                            <td class="px-4 py-2"><flux:input /></td>
                            <td class="px-4 py-2"><flux:input /></td>
                            <td class="px-4 py-2"><flux:input /></td>
                            <td class="px-4 py-2"><flux:input /></td>
                            <td class="px-4 py-2"><flux:input /></td>
                            <td class="px-4 py-2"><flux:input /></td>
                            <td class="px-4 py-2"><flux:input value="0.000" /></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Oil Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-zinc-800 text-white">
                            <th colspan="3" class="px-4 py-2">ME CYL</th>
                            <th colspan="3" class="px-4 py-2">ME CC</th>
                            <th colspan="3" class="px-4 py-2">AE CC</th>
                        </tr>
                        <tr class="bg-zinc-800 text-white">
                            <th class="px-4 py-2">Oil Grade</th>
                            <th class="px-4 py-2">Oil Quantity</th>
                            <th class="px-4 py-2">Total Runn Hrs.</th>
                            <th class="px-4 py-2">Oil Cons.</th>
                            <th class="px-4 py-2">Oil Quantity</th>
                            <th class="px-4 py-2">Total Run Hrs.</th>
                            <th class="px-4 py-2">Oil Cons.</th>
                            <th class="px-4 py-2">Oil Quantity</th>
                            <th class="px-4 py-2">Total Run Hrs.</th>
                            <th class="px-4 py-2">Oil Cons.</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <!-- ME CYL -->
                            <td class="px-4 py-2">
                            <flux:select placeholder="Select" required>
                                <flux:select.option>TBN 100</flux:select.option>
                                <flux:select.option>TBN 70</flux:select.option>
                                <flux:select.option>TBN 40</flux:select.option>
                            </flux:select>
                            </td>
                            <td class="px-4 py-2"><flux:input /></td>
                            <td class="px-4 py-2"><flux:input /></td>
                            <!-- ME CC -->
                            <td class="px-4 py-2"><flux:input /></td>
                            <td class="px-4 py-2"><flux:input /></td>
                            <td class="px-4 py-2"><flux:input /></td>
                            <!-- AE CC -->
                            <td class="px-4 py-2"><flux:input /></td>
                            <td class="px-4 py-2"><flux:input /></td>
                            <td class="px-4 py-2"><flux:input /></td>
                            <td class="px-4 py-2"><flux:input /></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>
        </div>
    </flux:modal>
@endforeach
