<div>
    <div class="mb-6 flex items-center justify-between w-full">
        <flux:heading size="xl" class="font-bold">Bunkering</flux:heading>

        <div class="flex items-center gap-3">
            <flux:button icon:trailing="x-mark" variant="danger">Clear Fields</flux:button>
            <flux:button icon="folder-arrow-down">Save Draft</flux:button>
            <flux:button icon="arrow-down-tray">Export Data</flux:button>
        </div>
    </div>

    <div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
        <flux:fieldset>
            <flux:legend>Bunkering Details</flux:legend>

            <div class="space-y-6">
                <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                    <flux:select label="Vessel Name" badge="Required" required>
                        <option selected>Select Vessel</option>
                        <!-- ... -->
                    </flux:select>
                    <flux:input label="Voyage No" badge="Required" required />
                    <flux:input label="Bunkering Port" badge="Required" required />
                    <flux:select label="Supplier" badge="Required" required>
                        <option selected>Select</option>
                        <!-- ... -->
                    </flux:select>
                    <flux:input label="Port ETD (LT)" type="date" max="2999-12-31" badge="Required" required />
                    <flux:select label="Port GMT Offset" badge="Required" required>
                        <option selected>Select</option>
                        <!-- ... -->
                    </flux:select>
                    <flux:input label="Bunker Completed (LT)" type="date" max="2999-12-31" badge="Required"
                        required />
                    <flux:select label="Bunker GMT Offset" badge="Required" required>
                        <option selected>Select</option>
                        <!-- ... -->
                    </flux:select>
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

</div>
