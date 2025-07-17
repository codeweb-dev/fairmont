<table border="1" cellspacing="0" cellpadding="4" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            @php
                $headers = [
                    'Vessel Name', 'Voyage No', 'Date/Time (LT)', 'GMT Offset', 'Latitude', 'Longitude',
                    'Arrival Type', 'Arrival Port', 'Anchored Hours', 'Drifting Hours',
                    'CP/Ordered Speed (Kts)', 'Allowed M/E Cons. at C/P Speed', 'Obs. Distance (NM)', 'Steaming Time (Hrs)',
                    'Avg Speed (Kts)', 'Distance sailed from last port (NM)', 'Breakdown (Hrs)', 'M/E Revs Counter (Noon to Noon)',
                    'Avg RPM', 'Engine Distance (NM)', 'Slip (%)', 'Avg Power (KW)', 'Logged Distance (NM)',
                    'Speed Through Water (Kts)', 'Course (Deg)',
                    'Condition', 'Displacement (MT)', 'Cargo Name', 'Cargo Weight (MT)',
                    'Ballast Weight (MT)', 'Fresh Water (MT)', 'Fwd Draft (m)', 'Aft Draft (m)', 'GM',
                    'Fuel Type', 'Previous', 'Current', 'M/E Propulsion', 'A/E Cons', 'Boiler Cons',
                    'Incinerators', 'M/E 24', 'A/E 24', 'Total Cons.',
                    'ME CYL Grade', 'ME CYL Qty', 'ME CYL Hrs', 'ME CYL Cons',
                    'ME CC Qty', 'ME CC Hrs', 'ME CC Cons',
                    'AE CC Qty', 'AE CC Hrs', 'AE CC Cons',
                    'Remarks', 'Master Information'
                ];
            @endphp

            @foreach ($headers as $header)
                <th style="width: 250px;"><strong>{{ $header }}</strong></th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $report)
            @php
                $noon = $report->noon_report;
                $robFuels = $report->rob_fuel_reports;
                $max = max(1, $robFuels->count());
            @endphp

            @if (!$loop->first)
                <tr><td colspan="60" style="height: 15px;"></td></tr> {{-- Spacer --}}
            @endif

            @php $firstFuel = true; @endphp

            @for ($i = 0; $i < $max; $i++)
                @php $fuel = $robFuels[$i] ?? null; @endphp

                @if ($fuel && collect($fuel->toArray())->filter()->isEmpty())
                    @continue
                @endif

                <tr>
                    {{-- Voyage Details --}}
                    <td style="text-align: left;">{{ $firstFuel ? ($report->vessel->name ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($report->voyage_no ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($report->all_fast_datetime ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') : '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($report->gmt_offset ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($report->port ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($report->bunkering_port ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($report->port_gmt_offset ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($report->supplier ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($report->call_sign ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($report->flag ?? '') : '' }}</td>

                    {{-- Since Last Report --}}
                    <td style="text-align: left;">{{ $firstFuel ? ($noon->cp_ordered_speed ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($noon->me_cons_cp_speed ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($noon->obs_distance ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($noon->steaming_time ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($noon->avg_speed ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($noon->distance_to_go ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($noon->breakdown ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($noon->maneuvering_hours ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($noon->avg_rpm ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($noon->engine_distance ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($noon->next_port ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($noon->avg_power ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($noon->logged_distance ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($noon->speed_through_water ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($noon->course ?? '') : '' }}</td>

                    {{-- Arrival Conditions --}}
                    <td style="text-align: left;">{{ $firstFuel ? ($noon->condition ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($noon->displacement ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($noon->cargo_name ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($noon->cargo_weight ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($noon->ballast_weight ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($noon->fresh_water ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($noon->fwd_draft ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($noon->aft_draft ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($noon->gm ?? '') : '' }}</td>

                    {{-- ROB Fuel --}}
                    <td style="text-align: left;">{{ $fuel->fuel_type ?? '' }}</td>
                    <td style="text-align: left;">{{ $fuel->previous ?? '' }}</td>
                    <td style="text-align: left;">{{ $fuel->current ?? '' }}</td>
                    <td style="text-align: left;">{{ $fuel->me_propulsion ?? '' }}</td>
                    <td style="text-align: left;">{{ $fuel->ae_cons ?? '' }}</td>
                    <td style="text-align: left;">{{ $fuel->boiler_cons ?? '' }}</td>
                    <td style="text-align: left;">{{ $fuel->incinerators ?? '' }}</td>
                    <td style="text-align: left;">{{ $fuel->me_24 ?? '' }}</td>
                    <td style="text-align: left;">{{ $fuel->ae_24 ?? '' }}</td>
                    <td style="text-align: left;">{{ $fuel->total_cons ?? '' }}</td>

                    <td style="text-align: left;">{{ $fuel->me_cyl_grade ?? '' }}</td>
                    <td style="text-align: left;">{{ $fuel->me_cyl_qty ?? '' }}</td>
                    <td style="text-align: left;">{{ $fuel->me_cyl_hrs ?? '' }}</td>
                    <td style="text-align: left;">{{ $fuel->me_cyl_cons ?? '' }}</td>
                    <td style="text-align: left;">{{ $fuel->me_cc_qty ?? '' }}</td>
                    <td style="text-align: left;">{{ $fuel->me_cc_hrs ?? '' }}</td>
                    <td style="text-align: left;">{{ $fuel->me_cc_cons ?? '' }}</td>
                    <td style="text-align: left;">{{ $fuel->ae_cc_qty ?? '' }}</td>
                    <td style="text-align: left;">{{ $fuel->ae_cc_hrs ?? '' }}</td>
                    <td style="text-align: left;">{{ $fuel->ae_cc_cons ?? '' }}</td>

                    {{-- Final --}}
                    <td style="text-align: left;">{{ $firstFuel ? ($report->remarks->remarks ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($report->master_info->master_info ?? '') : '' }}</td>
                </tr>

                @php $firstFuel = false; @endphp
            @endfor
        @endforeach
    </tbody>
</table>
