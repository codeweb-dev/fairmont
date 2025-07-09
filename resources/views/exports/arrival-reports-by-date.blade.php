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
                ];

                // Common fuel types to include in columns
                $fuelTypes = ['HSFO', 'BIOFUEL', 'VLSFO', 'LSMGO'];

                foreach ($fuelTypes as $type) {
                    $headers = array_merge($headers, [
                        "{$type} Previous", "{$type} Current",
                        "{$type} M/E Propulsion", "{$type} A/E Cons", "{$type} Boiler Cons", "{$type} Incinerators",
                        "{$type} M/E 24", "{$type} A/E 24", "{$type} Total Cons.",
                        "{$type} ME CYL Grade", "{$type} ME CYL Qty", "{$type} ME CYL Hrs", "{$type} ME CYL Cons",
                        "{$type} ME CC Qty", "{$type} ME CC Hrs", "{$type} ME CC Cons",
                        "{$type} AE CC Qty", "{$type} AE CC Hrs", "{$type} AE CC Cons",
                    ]);
                }

                $headers = array_merge($headers, [
                    'Remarks',
                    'Master Information',
                ]);
            @endphp

            @foreach ($headers as $header)
                <th style="width: 250px;">{{ $header }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $report)
            @if (!$loop->first)
                <tr>
                    <td colspan="11" style="height: 15px;"></td> {{-- Spacer row --}}
                </tr>
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
                <td>{{ $report->noon_report->cp_ordered_speed ?? 'N/A' }}</td>
                <td>{{ $report->noon_report->me_cons_cp_speed ?? 'N/A' }}</td>
                <td>{{ $report->noon_report->obs_distance ?? 'N/A' }}</td>
                <td>{{ $report->noon_report->steaming_time ?? 'N/A' }}</td>
                <td>{{ $report->noon_report->avg_speed ?? 'N/A' }}</td>
                <td>{{ $report->noon_report->distance_to_go ?? 'N/A' }}</td>
                <td>{{ $report->noon_report->breakdown ?? 'N/A' }}</td>
                <td>{{ $report->noon_report->maneuvering_hours ?? 'N/A' }}</td>
                <td>{{ $report->noon_report->avg_rpm ?? 'N/A' }}</td>
                <td>{{ $report->noon_report->engine_distance ?? 'N/A' }}</td>
                <td>{{ $report->noon_report->next_port ?? 'N/A' }}</td>
                <td>{{ $report->noon_report->avg_power ?? 'N/A' }}</td>
                <td>{{ $report->noon_report->logged_distance ?? 'N/A' }}</td>
                <td>{{ $report->noon_report->speed_through_water ?? 'N/A' }}</td>
                <td>{{ $report->noon_report->course ?? 'N/A' }}</td>

                {{-- Arrival Conditions --}}
                <td>{{ $report->noon_report->condition ?? 'N/A' }}</td>
                <td>{{ $report->noon_report->displacement ?? 'N/A' }}</td>
                <td>{{ $report->noon_report->cargo_name ?? 'N/A' }}</td>
                <td>{{ $report->noon_report->cargo_weight ?? 'N/A' }}</td>
                <td>{{ $report->noon_report->ballast_weight ?? 'N/A' }}</td>
                <td>{{ $report->noon_report->fresh_water ?? 'N/A' }}</td>
                <td>{{ $report->noon_report->fwd_draft ?? 'N/A' }}</td>
                <td>{{ $report->noon_report->aft_draft ?? 'N/A' }}</td>
                <td>{{ $report->noon_report->gm ?? 'N/A' }}</td>

                {{-- ROB Fuel Reports --}}
                @php
                    $rob = $report->rob_fuel_reports->keyBy('fuel_type');
                @endphp

                @foreach ($fuelTypes as $type)
                    @php $fuel = $rob[$type] ?? null; @endphp
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
                @endforeach

                {{-- Remarks and Master --}}
                <td>{{ $report->remarks->remarks ?? 'N/A' }}</td>
                <td>{{ $report->master_info->master_info ?? 'N/A' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
