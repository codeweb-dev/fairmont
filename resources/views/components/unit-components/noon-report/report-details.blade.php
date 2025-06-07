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
                <flux:select label="ETA GMT Offset" badge="Required" placeholder="Select" required>
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
                <flux:input label="Anchored Hours" />
                <flux:input label="Drifting Hours" />
            </div>
        </div>
    </flux:fieldset>
</div>
