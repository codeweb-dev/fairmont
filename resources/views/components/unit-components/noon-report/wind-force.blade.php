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
                                <flux:select label="" placeholder="Select Wind Force"
                                    name="wind_force_{{ $idx }}" required>
                                    <flux:select.option selected>Select Wind Force</flux:select.option>
                                    <flux:select.option>0 - Calm</flux:select.option>
                                    <flux:select.option>1 - Light Air</flux:select.option>
                                    <flux:select.option>2 - Light Air Breeze</flux:select.option>
                                    <flux:select.option>3 - Gentle Breeze</flux:select.option>
                                    <flux:select.option>4 - Moderate Breeze</flux:select.option>
                                    <flux:select.option>5 - Fresh Breeze</flux:select.option>
                                    <flux:select.option>6 - Strong Breeze</flux:select.option>
                                    <flux:select.option>7 - Near Gale</flux:select.option>
                                    <flux:select.option>8 - Gale</flux:select.option>
                                    <flux:select.option>9 - Strong Gale</flux:select.option>
                                    <flux:select.option>10 - Storm</flux:select.option>
                                    <flux:select.option>11 - Violent Storm</flux:select.option>
                                    <flux:select.option>12 - Hurricane</flux:select.option>
                                </flux:select>
                            </td>
                            <td class="px-4 py-2">
                                <flux:select label="" name="wind_dir_{{ $idx }}" placeholder="Select"
                                    required>
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
                            </td>
                            <td class="px-4 py-2">
                                <flux:input label="" name="swell_height_{{ $idx }}" />
                            </td>
                            <td class="px-4 py-2">
                                <flux:select label="" name="swell_dir_{{ $idx }}" placeholder="Select"
                                    required>
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
                            </td>
                            <td class="px-4 py-2">
                                <flux:input label="" name="wind_sea_height_{{ $idx }}" />
                            </td>
                            <td class="px-4 py-2">
                                <flux:select label="" name="sea_dir_{{ $idx }}" placeholder="Select"
                                    required>
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
                            </td>
                            <td class="px-4 py-2">
                                <flux:select label="" name="sea_ds_{{ $idx }}" placeholder="Select"
                                    required>
                                    <flux:select.option>0 - (No Wave)</flux:select.option>
                                    <flux:select.option>1 - (0-0.1m)</flux:select.option>
                                    <flux:select.option>2 - (0.1-0.5m)</flux:select.option>
                                    <flux:select.option>3 - (0.5-1.25m)</flux:select.option>
                                    <flux:select.option>4 - (1.25-2.5m)</flux:select.option>
                                    <flux:select.option>5 - (2.5-4.0m)</flux:select.option>
                                    <flux:select.option>6 - (4.0-6.0m)</flux:select.option>
                                    <flux:select.option>7 - (6.0-9.0m)</flux:select.option>
                                    <flux:select.option>8 - (9.0-14.0m)</flux:select.option>
                                    <flux:select.option>9 - (14+m)</flux:select.option>
                                </flux:select>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </flux:fieldset>
</div>
