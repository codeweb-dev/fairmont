<table border="1" cellspacing="0" cellpadding="4" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            @php
                $headers = [
                    // Voyage Info
                    'Vessel', 'Voyage No', 'Date/Time (LT)', 'GMT Offset',
                    'Latitude', 'Longitude', 'Departure Type', 'Departure Port',

                    // Since Last Report
                    'CP/Ordered Speed', 'Obs. Distance', 'Steaming Time', 'Avg Speed', 'Distance to Go',
                    'Avg RPM', 'Engine Distance', 'Slip', 'Avg Power (KW)', 'Course',
                    'Logged Distance', 'Speed Through Water', 'Next Port', 'ETA Next Port', 'ETA GMT Offset',

                    // Departure Conditions
                    'Departure Condition', 'Displacement', 'Cargo Name', 'Cargo Weight', 'Ballast Weight',
                    'Fresh Water', 'Fwd Draft', 'Aft Draft', 'GM',

                    // Voyage Itinerary
                    'Next Port', 'Via', 'ETA (LT)', 'GMT Offset', 'Distance to Go', 'Projected Speed',

                    // ROB Fuel (Flat)
                    'Fuel Type', 'Previous', 'Current', 'M/E Propulsion', 'A/E Cons', 'Boiler Cons',
                    'Incinerators', 'M/E 24', 'A/E 24', 'Total Cons',

                    // Condensed Oil Grades
                    'ME CYL Grade', 'ME CYL Qty', 'ME CYL Hrs', 'ME CYL Cons',
                    'ME CC Qty', 'ME CC Hrs', 'ME CC Cons',
                    'AE CC Qty', 'AE CC Hrs', 'AE CC Cons',

                    // Misc
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

                {{-- Skip row if this fuel object is completely empty --}}
                @if ($fuel && collect($fuel->toArray())->filter()->isEmpty())
                    @continue
                @endif

                <tr>
                    {{-- Voyage Info --}}
                    <td>{{ $report->vessel->name ?? '' }}</td>
                    <td>{{ $report->voyage_no ?? '' }}</td>
                    <td>{{ $report->all_fast_datetime ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') : '' }}</td>
                    <td>{{ $report->gmt_offset ?? '' }}</td>
                    <td>{{ $report->port ?? '' }}</td>
                    <td>{{ $report->bunkering_port ?? '' }}</td>
                    <td>{{ $report->port_gmt_offset ?? '' }}</td>
                    <td>{{ $report->supplier ?? '' }}</td>

                    {{-- Since Last Report --}}
                    <td>{{ $noon->cp_ordered_speed ?? '' }}</td>
                    <td>{{ $noon->obs_distance ?? '' }}</td>
                    <td>{{ $noon->steaming_time ?? '' }}</td>
                    <td>{{ $noon->avg_speed ?? '' }}</td>
                    <td>{{ $noon->distance_to_go ?? '' }}</td>
                    <td>{{ $noon->avg_rpm ?? '' }}</td>
                    <td>{{ $noon->engine_distance ?? '' }}</td>
                    <td>{{ $noon->maneuvering_hours ?? '' }}</td>
                    <td>{{ $noon->avg_power ?? '' }}</td>
                    <td>{{ $noon->course ?? '' }}</td>
                    <td>{{ $noon->logged_distance ?? '' }}</td>
                    <td>{{ $noon->speed_through_water ?? '' }}</td>
                    <td>{{ $noon->next_port ?? '' }}</td>
                    <td>{{ $noon->eta_next_port ? \Carbon\Carbon::parse($noon->eta_next_port)->format('M d, Y h:i A') : '' }}</td>
                    <td>{{ $noon->eta_gmt_offset ?? '' }}</td>

                    {{-- Departure Conditions --}}
                    <td>{{ $noon->condition ?? '' }}</td>
                    <td>{{ $noon->displacement ?? '' }}</td>
                    <td>{{ $noon->cargo_name ?? '' }}</td>
                    <td>{{ $noon->cargo_weight ?? '' }}</td>
                    <td>{{ $noon->ballast_weight ?? '' }}</td>
                    <td>{{ $noon->fresh_water ?? '' }}</td>
                    <td>{{ $noon->fwd_draft ?? '' }}</td>
                    <td>{{ $noon->aft_draft ?? '' }}</td>
                    <td>{{ $noon->gm ?? '' }}</td>

                    {{-- Voyage Itinerary --}}
                    <td>{{ $noon->next_port_voyage ?? '' }}</td>
                    <td>{{ $noon->via ?? '' }}</td>
                    <td>{{ $noon->eta_lt ? \Carbon\Carbon::parse($noon->eta_lt)->format('M d, Y h:i A') : '' }}</td>
                    <td>{{ $noon->gmt_offset_voyage ?? '' }}</td>
                    <td>{{ $noon->distance_to_go_voyage ?? '' }}</td>
                    <td>{{ $noon->projected_speed ?? '' }}</td>

                    {{-- ROB Fuel --}}
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

                    {{-- Oil Grades --}}
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

                    {{-- Misc --}}
                    <td>{{ $report->remarks->remarks ?? '' }}</td>
                    <td>{{ $report->master_info->master_info ?? '' }}</td>
                </tr>
            @endfor
        @endforeach
    </tbody>
</table>
