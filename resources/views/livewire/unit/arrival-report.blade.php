<div>
    <div class="mb-6 flex items-center justify-between w-full">
        <flux:heading size="xl" class="font-bold">Arrival Report</flux:heading>

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
                    <flux:input label="EOSP Date/Time (LT)" type="date" max="2999-12-31" badge="Required" required />
                    <flux:select label="GMT Offset" badge="Required" required>
                        <option selected>Select</option>
                        <!-- ... -->
                    </flux:select>
                    <flux:input label="Latitude" badge="Required" required />
                    <flux:input label="Longitude" badge="Required" required />
                    <flux:select label="Arrival Type" badge="Required" required>
                        <option selected>Select</option>
                        <!-- ... -->
                    </flux:select>
                    <flux:input label="Arrival Port" badge="Required" required />
                    <flux:input label="Anchored Hours" badge="Required" required />
                    <flux:input label="Drifting Hours" badge="Required" required />
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
                    <flux:input label="Distance sailed from last port (NM)" />
                    <flux:input label="Breakdown (Hrs)" />
                    <flux:input label="M/E Revs Counter (Noon to Noon)" />
                    <!-- Row 3 -->
                    <flux:input label="Avg RPM" />
                    <flux:input label="Engine Distance (NM)" />
                    <flux:input label="Slip (%)" />
                    <flux:input label="Avg Power (KW)" />
                    <!-- Row 4 -->
                    <flux:input label="Logged Distance (NM)" />
                    <flux:input label="Speed Through Water (Kts)" />
                    <flux:input label="Course (Deg)" class="col-span-2" />
                </div>
            </div>
        </flux:fieldset>
    </div>
</div>
