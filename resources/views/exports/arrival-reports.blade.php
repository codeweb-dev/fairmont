<table border="1" cellspacing="0" cellpadding="4" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            <th colspan="13"><strong>Arrival Report Details</strong></th>
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
                <td colspan="2"><strong>Voyage Details</strong></td>
            </tr>
            <tr>
                <td style="width: 250px;">Vessel Name:</td>
                <td style="width: 250px;">{{ $report->vessel->name ?? '' }}</td>
            </tr>
            <tr>
                <td>Voyage No:</td>
                <td style="text-align: left;">{{ $report->voyage_no ?? '' }}</td>
            </tr>
            <tr>
                <td>Date/Time (LT):</td>
                <td style="text-align: left;">{{ \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') }}</td>
            </tr>
            <tr>
                <td>GMT Offset:</td>
                <td style="text-align: left;">{{ $report->gmt_offset ?? '' }}</td>
            </tr>
            <tr>
                <td>Latitude:</td>
                <td style="text-align: left;">{{ $report->port ?? '' }}</td>
            </tr>
            <tr>
                <td>Longitude:</td>
                <td style="text-align: left;">{{ $report->bunkering_port ?? '' }}</td>
            </tr>
            <tr>
                <td>Arrival Type:</td>
                <td style="text-align: left;">{{ $report->port_gmt_offset ?? '' }}</td>
            </tr>
            <tr>
                <td>Arrival Port:</td>
                <td style="text-align: left;">{{ $report->supplier ?? '' }}</td>
            </tr>
            <tr>
                <td>Anchored Hours:</td>
                <td style="text-align: left;">{{ $report->call_sign ?? '' }}</td>
            </tr>
            <tr>
                <td>Drifting Hours:</td>
                <td style="text-align: left;">{{ $report->flag ?? '' }}</td>
            </tr>

            <tr colspan="2">
                <td></td>
            </tr>

            {{-- DETAILS SINCE LAST REPORT --}}
            @if ($report->noon_report)
                <tr>
                    <td colspan="2"><strong>Details Since Last Report</strong></td>
                </tr>
                <tr>
                    <td>CP/Ordered Speed (Kts):</td>
                    <td style="text-align: left;">{{ $report->noon_report->cp_ordered_speed ?? '' }}</td>
                </tr>
                <tr>
                    <td>Allowed M/E Cons. at C/P Speed:</td>
                    <td style="text-align: left;">{{ $report->noon_report->me_cons_cp_speed ?? '' }}</td>
                </tr>
                <tr>
                    <td>Obs. Distance (NM):</td>
                    <td style="text-align: left;">{{ $report->noon_report->obs_distance ?? '' }}</td>
                </tr>
                <tr>
                    <td>Steaming Time (Hrs):</td>
                    <td style="text-align: left;">{{ $report->noon_report->steaming_time ?? '' }}</td>
                </tr>
                <tr>
                    <td>Avg Speed (Kts):</td>
                    <td style="text-align: left;">{{ $report->noon_report->avg_speed ?? '' }}</td>
                </tr>
                <tr>
                    <td>Distance sailed from last port (NM):</td>
                    <td style="text-align: left;">{{ $report->noon_report->distance_to_go ?? '' }}</td>
                </tr>
                <tr>
                    <td>Breakdown (Hrs):</td>
                    <td style="text-align: left;">{{ $report->noon_report->breakdown ?? '' }}</td>
                </tr>
                <tr>
                    <td>M/E Revs Counter (Noon to Noon):</td>
                    <td style="text-align: left;">{{ $report->noon_report->maneuvering_hours ?? '' }}</td>
                </tr>
                <tr>
                    <td>Avg RPM:</td>
                    <td style="text-align: left;">{{ $report->noon_report->avg_rpm ?? '' }}</td>
                </tr>
                <tr>
                    <td>Engine Distance (NM):</td>
                    <td style="text-align: left;">{{ $report->noon_report->engine_distance ?? '' }}</td>
                </tr>
                <tr>
                    <td>Slip (%):</td>
                    <td style="text-align: left;">{{ $report->noon_report->next_port ?? '' }}</td>
                </tr>
                <tr>
                    <td>Avg Power (KW):</td>
                    <td style="text-align: left;">{{ $report->noon_report->avg_power ?? '' }}</td>
                </tr>
                <tr>
                    <td>Logged Distance (NM):</td>
                    <td style="text-align: left;">{{ $report->noon_report->logged_distance ?? '' }}</td>
                </tr>
                <tr>
                    <td>Speed Through Water (Kts):</td>
                    <td style="text-align: left;">{{ $report->noon_report->speed_through_water ?? '' }}</td>
                </tr>
                <tr>
                    <td>Course (Deg):</td>
                    <td style="text-align: left;">{{ $report->noon_report->course ?? '' }}</td>
                </tr>

                <tr colspan="2">
                    <td></td>
                </tr>

                {{-- ARRIVAL CONDITIONS --}}
                <tr>
                    <td colspan="2"><strong>Arrival Conditions</strong></td>
                </tr>
                <tr>
                    <td>Condition:</td>
                    <td style="text-align: left;">{{ $report->noon_report->condition ?? '' }}</td>
                </tr>
                <tr>
                    <td>Displacement (MT):</td>
                    <td style="text-align: left;">{{ $report->noon_report->displacement ?? '' }}</td>
                </tr>
                <tr>
                    <td>Cargo Name:</td>
                    <td style="text-align: left;">{{ $report->noon_report->cargo_name ?? '' }}</td>
                </tr>
                <tr>
                    <td>Cargo Weight (MT):</td>
                    <td style="text-align: left;">{{ $report->noon_report->cargo_weight ?? '' }}</td>
                </tr>
                <tr>
                    <td>Ballast Weight (MT):</td>
                    <td style="text-align: left;">{{ $report->noon_report->ballast_weight ?? '' }}</td>
                </tr>
                <tr>
                    <td>Fresh Water (MT):</td>
                    <td style="text-align: left;">{{ $report->noon_report->fresh_water ?? '' }}</td>
                </tr>
                <tr>
                    <td>Fwd Draft (m):</td>
                    <td style="text-align: left;">{{ $report->noon_report->fwd_draft ?? '' }}</td>
                </tr>
                <tr>
                    <td>Aft Draft (m):</td>
                    <td style="text-align: left;">{{ $report->noon_report->aft_draft ?? '' }}</td>
                </tr>
                <tr>
                    <td>GM:</td>
                    <td style="text-align: left;">{{ $report->noon_report->gm ?? '' }}</td>
                </tr>
            @endif

            <tr colspan="2">
                <td></td>
            </tr>

            {{-- ROB CONSUMPTION TABLE --}}
            @if ($report->rob_fuel_reports && $report->rob_fuel_reports->count())
                {{-- Table Headers --}}
                <tr>
                    <td rowspan="2" style="border: 1px solid #000; padding: 5px; text-align: center;"><strong>Bunker
                            Type</strong></td>
                    <td colspan="2" style="border: 1px solid #000; padding: 5px; text-align: center;"><strong>ROB (in
                            MT)</strong></td>
                    <td colspan="4" style="border: 1px solid #000; padding: 5px; text-align: center;">
                        <strong>Consumption</strong>
                    </td>
                    <td colspan="2" style="border: 1px solid #000; padding: 5px; text-align: center;">
                        <strong>Cons./24hr</strong>
                    </td>
                    <td rowspan="2" style="border: 1px solid #000; padding: 5px; text-align: center;"><strong>Total
                            Cons.</strong></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000; padding: 5px;"><strong>Previous</strong></td>
                    <td style="border: 1px solid #000; padding: 5px;"><strong>Current</strong></td>
                    <td style="border: 1px solid #000; padding: 5px;"><strong>M/E Propulsion</strong></td>
                    <td style="border: 1px solid #000; padding: 5px;"><strong>A/E Cons.</strong></td>
                    <td style="border: 1px solid #000; padding: 5px;"><strong>Boiler Cons.</strong></td>
                    <td style="border: 1px solid #000; padding: 5px;"><strong>Incinerators</strong></td>
                    <td style="border: 1px solid #000; padding: 5px;"><strong>M/E 24hr</strong></td>
                    <td style="border: 1px solid #000; padding: 5px;"><strong>A/E 24hr</strong></td>
                </tr>

                @foreach ($report->rob_fuel_reports as $fuel)
                    <tr>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->fuel_type }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->previous }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->current }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->me_propulsion }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->ae_cons }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->boiler_cons }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->incinerators }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->me_24 }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->ae_24 }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->total_cons }}</td>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="13">
                    </td>
                </tr>

                {{-- Lube Oil Subtable --}}
                <tr>
                    <td colspan="4" style="border: 1px solid #000; padding: 5px; text-align: center;"><strong>ME
                            CYL</strong></td>
                    <td colspan="3" style="border: 1px solid #000; padding: 5px; text-align: center;"><strong>ME
                            CC</strong></td>
                    <td colspan="3" style="border: 1px solid #000; padding: 5px; text-align: center;"><strong>AE
                            CC</strong></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Oil Grade</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Oil Qty</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Total Run Hrs.</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Oil Cons.</strong></td>

                    <td style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Total Run Hrs.</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Oil Cons.</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Oil Qty</strong></td>

                    <td style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Total Run Hrs.</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Oil Cons.</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Oil Qty</strong></td>
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

            <tr colspan="2">
                <td></td>
            </tr>

            {{-- REMARKS --}}
            @if ($report->remarks)
                <tr>
                    <td><strong>Remarks</strong></td>
                    <td style="text-align: left;">{{ $report->remarks->remarks ?? '' }}</td>
                </tr>
            @endif

            <tr colspan="2">
                <td></td>
            </tr>

            {{-- MASTER INFO --}}
            @if ($report->master_info)
                <tr>
                    <td><strong>Master's Name</strong></td>
                    <td style="text-align: left;">{{ $report->master_info->master_info ?? '' }}</td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
