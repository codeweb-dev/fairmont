<table border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            @php
                $headers = [
                    // Voyage Details
                    'Vessel Name',
                    'Voyage No',
                    'Date/Time (LT)',
                    'GMT Offset',
                    'Latitude',
                    'Longitude',
                    'Departure Type',
                    'Departure Port',

                    // Since Last Report
                    'CP/Ordered Speed (Kts)',
                    'Obs. Distance (NM)',
                    'Steaming Time (Hrs)',
                    'Avg Speed (Kts)',
                    'Distance to Go (NM)',
                    'Avg RPM',
                    'Engine Distance (NM)',
                    'Slip (%)',
                    'Avg Power (KW)',
                    'Course (Deg)',
                    'Logged Distance (NM)',
                    'Speed Through Water (Kts)',
                    'Next Port',
                    'ETA Next Port (LT)',
                    'ETA GMT Offset',

                    // Departure Conditions
                    'Departure Condition',
                    'Displacement (MT)',
                    'Cargo Name',
                    'Cargo Weight (MT)',
                    'Ballast Weight (MT)',
                    'Fresh Water (MT)',
                    'Fwd Draft (m)',
                    'Aft Draft (m)',
                    'GM',

                    // Voyage Itinerary
                    'Next Port',
                    'Via',
                    'ETA (LT)',
                    'GMT Offset',
                    'Distance to go',
                    'Projected Speed (kts)',
                ];

                // Add flattened ROB fuel headers dynamically
                $fuelTypes = ['HSFO', 'BIOFUEL', 'VLSFO', 'LSMGO']; // Adjust as needed
                foreach ($fuelTypes as $type) {
                    $headers = array_merge($headers, [
                        "{$type} Previous",
                        "{$type} Current",
                        "{$type} M/E Propulsion",
                        "{$type} A/E Cons",
                        "{$type} Boiler Cons",
                        "{$type} Incinerators",
                        "{$type} M/E 24",
                        "{$type} A/E 24",
                        "{$type} Total Cons",
                        "{$type} ME CYL Grade",
                        "{$type} ME CYL Qty",
                        "{$type} ME CYL Hrs",
                        "{$type} ME CYL Cons",
                        "{$type} ME CC Qty",
                        "{$type} ME CC Hrs",
                        "{$type} ME CC Cons",
                        "{$type} AE CC Qty",
                        "{$type} AE CC Hrs",
                        "{$type} AE CC Cons",
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
                <td>{{ $report->vessel->name ?? '' }}</td>
                <td>{{ $report->voyage_no ?? '' }}</td>
                <td>{{ $report->all_fast_datetime ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') : '' }}
                </td>
                <td>{{ $report->gmt_offset ?? '' }}</td>
                <td>{{ $report->port ?? '' }}</td>
                <td>{{ $report->bunkering_port ?? '' }}</td>
                <td>{{ $report->port_gmt_offset ?? '' }}</td>
                <td>{{ $report->supplier ?? '' }}</td>

                {{-- Since Last Report --}}
                <td>{{ $report->noon_report->cp_ordered_speed ?? '' }}</td>
                <td>{{ $report->noon_report->obs_distance ?? '' }}</td>
                <td>{{ $report->noon_report->steaming_time ?? '' }}</td>
                <td>{{ $report->noon_report->avg_speed ?? '' }}</td>
                <td>{{ $report->noon_report->distance_to_go ?? '' }}</td>
                <td>{{ $report->noon_report->avg_rpm ?? '' }}</td>
                <td>{{ $report->noon_report->engine_distance ?? '' }}</td>
                <td>{{ $report->noon_report->maneuvering_hours ?? '' }}</td>
                <td>{{ $report->noon_report->avg_power ?? '' }}</td>
                <td>{{ $report->noon_report->course ?? '' }}</td>
                <td>{{ $report->noon_report->logged_distance ?? '' }}</td>
                <td>{{ $report->noon_report->speed_through_water ?? '' }}</td>
                <td>{{ $report->noon_report->next_port ?? '' }}</td>
                <td>{{ $report->noon_report->eta_next_port ? \Carbon\Carbon::parse($report->noon_report->eta_next_port)->format('M d, Y h:i A') : '' }}
                </td>
                <td>{{ $report->noon_report->eta_gmt_offset ?? '' }}</td>

                {{-- Departure Conditions --}}
                <td>{{ $report->noon_report->condition ?? '' }}</td>
                <td>{{ $report->noon_report->displacement ?? '' }}</td>
                <td>{{ $report->noon_report->cargo_name ?? '' }}</td>
                <td>{{ $report->noon_report->cargo_weight ?? '' }}</td>
                <td>{{ $report->noon_report->ballast_weight ?? '' }}</td>
                <td>{{ $report->noon_report->fresh_water ?? '' }}</td>
                <td>{{ $report->noon_report->fwd_draft ?? '' }}</td>
                <td>{{ $report->noon_report->aft_draft ?? '' }}</td>
                <td>{{ $report->noon_report->gm ?? '' }}</td>

                {{-- Voyage Itinerary --}}
                <td>{{ $report->noon_report->next_port_voyage ?? '' }}</td>
                <td>{{ $report->noon_report->via ?? '' }}</td>
                <td>{{ $report->noon_report->eta_lt ? \Carbon\Carbon::parse($report->noon_report->eta_lt)->format('M d, Y h:i A') : '' }}
                </td>
                <td>{{ $report->noon_report->gmt_offset_voyage ?? '' }}</td>
                <td>{{ $report->noon_report->distance_to_go_voyage ?? '' }}</td>
                <td>{{ $report->noon_report->projected_speed ?? '' }}</td>

                {{-- Flattened ROB Fuel Reports --}}
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
                <td>{{ $report->remarks->remarks ?? '' }}</td>
                <td>{{ $report->master_info->master_info ?? '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
