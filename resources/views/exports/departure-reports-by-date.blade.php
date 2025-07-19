<table border="1" cellspacing="0" cellpadding="4" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            @php
                $headers = [
                    // Voyage Info
                    'Vessel',
                    'Voyage No',
                    'Date/Time (LT)',
                    'GMT Offset',
                    'Latitude',
                    'Longitude',
                    'Departure Type',
                    'Departure Port',

                    // Since Last Report
                    'CP/Ordered Speed',
                    'Obs. Distance',
                    'Steaming Time',
                    'Avg Speed',
                    'Distance to Go',
                    'Avg RPM',
                    'Engine Distance',
                    'Slip',
                    'Avg Power (KW)',
                    'Course',
                    'Logged Distance',
                    'Speed Through Water',
                    'Next Port',
                    'ETA Next Port',
                    'ETA GMT Offset',

                    // Departure Conditions
                    'Departure Condition',
                    'Displacement',
                    'Cargo Name',
                    'Cargo Weight',
                    'Ballast Weight',
                    'Fresh Water',
                    'Fwd Draft',
                    'Aft Draft',
                    'GM',

                    // Voyage Itinerary
                    'Next Port',
                    'Via',
                    'ETA (LT)',
                    'GMT Offset',
                    'Distance to Go',
                    'Projected Speed',

                    // ROB Fuel (Flat)
                    'Fuel Type',
                    'Previous',
                    'Current',
                    'M/E Propulsion',
                    'A/E Consumption',
                    'Boiler Consumption',
                    'Incinerators',
                    'M/E 24',
                    'A/E 24',
                    'Total Consumption',

                    // Condensed Oil Grades
                    'ME CYL Grade',
                    'ME CYL Quantity',
                    'ME CYL Hours',
                    'ME CYL Consumption',
                    'ME CC Quantity',
                    'ME CC Hours',
                    'ME CC Consumption',
                    'AE CC Quantity',
                    'AE CC Hours',
                    'AE CC Consumption',

                    // Misc
                    'Remarks',
                    'Master Information',
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
                $firstFuel = true;
            @endphp

            @if (!$loop->first)
                <tr>
                    <td colspan="60" style="height: 15px;"></td>
                </tr> {{-- Spacer --}}
            @endif

            @for ($i = 0; $i < $max; $i++)
                @php $fuel = $robFuels[$i] ?? null; @endphp

                @if ($fuel && collect($fuel->toArray())->filter()->isEmpty())
                    @continue
                @endif

                <tr>
                    {{-- Voyage Info --}}
                    <td style="text-align: left;">{{ $firstFuel ? $report->vessel->name ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $report->voyage_no ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($report->all_fast_datetime ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') : '') : '' }}
                    </td>
                    <td style="text-align: left;">{{ $firstFuel ? $report->gmt_offset ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $report->port ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $report->bunkering_port ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $report->port_gmt_offset ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $report->supplier ?? '' : '' }}</td>

                    {{-- Since Last Report --}}
                    <td style="text-align: left;">{{ $firstFuel ? $noon->cp_ordered_speed ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $noon->obs_distance ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $noon->steaming_time ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $noon->avg_speed ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $noon->distance_to_go ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $noon->avg_rpm ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $noon->engine_distance ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $noon->maneuvering_hours ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $noon->avg_power ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $noon->course ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $noon->logged_distance ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $noon->speed_through_water ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $noon->next_port ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($noon->eta_next_port ? \Carbon\Carbon::parse($noon->eta_next_port)->format('M d, Y h:i A') : '') : '' }}
                    </td>
                    <td style="text-align: left;">{{ $firstFuel ? $noon->eta_gmt_offset ?? '' : '' }}</td>

                    {{-- Departure Conditions --}}
                    <td style="text-align: left;">{{ $firstFuel ? $noon->condition ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $noon->displacement ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $noon->cargo_name ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $noon->cargo_weight ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $noon->ballast_weight ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $noon->fresh_water ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $noon->fwd_draft ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $noon->aft_draft ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $noon->gm ?? '' : '' }}</td>

                    {{-- Voyage Itinerary --}}
                    <td style="text-align: left;">{{ $firstFuel ? $noon->next_port_voyage ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $noon->via ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? ($noon->eta_lt ? \Carbon\Carbon::parse($noon->eta_lt)->format('M d, Y h:i A') : '') : '' }}
                    </td>
                    <td style="text-align: left;">{{ $firstFuel ? $noon->gmt_offset_voyage ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $noon->distance_to_go_voyage ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $noon->projected_speed ?? '' : '' }}</td>

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

                    {{-- Oil Grades --}}
                    <td style="text-align: left;">{{ $fuel->me_cyl_grade ?? '' }}</td>
                    <td style="text-align: left;">{{ $fuel->me_cyl_qty ?? '' }}</td>
                    <td style="text-align: left;">{{ $fuel->me_cyl_hrs ?? '' }}</td>
                    <td style="text-align: left;">{{ $fuel->me_cyl_cons ?? '' }}</td>

                    <td style="text-align: left;">{{ $fuel->me_cc_cons ?? '' }}</td>
                    <td style="text-align: left;">{{ $fuel->me_cc_qty ?? '' }}</td>
                    <td style="text-align: left;">{{ $fuel->me_cc_hrs ?? '' }}</td>

                    <td style="text-align: left;">{{ $fuel->ae_cc_cons ?? '' }}</td>
                    <td style="text-align: left;">{{ $fuel->ae_cc_qty ?? '' }}</td>
                    <td style="text-align: left;">{{ $fuel->ae_cc_hrs ?? '' }}</td>

                    {{-- Misc --}}
                    <td style="text-align: left;">{{ $firstFuel ? $report->remarks->remarks ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstFuel ? $report->master_info->master_info ?? '' : '' }}</td>
                </tr>

                @php $firstFuel = false; @endphp
            @endfor
        @endforeach
    </tbody>
</table>
