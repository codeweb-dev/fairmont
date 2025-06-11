<form wire:submit.prevent="save">
    <div class="mb-6 flex items-center justify-between w-full">
        <flux:heading size="xl" class="font-bold">Noon Report</flux:heading>

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
            <flux:legend>Voyage Details</flux:legend>

            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:input label="Vessel Name" badge="Required" disabled :value="$vesselName" />
                    <flux:input label="Voyage No" badge="Required" required />
                    <flux:select label="Vessel Name" badge="Required" required wire:model.live="report_type">
                        <flux:select.option value="" disabled selected>Select Report Type</flux:select.option>
                        <flux:select.option value="At Sea">At Sea</flux:select.option>
                        <flux:select.option value="In Port">In Port</flux:select.option>
                        <flux:select.option value="At Anchorage">At Anchorage</flux:select.option>
                        <flux:select.option value="At Drifting">At Drifting</flux:select.option>
                    </flux:select>
                    <flux:input label="Date/Time (LT)" type="date" max="2999-12-31" badge="Required" required />
                    <flux:select label="GMT Offset" badge="Required" required>
                        <flux:select.option value="" disabled selected>Select</flux:select.option>
                        @foreach ($gmtOffsets as $offset)
                            <flux:select.option value="{{ $offset }}">{{ $offset }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:input label="Latitude" badge="Required" required />
                    <flux:input label="Longitude" badge="Required" required />

                    @if ($report_type === 'In Port')
                        <flux:input label="Port of Departure" badge="Required" required
                            wire:model.defer="port_of_departure" />
                    @endif
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Details Since Last Report</flux:legend>
            <div class="space-y-6">
                @if ($report_type === 'At Sea')
                    <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                        <!-- Row 1 -->
                        <flux:input label="CP/Ordered Speed (Kts)" />
                        <flux:input label="Allowed M/E Cons. at C/P Speed" />
                        <flux:input label="Obs. Distance (NM)" />
                        <flux:input label="Steaming Time (Hrs)" />
                        <!-- Row 2 -->
                        <flux:input label="Avg Speed (Kts)" />
                        <flux:input label="Distance to go (NM)" />
                        <flux:input label="Course (Deg)" />
                        <flux:input label="Breakdown (Hrs)" />
                        <!-- Row 3 -->
                        <flux:input label="Avg RPM" />
                        <flux:input label="Engine Distance (NM)" />
                        <flux:input label="Slip (%)" />
                        <flux:input label="M/E Output (% MCR)" />
                        <!-- Row 4 -->
                        <flux:input label="Avg Power (KW)" />
                        <flux:input label="Logged Distance (NM)" />
                        <flux:input label="Speed Through Water (Kts)" />
                        <flux:input label="Next Port" />
                        <!-- Row 5 -->
                        <flux:input label="ETA Next Port (LT)" type="date" />
                        <flux:select label="ETA GMT Offset" badge="Required" required>
                            <flux:select.option value="" disabled selected>Select</flux:select.option>
                            @foreach ($gmtOffsets as $offset)
                                <flux:select.option value="{{ $offset }}">{{ $offset }}</flux:select.option>
                            @endforeach
                        </flux:select>

                        <flux:input label="Anchored Hours" />
                        <flux:input label="Drifting Hours" />
                    </div>
                @else
                    <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                        <!-- Row 1 -->
                        <flux:input label="CP/Ordered Speed (Kts)" />
                        <flux:input label="Allowed M/E Cons. at C/P Speed" />
                        <flux:input label="Steaming Time (Hrs)" />
                        <flux:input label="Avg Speed (Kts)" />

                        <!-- Row 2 -->
                        <flux:input label="Course (DEG)" />
                        <flux:input label="Breakdown (Hrs)" />
                        <flux:input label="Avg RPM" />
                        <flux:input label="Engine Distance (NM)" />

                        <!-- Row 3 -->
                        <flux:input label="Slip (%)" />
                        <flux:input label="M/E Output (% MCR)" />
                        <flux:input label="Anchored Hours" />
                        <flux:input label="Drifting Hours" />

                        <!-- Row 4 -->
                        @if ($report_type === 'In Port')
                            <flux:input label="Maneuvering Hours" />
                        @endif
                    </div>
                @endif
            </div>
        </flux:fieldset>
    </div>

    @if ($report_type === 'At Sea')
        <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
            <flux:fieldset>
                <flux:legend>Voyage Itinerary</flux:legend>
                <div class="space-y-6">
                    <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                        <flux:input label="Next Port" />
                        <flux:select label="Via" badge="Required" required>
                            <flux:select.option selected>Direct</flux:select.option>
                            <flux:select.option>Cape Horn</flux:select.option>
                            <flux:select.option>Cape of Good Hope</flux:select.option>
                            <flux:select.option>Gibraltar</flux:select.option>
                            <flux:select.option>Magellan Strait</flux:select.option>
                            <flux:select.option>Panama Canal</flux:select.option>
                            <flux:select.option>Suez Canal</flux:select.option>
                        </flux:select>

                        <flux:input label="ETA (LT)" type="date" />
                        <flux:select label="GMT Offset" badge="Required" required>
                            <flux:select.option value="" disabled selected>Select</flux:select.option>
                            @foreach ($gmtOffsets as $offset)
                                <flux:select.option value="{{ $offset }}">{{ $offset }}</flux:select.option>
                            @endforeach
                        </flux:select>

                        <flux:input label="Distance to go" />
                        <flux:input label="Projected Speed (kts)" />
                    </div>
                </div>
            </flux:fieldset>
        </div>
    @endif

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Noon Conditions</flux:legend>
            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:select label="Condition" badge="Required" placeholder="Select Condition" required>
                        <flux:select.option>Ballast</flux:select.option>
                        <flux:select.option>Laden</flux:select.option>
                    </flux:select>
                    <flux:input label="Displacement (MT)" />
                    <flux:input label="Cargo Name" />
                    <flux:input label="Cargo Weight (MT)" />

                    <flux:input label="Ballast Weight (MT)" />
                    <flux:input label="Fresh Water (MT)" />
                    <flux:input label="Fwd Draft (m)" />
                    <flux:input label="Aft Draft (m)" />

                    <flux:input label="GM" class="w-full" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Average Weather</flux:legend>
            <div class="space-y-6">
                <!-- Row 1: 4 columns -->
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:input label="Wind Force (Bft.) (T)" />
                    <flux:select label="Swell" badge="Required" placeholder="Select" required>
                        <flux:select.option>00 NO SWELL</flux:select.option>
                        <flux:select.option>01 LOW SWELL, SHORT OR AVERAGE LENGTH</flux:select.option>
                        <flux:select.option>02 LOW SWELL, LONG</flux:select.option>
                        <flux:select.option>03 MODERATE SWELL, SHORT</flux:select.option>
                        <flux:select.option>04 MODERATE SWELL, AVERAGE LENGTH</flux:select.option>
                        <flux:select.option>05 MODERATE SWELL, LONG</flux:select.option>
                        <flux:select.option>06 HEAVY SWELL, SHORT</flux:select.option>
                        <flux:select.option>07 HEAVY SWELL, AVERAGE LENGTH</flux:select.option>
                        <flux:select.option>08 HEAVY SWELL, LONG</flux:select.option>
                        <flux:select.option>09 PROFUSE SWELL</flux:select.option>
                        <flux:select.option>10 NOT APPLICABLE</flux:select.option>
                    </flux:select>

                    <flux:input label="Sea Currents (Kts) (Rel.)" />
                    <flux:input label="Sea Temp (Deg. C)" />

                    <flux:select label="Observed Wind Dir. (T)" badge="Required" required>
                        <flux:select.option value="" disabled selected>Select</flux:select.option>
                        @foreach ($directions as $direction)
                            <flux:select.option value="{{ $direction }}">{{ $direction }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input label="Wind Sea Height (m)" />
                    <flux:select label="Sea Current Direction (Rel.)" badge="Required" placeholder="Select" required>
                        <flux:select.option selected>Select..</flux:select.option>
                        <flux:select.option>Favorable</flux:select.option>
                        <flux:select.option>Againts</flux:select.option>
                    </flux:select>

                    <flux:input label="Swell Height (m)" />
                    <flux:select label="Observed Sea Dir. (T)" badge="Required" required>
                        <flux:select.option value="" disabled selected>Select</flux:select.option>
                        @foreach ($directions as $direction)
                            <flux:select.option value="{{ $direction }}">{{ $direction }}</flux:select.option>
                        @endforeach
                    </flux:select>

                    <flux:input label="Air Temp (Deg. C)" />
                    <flux:select label="Observed Swell Dir. (T)" badge="Required" required>
                        <flux:select.option value="" disabled selected>Select</flux:select.option>
                        @foreach ($directions as $direction)
                            <flux:select.option value="{{ $direction }}">{{ $direction }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <flux:input label="Air Temp (Deg. C)" />

                    <flux:input label="Sea DS" />

                    <flux:input label="Atm. Pressure (millibar)" class="w-full" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Bad Weather Details</flux:legend>
            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:input label="Wind force (Bft.) >0 hrs (since last report)" />
                    <flux:input label="Wind Force (Bft.) (continuous)" />
                    <flux:input label="Sea State (DS) >0 hrs (since last report)" />
                    <flux:input label="Sea State (continuous)" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Wind Force/Dir for every six hours</flux:legend>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="text-white">
                            <th class="px-4 py-2">Time (LT)</th>
                            <th class="px-4 py-2">Wind Force (Bft.)</th>
                            <th class="px-4 py-2">Wind Direction (T)</th>
                            <th class="px-4 py-2">Swell Height (m)</th>
                            <th class="px-4 py-2">Swell Direction (T)</th>
                            <th class="px-4 py-2">Wind Sea Height (m)</th>
                            <th class="px-4 py-2">Sea Direction (T)</th>
                            <th class="px-4 py-2">Sea DS</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $periods = ['12:00 - 18:00', '18:00 - 00:00', '00:00 - 06:00', '06:00 - 12:00'];
                        @endphp
                        @foreach ($periods as $idx => $period)
                            <tr>
                                <td class="px-4 py-2 font-semibold">{{ $period }}</td>
                                <td class="px-4 py-2">
                                    <flux:select label="" required name="wind_force_{{ $idx }}">
                                        <flux:select.option value="" disabled selected>Select
                                        </flux:select.option>
                                        @foreach ($winds as $wind)
                                            <flux:select.option value="{{ $wind }}">{{ $wind }}
                                            </flux:select.option>
                                        @endforeach
                                    </flux:select>
                                </td>
                                <td class="px-4 py-2">
                                    <flux:select label="" required name="wind_dir_{{ $idx }}">
                                        <flux:select.option value="" disabled selected>Select
                                        </flux:select.option>
                                        @foreach ($directions as $direction)
                                            <flux:select.option value="{{ $direction }}">{{ $direction }}
                                            </flux:select.option>
                                        @endforeach
                                    </flux:select>
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input label="" name="swell_height_{{ $idx }}" />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:select label="" required name="swell_dir_{{ $idx }}">
                                        <flux:select.option value="" disabled selected>Select
                                        </flux:select.option>
                                        @foreach ($directions as $direction)
                                            <flux:select.option value="{{ $direction }}">{{ $direction }}
                                            </flux:select.option>
                                        @endforeach
                                    </flux:select>
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input label="" name="wind_sea_height_{{ $idx }}" />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:select label="" required name="sea_dir_{{ $idx }}">
                                        <flux:select.option value="" disabled selected>Select
                                        </flux:select.option>
                                        @foreach ($directions as $direction)
                                            <flux:select.option value="{{ $direction }}">{{ $direction }}
                                            </flux:select.option>
                                        @endforeach
                                    </flux:select>
                                </td>
                                <td class="px-4 py-2">
                                    <flux:select label="" required name="sea_ds_{{ $idx }}">
                                        <flux:select.option value="" disabled selected>Select
                                        </flux:select.option>
                                        @foreach ($seas as $sea)
                                            <flux:select.option value="{{ $sea }}">{{ $sea }}
                                            </flux:select.option>
                                        @endforeach
                                    </flux:select>
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
                            @foreach ($robs[$type] as $index => $row)
                                <tr wire:key="{{ $type }}-{{ $index }}">
                                    <td class="px-4 py-2">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2">
                                        <flux:input
                                            wire:model="robs.{{ $type }}.{{ $index }}.description" />
                                    </td>
                                    <td class="px-4 py-2">
                                        <flux:select wire:model="robs.{{ $type }}.{{ $index }}.grade">
                                            <flux:select.option>{{ $type }}</flux:select.option>
                                            @foreach ($bunkerTypes as $other)
                                                @if ($other !== $type)
                                                    <flux:select.option>{{ $other }}</flux:select.option>
                                                @endif
                                            @endforeach
                                        </flux:select>
                                    </td>
                                    <td class="px-4 py-2">
                                        <flux:input
                                            wire:model="robs.{{ $type }}.{{ $index }}.capacity" />
                                    </td>
                                    <td class="px-4 py-2">
                                        <flux:select wire:model="robs.{{ $type }}.{{ $index }}.unit">
                                            <flux:select.option>MT</flux:select.option>
                                            <flux:select.option>L</flux:select.option>
                                            <flux:select.option>GAL</flux:select.option>
                                        </flux:select>
                                    </td>
                                    <td class="px-4 py-2">
                                        <flux:input wire:model="robs.{{ $type }}.{{ $index }}.rob" />
                                    </td>
                                    <td class="px-4 py-2">
                                        <flux:input type="date"
                                            wire:model="robs.{{ $type }}.{{ $index }}.supply_date" />
                                    </td>
                                    <td class="px-4 py-2">
                                        <flux:button icon="minus" variant="danger"
                                            wire:click="removeRobRow('{{ $type }}', {{ $index }})" />
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="flex items-end justify-end w-full">
                        <flux:button icon="plus" wire:click="addRobRow('{{ $type }}')" variant="primary">
                            Add Row
                        </flux:button>
                    </div>
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
                                <td class="px-4 py-2">
                                    <flux:input />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input value="0.000" disabled />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input value="0.000" />
                                </td>
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
                                <td class="px-4 py-2">
                                    <flux:input />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input />
                                </td>
                                <!-- ME CC -->
                                <td class="px-4 py-2">
                                    <flux:input />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input />
                                </td>
                                <!-- AE CC -->
                                <td class="px-4 py-2">
                                    <flux:input />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input />
                                </td>
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

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Diesel Engine</flux:legend>
            <div class="space-y-6">
                <div class="grid grid-cols-3 gap-x-4 gap-y-6">
                    <flux:input label="DG1 Run Hours" />
                    <flux:input label="DG2 Run Hours" />
                    <flux:input label="DG3 Run Hours" />
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
