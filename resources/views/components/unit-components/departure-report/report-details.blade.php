<div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
    <flux:fieldset>
        <flux:legend>Details Since Last Report</flux:legend>
        <div class="space-y-6">
            <!-- All inputs in a 4-column grid, as in the image -->
            <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                <!-- Row 1 -->
                <flux:input label="CP/Ordered Speed (Kts)" />
                <flux:input label="Obs. Distance (NM)" />
                <flux:input label="Steaming Time (Hrs)" />
                <flux:input label="Avg Speed (Kts)" />
                <!-- Row 2 -->
                <flux:input label="Distance to go (NM)" />
                <flux:input label="Avg RPM" />
                <flux:input label="Engine Distance (NM)" />
                <flux:input label="Slip (%)" />
                <!-- Row 3 -->
                <flux:input label="Avg Power (KW)" />
                <flux:input label="Course (Deg)" />
                <flux:input label="Logged Distance (NM)" />
                <flux:input label="Speed Through Water (Kts)" />
                <!-- Row 4: ETA fields, use col-span-2 to fill the row if desired -->
                <div class="col-span-2">
                    <flux:input label="ETA Next Port (LT)" type="datetime" />
                </div>
                <div class="col-span-2">
                    <flux:select label="ETA GMT Offset">
                        <option selected>Select</option>
                        <!-- ... -->
                    </flux:select>
                </div>
            </div>
        </div>
    </flux:fieldset>
</div>
