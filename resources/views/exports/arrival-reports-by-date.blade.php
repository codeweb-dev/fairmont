<table border="1" cellspacing="0" cellpadding="4" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            @php
                $headers = [
                    // Voyage Details
                    'Vessel Name', 'Voyage No', 'Date/Time (LT)', 'GMT Offset', 'Latitude', 'Longitude',
                    'Arrival Type', 'Arrival Port', 'Anchored Hours', 'Drifting Hours',

                    // Since Last Report
                    'CP/Ordered Speed (Kts)', 'Allowed M/E Cons. at C/P Speed', 'Obs. Distance (NM)', 'Steaming Time (Hrs)',
                    'Avg Speed (Kts)', 'Distance sailed from last port (NM)', 'Breakdown (Hrs)', 'M/E Revs Counter (Noon to Noon)',
                    'Avg RPM', 'Engine Distance (NM)', 'Slip (%)', 'Avg Power (KW)', 'Logged Distance (NM)',
                    'Speed Through Water (Kts)', 'Course (Deg)',

                    // Arrival Conditions
                    'Condition', 'Displacement (MT)', 'Cargo Name', 'Cargo Weight (MT)',
                    'Ballast Weight (MT)', 'Fresh Water (MT)', 'Fwd Draft (m)', 'Aft Draft (m)', 'GM',

                    // ROB Fuel (per entry)
                    'Fuel Type', 'Previous', 'Current', 'M/E Propulsion', 'A/E Cons', 'Boiler Cons',
                    'Incinerators', 'M/E 24', 'A/E 24', 'Total Cons.',
                    'ME CYL Grade', 'ME CYL Qty', 'ME CYL Hrs', 'ME CYL Cons',
                    'ME CC Qty', 'ME CC Hrs', 'ME CC Cons',
                    'AE CC Qty', 'AE CC Hrs', 'AE CC Cons',

                    // Final
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
                <tr><td colspan="11" style="height: 15px;"></td></tr> {{-- Spacer --}}
            @endif

            @for ($i = 0; $i < $max; $i++)
                @php $fuel = $robFuels[$i] ?? null; @endphp

                {{-- Skip if this fuel record is empty --}}
                @if ($fuel && collect($fuel->toArray())->filter()->isEmpty())
                    @continue
                @endif

                <tr>
                    {{-- Voyage Details --}}
                    <td>{{ $report->vessel->name ?? '' }}</td>
                    <td>{{ $report->voyage_no ?? '' }}</td>
                    <td>{{ $report->all_fast_datetime ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') : '' }}</td>
                    <td>{{ $report->gmt_offset ?? '' }}</td>
                    <td>{{ $report->port ?? '' }}</td>
                    <td>{{ $report->bunkering_port ?? '' }}</td>
                    <td>{{ $report->port_gmt_offset ?? '' }}</td>
                    <td>{{ $report->supplier ?? '' }}</td>
                    <td>{{ $report->call_sign ?? '' }}</td>
                    <td>{{ $report->flag ?? '' }}</td>

                    {{-- Since Last Report --}}
                    <td>{{ $noon->cp_ordered_speed ?? '' }}</td>
                    <td>{{ $noon->me_cons_cp_speed ?? '' }}</td>
                    <td>{{ $noon->obs_distance ?? '' }}</td>
                    <td>{{ $noon->steaming_time ?? '' }}</td>
                    <td>{{ $noon->avg_speed ?? '' }}</td>
                    <td>{{ $noon->distance_to_go ?? '' }}</td>
                    <td>{{ $noon->breakdown ?? '' }}</td>
                    <td>{{ $noon->maneuvering_hours ?? '' }}</td>
                    <td>{{ $noon->avg_rpm ?? '' }}</td>
                    <td>{{ $noon->engine_distance ?? '' }}</td>
                    <td>{{ $noon->next_port ?? '' }}</td>
                    <td>{{ $noon->avg_power ?? '' }}</td>
                    <td>{{ $noon->logged_distance ?? '' }}</td>
                    <td>{{ $noon->speed_through_water ?? '' }}</td>
                    <td>{{ $noon->course ?? '' }}</td>

                    {{-- Arrival Conditions --}}
                    <td>{{ $noon->condition ?? '' }}</td>
                    <td>{{ $noon->displacement ?? '' }}</td>
                    <td>{{ $noon->cargo_name ?? '' }}</td>
                    <td>{{ $noon->cargo_weight ?? '' }}</td>
                    <td>{{ $noon->ballast_weight ?? '' }}</td>
                    <td>{{ $noon->fresh_water ?? '' }}</td>
                    <td>{{ $noon->fwd_draft ?? '' }}</td>
                    <td>{{ $noon->aft_draft ?? '' }}</td>
                    <td>{{ $noon->gm ?? '' }}</td>

                    {{-- ROB Fuel (per fuel row) --}}
                    <td>{{ $fuel->fuel_type ?? '' }}</td>
                    <td>{{ $fuel->previous ?? '' }}</td>
                    <td>{{ $fuel->current ?? '' }}</td>
                    <td>{{ $fuel->me_propulsion ?? '' }}</td>
                    <td>{{ $fuel->ae_cons ?? '' }}</td>
                    <td>{{ $fuel->boiler_cons ?? '' }}</td>
                    <td>{{ $fuel->incinerators ?? '' }}</td>
                    <td>{{ $fuel->me_24 ?? '' }}</td>
                    <td>{{ $fuel->ae_24 ?? '' }}</td>
                    <td>{{ $fuel->total_cons ?? '' }}</td>

                    <td>{{ $fuel->me_cyl_grade ?? '' }}</td>
                    <td>{{ $fuel->me_cyl_qty ?? '' }}</td>
                    <td>{{ $fuel->me_cyl_hrs ?? '' }}</td>
                    <td>{{ $fuel->me_cyl_cons ?? '' }}</td>
                    <td>{{ $fuel->me_cc_qty ?? '' }}</td>
                    <td>{{ $fuel->me_cc_hrs ?? '' }}</td>
                    <td>{{ $fuel->me_cc_cons ?? '' }}</td>
                    <td>{{ $fuel->ae_cc_qty ?? '' }}</td>
                    <td>{{ $fuel->ae_cc_hrs ?? '' }}</td>
                    <td>{{ $fuel->ae_cc_cons ?? '' }}</td>

                    {{-- Final --}}
                    <td>{{ $report->remarks->remarks ?? '' }}</td>
                    <td>{{ $report->master_info->master_info ?? '' }}</td>
                </tr>
            @endfor
        @endforeach
    </tbody>
</table>
