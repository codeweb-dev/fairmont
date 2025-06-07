<div class="border dark:border-zinc-700 mb-6 border-zinc-200 p-6 rounded-md">
    <flux:fieldset>
        <flux:legend>Voyage Itinerary</flux:legend>
        <div class="space-y-6">
            <div class="grid grid-cols-4 gap-x-4 gap-y-6">
                <flux:input label="Port" />
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
                <flux:select label="GMT Offset" badge="Required" placeholder="Select" required>
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

                <flux:input label="Distance to go" />
                <flux:input label="Projected Speed (kts)" />
            </div>
        </div>
    </flux:fieldset>
</div>
