<table border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            <th colspan="13">Departure Report Details</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $report)
            {{-- VOYAGE DETAILS --}}
            <tr>
                <td colspan="13"><strong>Voyage Details</strong></td>
            </tr>
            <tr>
                <td style="width: 200px;">Vessel Name:</td>
                <td colspan="12">{{ $report->vessel->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Voyage No:</td>
                <td colspan="12">{{ $report->voyage_no ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Date/Time (LT):</td>
                <td colspan="12">{{ \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') }}</td>
            </tr>
            <tr>
                <td>GMT Offset:</td>
                <td colspan="12">{{ $report->gmt_offset ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Latitude:</td>
                <td colspan="12">{{ $report->port ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Longitude:</td>
                <td colspan="12">{{ $report->bunkering_port ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Departure Type:</td>
                <td colspan="12">{{ $report->port_gmt_offset ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Departure Port:</td>
                <td colspan="12">{{ $report->supplier ?? 'N/A' }}</td>
            </tr>

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- DETAILS SINCE LAST REPORT --}}
            <tr>
                <td colspan="13"><strong>Details Since Last Report</strong></td>
            </tr>
            <tr>
                <td>CP/Ordered Speed (Kts):</td>
                <td colspan="12">{{ $report->noon_report->cp_ordered_speed ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Obs. Distance (NM):</td>
                <td colspan="12">{{ $report->noon_report->obs_distance ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Steaming Time (Hrs):</td>
                <td colspan="12">{{ $report->noon_report->steaming_time ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Avg Speed (Kts):</td>
                <td colspan="12">{{ $report->noon_report->avg_speed ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Distance to go (NM):</td>
                <td colspan="12">{{ $report->noon_report->distance_to_go ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Avg RPM:</td>
                <td colspan="12">{{ $report->noon_report->avg_rpm ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Engine Distance (NM):</td>
                <td colspan="12">{{ $report->noon_report->engine_distance ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Slip (%):</td>
                <td colspan="12">{{ $report->noon_report->maneuvering_hours ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Avg Power (KW):</td>
                <td colspan="12">{{ $report->noon_report->avg_power ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Course (Deg):</td>
                <td colspan="12">{{ $report->noon_report->course ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Logged Distance (NM):</td>
                <td colspan="12">{{ $report->noon_report->logged_distance ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Speed Through Water (Kts):</td>
                <td colspan="12">{{ $report->noon_report->speed_through_water ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Next Port:</td>
                <td colspan="12">{{ $report->noon_report->next_port ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>ETA Next Port (LT):</td>
                <td colspan="12">{{ \Carbon\Carbon::parse($report->noon_report->eta_next_port)->format('M d, Y h:i A') }}</td>
            </tr>
            <tr>
                <td>ETA GMT Offset:</td>
                <td colspan="12">{{ $report->noon_report->eta_gmt_offset ?? 'N/A' }}</td>
            </tr>

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- DEPARTURE CONDITIONS --}}
            <tr>
                <td colspan="13"><strong>Departure Conditions</strong></td>
            </tr>
            <tr>
                <td>Departure Condition:</td>
                <td colspan="12">{{ $report->noon_report->condition ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Displacement (MT):</td>
                <td colspan="12">{{ $report->noon_report->displacement ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Cargo Name:</td>
                <td colspan="12">{{ $report->noon_report->cargo_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Cargo Weight (MT):</td>
                <td colspan="12">{{ $report->noon_report->cargo_weight ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Ballast Weight (MT):</td>
                <td colspan="12">{{ $report->noon_report->ballast_weight ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Fresh Water (MT):</td>
                <td colspan="12">{{ $report->noon_report->fresh_water ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Fwd Draft (m):</td>
                <td colspan="12">{{ $report->noon_report->fwd_draft ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Aft Draft (m):</td>
                <td colspan="12">{{ $report->noon_report->aft_draft ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>GM:</td>
                <td colspan="12">{{ $report->noon_report->gm ?? 'N/A' }}</td>
            </tr>

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- VOYAGE ITINERARY --}}
            <tr>
                <td colspan="13"><strong>Voyage Itinerary</strong></td>
            </tr>
            <tr>
                <td>Port:</td>
                <td colspan="12">{{ $report->noon_report->next_port_voyage ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Via:</td>
                <td colspan="12">{{ $report->noon_report->via ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>ETA (LT):</td>
                <td colspan="12">{{ \Carbon\Carbon::parse($report->noon_report->eta_lt)->format('M d, Y h:i A') }}</td>
            </tr>
            <tr>
                <td>GMT Offset:</td>
                <td colspan="12">{{ $report->noon_report->gmt_offset_voyage ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Distance to go:</td>
                <td colspan="12">{{ $report->noon_report->distance_to_go_voyage ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Projected Speed (kts):</td>
                <td colspan="12">{{ $report->noon_report->projected_speed ?? 'N/A' }}</td>
            </tr>

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- ROB DETAILS --}}
            @if ($report->rob_fuel_reports && $report->rob_fuel_reports->count())
                <tr>
                    <td colspan="13"><strong>ROB Details</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="width: 200px; border: 1px solid #000;"><strong>Bunker Type</strong></td>
                    <td colspan="2" style="width: 200px; border: 1px solid #000;"><strong>ROB (in MT)</strong></td>
                    <td colspan="4" style="width: 200px; border: 1px solid #000;"><strong>Consumption</strong></td>
                    <td colspan="2" style="width: 200px; border: 1px solid #000;"><strong>Cons./24 hr</strong></td>
                    <td rowspan="2" style="width: 200px; border: 1px solid #000;"><strong>Total Cons.</strong></td>
                </tr>
                <tr>
                    <td style="width: 200px; border: 1px solid #000;">Previous</td>
                    <td style="width: 200px; border: 1px solid #000;">Current</td>
                    <td style="width: 200px; border: 1px solid #000;">M/E Propulsion</td>
                    <td style="width: 200px; border: 1px solid #000;">A/E cons.</td>
                    <td style="width: 200px; border: 1px solid #000;">Boiler cons.</td>
                    <td style="width: 200px; border: 1px solid #000;">Incinerators</td>
                    <td style="width: 200px; border: 1px solid #000;">M/E 24</td>
                    <td style="width: 200px; border: 1px solid #000;">A/E 24</td>
                </tr>
                @foreach ($report->rob_fuel_reports as $fuel)
                    <tr>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->fuel_type ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->previous ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->current ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_propulsion ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->ae_cons ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->boiler_cons ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->incinerators ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_24 ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->ae_24 ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->total_cons ?? 'N/A' }}</td>
                    </tr>

                    <tr colspan="13">
                        <td></td>
                    </tr>

                    {{-- Lubricating Oils Table Format --}}
                    <tr>
                        <td rowspan="2" style="width: 200px; border: 1px solid #000;"><strong>Oil Grade</strong></td>
                        <td colspan="3" style="width: 200px; border: 1px solid #000;"><strong>ME CYL</strong></td>
                        <td colspan="3" style="width: 200px; border: 1px solid #000;"><strong>ME CC</strong></td>
                        <td colspan="3" style="width: 200px; border: 1px solid #000;"><strong>AE CC</strong></td>
                    </tr>
                    <tr>
                        <td style="width: 200px; border: 1px solid #000;">Oil Qty</td>
                        <td style="width: 200px; border: 1px solid #000;">Run Hrs</td>
                        <td style="width: 200px; border: 1px solid #000;">Cons</td>
                        <td style="width: 200px; border: 1px solid #000;">Oil Qty</td>
                        <td style="width: 200px; border: 1px solid #000;">Run Hrs</td>
                        <td style="width: 200px; border: 1px solid #000;">Cons</td>
                        <td style="width: 200px; border: 1px solid #000;">Oil Qty</td>
                        <td style="width: 200px; border: 1px solid #000;">Run Hrs</td>
                        <td style="width: 200px; border: 1px solid #000;">Cons</td>
                    </tr>
                    <tr>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cyl_grade ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cyl_qty ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cyl_hrs ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cyl_cons ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cc_qty ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cc_hrs ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cc_cons ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->ae_cc_qty ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->ae_cc_hrs ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->ae_cc_cons ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            @endif

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- REMARKS --}}
            @if ($report->remarks)
                <tr>
                    <td><strong>Remarks</strong></td>
                    <td colspan="12">{{ $report->remarks->remarks ?? 'N/A' }}</td>
                </tr>
            @endif

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- MASTER'S INFO --}}
            @if ($report->master_info)
                <tr>
                    <td><strong>Master's Name</strong></td>
                    <td colspan="12">{{ $report->master_info->master_info ?? 'N/A' }}</td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
