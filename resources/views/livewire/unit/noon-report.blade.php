<div>
    <div class="mb-6 flex items-center justify-between w-full">
        <flux:heading size="xl" class="font-bold">Noon Report</flux:heading>

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
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:select label="Vessel Name" badge="Required" required>
                        <option selected>Select Vessel</option>
                        <!-- ... -->
                    </flux:select>
                    <flux:input label="Voyage No" badge="Required" required />
                    <flux:select label="Report Type" badge="Required" required>
                        <option selected>Select</option>
                        <!-- ... -->
                    </flux:select>
                    <flux:input label="Date/Time (LT)" type="date" max="2999-12-31" badge="Required" required />
                    <flux:select label="GMT Offset" badge="Required" required>
                        <option selected>Select</option>
                        <!-- ... -->
                    </flux:select>
                    <flux:input label="Latitude" badge="Required" required />
                    <flux:input label="Longitude" badge="Required" required />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Details Since Last Report</flux:legend>
            <div class="space-y-6">
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
                        <option selected>Select</option>
                        <!-- ... -->
                    </flux:select>
                    <flux:input label="Anchored Hours" />
                    <flux:input label="Drifting Hours" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Noon Conditions</flux:legend>
            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:select label="Condition" badge="Required" required>
                        <option selected>Select</option>
                        <!-- ... -->
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
            <flux:legend>Voyage Itinerary</flux:legend>
            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:input label="Next Port" />
                    <flux:select label="Via" badge="Required" required>
                        <option selected>Select</option>
                        <!-- ... -->
                    </flux:select>
                    <flux:input label="ETA (LT)" type="date" />
                    <flux:select label="GMT Offset" badge="Required" required>
                        <option selected>Select</option>
                        <!-- ... -->
                    </flux:select>

                    <flux:input label="Distance to go" />
                    <flux:input label="Projected Speed (kts)" />
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
                    <flux:select label="Swell" badge="Required" required>
                        <option selected>Select</option>
                        <!-- ... -->
                    </flux:select>
                    <flux:input label="Sea Currents (Kts) (Rel.)" />
                    <flux:input label="Sea Temp (Deg. C)" />

                    <flux:select label="Observed Wind Dir. (T)" badge="Required" required>
                        <option selected>Select</option>
                        <!-- ... -->
                    </flux:select>
                    <flux:input label="Wind Sea Height (m)" />
                    <flux:select label="Sea Current Direction (Rel.)" badge="Required" required>
                        <option selected>Select</option>
                        <!-- ... -->
                    </flux:select>
                    <flux:input label="Swell Height (m)" />

                    <flux:select label="Observed Sea Dir. (T)" badge="Required" required>
                        <option selected>Select</option>
                        <!-- ... -->
                    </flux:select>
                    <flux:input label="Air Temp (Deg. C)" />
                    <flux:select label="Observed Swell Dir. (T)" badge="Required" required>
                        <option selected>Select</option>
                        <!-- ... -->
                    </flux:select>
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
                                    <flux:select label="" name="wind_force_{{ $idx }}">
                                        <option selected>Select</option>
                                        <!-- ... -->
                                    </flux:select>
                                </td>
                                <td class="px-4 py-2">
                                    <flux:select label="" name="wind_dir_{{ $idx }}">
                                        <option selected>Select</option>
                                        <!-- ... -->
                                    </flux:select>
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input label="" name="swell_height_{{ $idx }}" />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:select label="" name="swell_dir_{{ $idx }}">
                                        <option selected>Select</option>
                                        <!-- ... -->
                                    </flux:select>
                                </td>
                                <td class="px-4 py-2">
                                    <flux:input label="" name="wind_sea_height_{{ $idx }}" />
                                </td>
                                <td class="px-4 py-2">
                                    <flux:select label="" name="sea_dir_{{ $idx }}">
                                        <option selected>Select</option>
                                        <!-- ... -->
                                    </flux:select>
                                </td>
                                <td class="px-4 py-2">
                                    <flux:select label="" name="sea_ds_{{ $idx }}">
                                        <option selected>Select</option>
                                        <!-- ... -->
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

            <!-- Grade Buttons -->
            <div class="flex space-x-6 mb-6">
                <flux:button>HSFO</flux:button>
                <flux:button>BIOFUEL</flux:button>
                <flux:button>VLSFO</flux:button>
                <flux:button>LSMGO</flux:button>
            </div>

            <!-- Tank Table -->
            <div class="overflow-x-auto mb-8">
                <table class="min-w-full">
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
                            <td class="px-4 py-2">
                                <flux:input placeholder="Enter tank name here" />
                            </td>
                            <td class="px-4 py-2">
                                <flux:select label="">
                                    <option selected>Select</option>
                                    <!-- ... -->
                                </flux:select>
                            </td>
                            <td class="px-4 py-2">
                                <flux:input placeholder="Enter tank capacity" />
                            </td>
                            <td class="px-4 py-2">
                                <flux:select label="">
                                    <option selected>MT</option>
                                    <!-- ... -->
                                </flux:select>
                            </td>
                            <td class="px-4 py-2">
                                <flux:input />
                            </td>
                            <td class="px-4 py-2">
                                <flux:input type="date" />
                            </td>
                            <td class="px-4 py-2">
                                <flux:button icon="plus" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- ROB/Consumption Table -->
            <div class="overflow-x-auto mb-8">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-zinc-800 text-white">
                            <th class="px-4 py-2" rowspan="2">Bunker Type</th>
                            <th class="px-4 py-2" colspan="2">ROB (in MT)</th>
                            <th class="px-4 py-2" colspan="4">Consumption</th>
                            <th class="px-4 py-2" colspan="2">Cons./24 hr</th>
                            <th class="px-4 py-2" rowspan="2">Total Cons.</th>
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
                            <td class="px-4 py-2 font-semibold">HSFO (MT)</td>
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

            <!-- Oil Table (ME CYL, ME CC, AE CC) -->
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead>
                        <tr class="bg-zinc-800 text-white">
                            <th class="px-4 py-2" colspan="3">ME CYL</th>
                            <th class="px-4 py-2" colspan="3">ME CC</th>
                            <th class="px-4 py-2" colspan="3">AE CC</th>
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
                                <flux:select label="">
                                    <option selected>Select</option>
                                    <!-- ... -->
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
        </flux:fieldset>
    </div>

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
            <flux:legend>Remarks</flux:legend>
            <div class="space-y-6">
                <div class="w-full">
                    <flux:textarea rows="8" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Master's Info</flux:legend>
            <div class="space-y-6">
                <div class="w-full">
                    <flux:textarea rows="8" />
                </div>
            </div>
        </flux:fieldset>
    </div>

    <div class="flex items-center justify-center w-full">
        <flux:button>Submit</flux:button>
    </div>
</div>
