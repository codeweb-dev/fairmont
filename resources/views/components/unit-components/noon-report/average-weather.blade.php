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

                <flux:select label="Observed Wind Dir. (T)" badge="Required" placeholder="Select" required>
                    <flux:select.option>0 - N</flux:select.option>
                    <flux:select.option>22.5 - NNE</flux:select.option>
                    <flux:select.option>45 - NE</flux:select.option>
                    <flux:select.option>67.5 - ENE</flux:select.option>
                    <flux:select.option>90 - E</flux:select.option>
                    <flux:select.option>112.5 - ESE</flux:select.option>
                    <flux:select.option>135 - SE</flux:select.option>
                    <flux:select.option>157.5 - SSE</flux:select.option>
                    <flux:select.option>180 - S</flux:select.option>
                    <flux:select.option>202.5 - SSW</flux:select.option>
                    <flux:select.option>225 - SW</flux:select.option>
                    <flux:select.option>247.5 - WSW</flux:select.option>
                    <flux:select.option>270 - W</flux:select.option>
                    <flux:select.option>292.5 - WNW</flux:select.option>
                    <flux:select.option>315 - NW</flux:select.option>
                    <flux:select.option>337.5 - NNW</flux:select.option>
                </flux:select>

                <flux:input label="Wind Sea Height (m)" />
                <flux:select label="Sea Current Direction (Rel.)" badge="Required" placeholder="Select" required>
                    <flux:select.option selected>Select..</flux:select.option>
                    <flux:select.option>Favorable</flux:select.option>
                    <flux:select.option>Againts</flux:select.option>
                </flux:select>

                <flux:input label="Swell Height (m)" />

                <flux:select label="Observed Sea Dir. (T)" badge="Required" placeholder="Select" required>
                    <flux:select.option>0 - N</flux:select.option>
                    <flux:select.option>22.5 - NNE</flux:select.option>
                    <flux:select.option>45 - NE</flux:select.option>
                    <flux:select.option>67.5 - ENE</flux:select.option>
                    <flux:select.option>90 - E</flux:select.option>
                    <flux:select.option>112.5 - ESE</flux:select.option>
                    <flux:select.option>135 - SE</flux:select.option>
                    <flux:select.option>157.5 - SSE</flux:select.option>
                    <flux:select.option>180 - S</flux:select.option>
                    <flux:select.option>202.5 - SSW</flux:select.option>
                    <flux:select.option>225 - SW</flux:select.option>
                    <flux:select.option>247.5 - WSW</flux:select.option>
                    <flux:select.option>270 - W</flux:select.option>
                    <flux:select.option>292.5 - WNW</flux:select.option>
                    <flux:select.option>315 - NW</flux:select.option>
                    <flux:select.option>337.5 - NNW</flux:select.option>
                </flux:select>

                <flux:input label="Air Temp (Deg. C)" />
                <flux:select label="Observed Swell Dir. (T)" badge="Required" placeholder="Select" required>
                    <flux:select.option>0 - N</flux:select.option>
                    <flux:select.option>22.5 - NNE</flux:select.option>
                    <flux:select.option>45 - NE</flux:select.option>
                    <flux:select.option>67.5 - ENE</flux:select.option>
                    <flux:select.option>90 - E</flux:select.option>
                    <flux:select.option>112.5 - ESE</flux:select.option>
                    <flux:select.option>135 - SE</flux:select.option>
                    <flux:select.option>157.5 - SSE</flux:select.option>
                    <flux:select.option>180 - S</flux:select.option>
                    <flux:select.option>202.5 - SSW</flux:select.option>
                    <flux:select.option>225 - SW</flux:select.option>
                    <flux:select.option>247.5 - WSW</flux:select.option>
                    <flux:select.option>270 - W</flux:select.option>
                    <flux:select.option>292.5 - WNW</flux:select.option>
                    <flux:select.option>315 - NW</flux:select.option>
                    <flux:select.option>337.5 - NNW</flux:select.option>
                </flux:select>

                <flux:input label="Sea DS" />

                <flux:input label="Atm. Pressure (millibar)" class="w-full" />
            </div>
        </div>
    </flux:fieldset>
</div>
