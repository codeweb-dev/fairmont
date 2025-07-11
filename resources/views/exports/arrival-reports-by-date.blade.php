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
                    <td>{{ $report->vessel->name ?? 'N/A' }}</td>
                    <td>{{ $report->voyage_no ?? 'N/A' }}</td>
                    <td>{{ $report->all_fast_datetime ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') : 'N/A' }}</td>
                    <td>{{ $report->gmt_offset ?? 'N/A' }}</td>
                    <td>{{ $report->port ?? 'N/A' }}</td>
                    <td>{{ $report->bunkering_port ?? 'N/A' }}</td>
                    <td>{{ $report->port_gmt_offset ?? 'N/A' }}</td>
                    <td>{{ $report->supplier ?? 'N/A' }}</td>
                    <td>{{ $report->call_sign ?? 'N/A' }}</td>
                    <td>{{ $report->flag ?? 'N/A' }}</td>

                    {{-- Since Last Report --}}
                    <td>{{ $noon->cp_ordered_speed ?? 'N/A' }}</td>
                    <td>{{ $noon->me_cons_cp_speed ?? 'N/A' }}</td>
                    <td>{{ $noon->obs_distance ?? 'N/A' }}</td>
                    <td>{{ $noon->steaming_time ?? 'N/A' }}</td>
                    <td>{{ $noon->avg_speed ?? 'N/A' }}</td>
                    <td>{{ $noon->distance_to_go ?? 'N/A' }}</td>
                    <td>{{ $noon->breakdown ?? 'N/A' }}</td>
                    <td>{{ $noon->maneuvering_hours ?? 'N/A' }}</td>
                    <td>{{ $noon->avg_rpm ?? 'N/A' }}</td>
                    <td>{{ $noon->engine_distance ?? 'N/A' }}</td>
                    <td>{{ $noon->next_port ?? 'N/A' }}</td>
                    <td>{{ $noon->avg_power ?? 'N/A' }}</td>
                    <td>{{ $noon->logged_distance ?? 'N/A' }}</td>
                    <td>{{ $noon->speed_through_water ?? 'N/A' }}</td>
                    <td>{{ $noon->course ?? 'N/A' }}</td>

                    {{-- Arrival Conditions --}}
                    <td>{{ $noon->condition ?? 'N/A' }}</td>
                    <td>{{ $noon->displacement ?? 'N/A' }}</td>
                    <td>{{ $noon->cargo_name ?? 'N/A' }}</td>
                    <td>{{ $noon->cargo_weight ?? 'N/A' }}</td>
                    <td>{{ $noon->ballast_weight ?? 'N/A' }}</td>
                    <td>{{ $noon->fresh_water ?? 'N/A' }}</td>
                    <td>{{ $noon->fwd_draft ?? 'N/A' }}</td>
                    <td>{{ $noon->aft_draft ?? 'N/A' }}</td>
                    <td>{{ $noon->gm ?? 'N/A' }}</td>

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
                    <td>{{ $report->remarks->remarks ?? 'N/A' }}</td>
                    <td>{{ $report->master_info->master_info ?? 'N/A' }}</td>
                </tr>
            @endfor
        @endforeach
    </tbody>
</table>
