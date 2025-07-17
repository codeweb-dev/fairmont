<table border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse; width: 100%; text-align: left;">
    <thead>
        <tr>
            <th colspan="13"><strong>Departure Report Details</strong></th>
        </tr>

        <tr>
            <td colspan="13">
            </td>
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $report)
            {{-- VOYAGE DETAILS --}}
            <tr>
                <td colspan="13"><strong>Voyage Details</strong></td>
            </tr>
            <tr>
                <td style="width: 250px;">Vessel Name:</td>
                <td colspan="1">{{ $report->vessel->name ?? '' }}</td>
            </tr>
            <tr>
                <td>Voyage No:</td>
                <td colspan="1">{{ $report->voyage_no ?? '' }}</td>
            </tr>
            <tr>
                <td>Date/Time (LT):</td>
                <td colspan="1">{{ \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') }}</td>
            </tr>
            <tr>
                <td>GMT Offset:</td>
                <td colspan="1">{{ $report->gmt_offset ?? '' }}</td>
            </tr>
            <tr>
                <td>Latitude:</td>
                <td colspan="1">{{ $report->port ?? '' }}</td>
            </tr>
            <tr>
                <td>Longitude:</td>
                <td colspan="1">{{ $report->bunkering_port ?? '' }}</td>
            </tr>
            <tr>
                <td>Departure Type:</td>
                <td colspan="1">{{ $report->port_gmt_offset ?? '' }}</td>
            </tr>
            <tr>
                <td>Departure Port:</td>
                <td colspan="1">{{ $report->supplier ?? '' }}</td>
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
                <td colspan="1">{{ $report->noon_report->cp_ordered_speed ?? '' }}</td>
            </tr>
            <tr>
                <td>Obs. Distance (NM):</td>
                <td colspan="1">{{ $report->noon_report->obs_distance ?? '' }}</td>
            </tr>
            <tr>
                <td>Steaming Time (Hrs):</td>
                <td colspan="1">{{ $report->noon_report->steaming_time ?? '' }}</td>
            </tr>
            <tr>
                <td>Avg Speed (Kts):</td>
                <td colspan="1">{{ $report->noon_report->avg_speed ?? '' }}</td>
            </tr>
            <tr>
                <td>Distance to go (NM):</td>
                <td colspan="1">{{ $report->noon_report->distance_to_go ?? '' }}</td>
            </tr>
            <tr>
                <td>Avg RPM:</td>
                <td colspan="1">{{ $report->noon_report->avg_rpm ?? '' }}</td>
            </tr>
            <tr>
                <td>Engine Distance (NM):</td>
                <td colspan="1">{{ $report->noon_report->engine_distance ?? '' }}</td>
            </tr>
            <tr>
                <td>Slip (%):</td>
                <td colspan="1">{{ $report->noon_report->maneuvering_hours ?? '' }}</td>
            </tr>
            <tr>
                <td>Avg Power (KW):</td>
                <td colspan="1">{{ $report->noon_report->avg_power ?? '' }}</td>
            </tr>
            <tr>
                <td>Course (Deg):</td>
                <td colspan="1">{{ $report->noon_report->course ?? '' }}</td>
            </tr>
            <tr>
                <td>Logged Distance (NM):</td>
                <td colspan="1">{{ $report->noon_report->logged_distance ?? '' }}</td>
            </tr>
            <tr>
                <td>Speed Through Water (Kts):</td>
                <td colspan="1">{{ $report->noon_report->speed_through_water ?? '' }}</td>
            </tr>
            <tr>
                <td>Next Port:</td>
                <td colspan="1">{{ $report->noon_report->next_port ?? '' }}</td>
            </tr>
            <tr>
                <td>ETA Next Port (LT):</td>
                <td colspan="1">
                    {{ $report->noon_report->eta_next_port ? \Carbon\Carbon::parse($report->noon_report->eta_next_port)->format('M d, Y h:i A') : '' }}</td>
            </tr>
            <tr>
                <td>ETA GMT Offset:</td>
                <td colspan="1">{{ $report->noon_report->eta_gmt_offset ?? '' }}</td>
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
                <td colspan="1">{{ $report->noon_report->condition ?? '' }}</td>
            </tr>
            <tr>
                <td>Displacement (MT):</td>
                <td colspan="1">{{ $report->noon_report->displacement ?? '' }}</td>
            </tr>
            <tr>
                <td>Cargo Name:</td>
                <td colspan="1">{{ $report->noon_report->cargo_name ?? '' }}</td>
            </tr>
            <tr>
                <td>Cargo Weight (MT):</td>
                <td colspan="1">{{ $report->noon_report->cargo_weight ?? '' }}</td>
            </tr>
            <tr>
                <td>Ballast Weight (MT):</td>
                <td colspan="1">{{ $report->noon_report->ballast_weight ?? '' }}</td>
            </tr>
            <tr>
                <td>Fresh Water (MT):</td>
                <td colspan="1">{{ $report->noon_report->fresh_water ?? '' }}</td>
            </tr>
            <tr>
                <td>Fwd Draft (m):</td>
                <td colspan="1">{{ $report->noon_report->fwd_draft ?? '' }}</td>
            </tr>
            <tr>
                <td>Aft Draft (m):</td>
                <td colspan="1">{{ $report->noon_report->aft_draft ?? '' }}</td>
            </tr>
            <tr>
                <td>GM:</td>
                <td colspan="1">{{ $report->noon_report->gm ?? '' }}</td>
            </tr>

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- VOYAGE ITINERARY --}}
            <tr>
                <td colspan="1"><strong>Voyage Itinerary</strong></td>
            </tr>
            <tr>
                <td>Next Port:</td>
                <td colspan="1">{{ $report->noon_report->next_port_voyage ?? '' }}</td>
            </tr>
            <tr>
                <td>Via:</td>
                <td colspan="1">{{ $report->noon_report->via ?? '' }}</td>
            </tr>
            <tr>
                <td>ETA (LT):</td>
                <td colspan="1">{{ $report->noon_report->eta_lt ? \Carbon\Carbon::parse($report->noon_report->eta_lt)->format('M d, Y h:i A') : '' }}
                </td>
            </tr>
            <tr>
                <td>GMT Offset:</td>
                <td colspan="1">{{ $report->noon_report->gmt_offset_voyage ?? '' }}</td>
            </tr>
            <tr>
                <td>Distance to go:</td>
                <td colspan="1">{{ $report->noon_report->distance_to_go_voyage ?? '' }}</td>
            </tr>
            <tr>
                <td>Projected Speed (kts):</td>
                <td colspan="1">{{ $report->noon_report->projected_speed ?? '' }}</td>
            </tr>

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- ROB CONSUMPTION TABLE --}}
            @if ($report->rob_fuel_reports && $report->rob_fuel_reports->count())
                <tr>
                    <td colspan="13" style="font-weight: bold; padding-top: 10px;">ROB Summary</td>
                </tr>
                {{-- Table Headers --}}
                <tr>
                    <td rowspan="2" style="border: 1px solid #000; padding: 5px; text-align: center; width: 250px;"><strong>Bunker
                            Type</strong></td>
                    <td colspan="2" style="border: 1px solid #000; padding: 5px; text-align: center; width: 250px;"><strong>ROB (in
                            MT)</strong></td>
                    <td colspan="4" style="border: 1px solid #000; padding: 5px; text-align: center; width: 250px;">
                        <strong>Consumption</strong>
                    </td>
                    <td colspan="2" style="border: 1px solid #000; padding: 5px; text-align: center; width: 250px;">
                        <strong>Cons./24hr</strong>
                    </td>
                    <td rowspan="2" style="border: 1px solid #000; padding: 5px; text-align: center; width: 250px;"><strong>Total
                            Cons.</strong></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000; padding: 5px; width: 250px;"><strong>Previous</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; width: 250px;"><strong>Current</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; width: 250px;"><strong>M/E Propulsion</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; width: 250px;"><strong>A/E Cons.</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; width: 250px;"><strong>Boiler Cons.</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; width: 250px;"><strong>Incinerators</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; width: 250px;"><strong>M/E 24hr</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; width: 250px;"><strong>A/E 24hr</strong></td>
                </tr>

                @foreach ($report->rob_fuel_reports as $fuel)
                    <tr>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;">{{ $fuel->fuel_type }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;">{{ $fuel->previous }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;">{{ $fuel->current }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;">{{ $fuel->me_propulsion }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;">{{ $fuel->ae_cons }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;">{{ $fuel->boiler_cons }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;">{{ $fuel->incinerators }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;">{{ $fuel->me_24 }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;">{{ $fuel->ae_24 }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;">{{ $fuel->total_cons }}</td>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="13">
                    </td>
                </tr>

                {{-- Lube Oil Subtable --}}
                <tr>
                    <td colspan="4" style="border: 1px solid #000; padding: 5px; text-align: center; width: 250px;"><strong>ME
                            CYL</strong></td>
                    <td colspan="3" style="border: 1px solid #000; padding: 5px; text-align: center; width: 250px;"><strong>ME
                            CC</strong></td>
                    <td colspan="3" style="border: 1px solid #000; padding: 5px; text-align: center; width: 250px;"><strong>AE
                            CC</strong></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;"><strong>Oil Grade</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;"><strong>Oil Qty</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;"><strong>Total Run Hrs.</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;"><strong>Oil Cons.</strong></td>

                    <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;"><strong>Total Run Hrs.</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;"><strong>Oil Cons.</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;"><strong>Oil Qty</strong></td>

                    <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;"><strong>Total Run Hrs.</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;"><strong>Oil Cons.</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;"><strong>Oil Qty</strong></td>
                </tr>
                @foreach ($report->rob_fuel_reports as $fuel)
                    <tr>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;">{{ $fuel->me_cyl_grade }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;">{{ $fuel->me_cyl_qty }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;">{{ $fuel->me_cyl_hrs }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;">{{ $fuel->me_cyl_cons }}</td>

                        <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;">{{ $fuel->me_cc_cons }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;">{{ $fuel->me_cc_qty }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;">{{ $fuel->me_cc_hrs }}</td>

                        <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;">{{ $fuel->ae_cc_cons }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;">{{ $fuel->ae_cc_qty }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left; width: 250px;">{{ $fuel->ae_cc_hrs }}</td>
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
                    <td colspan="1">{{ $report->remarks->remarks ?? '' }}</td>
                </tr>
            @endif

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- Master Information --}}
            @if ($report->master_info)
                <tr>
                    <td><strong>Master's Name</strong></td>
                    <td colspan="1">{{ $report->master_info->master_info ?? '' }}</td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
