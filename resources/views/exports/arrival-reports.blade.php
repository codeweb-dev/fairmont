<table border="1" cellspacing="0" cellpadding="4" style="border-collapse: collapse; width: 100%;">
    @foreach ($reports as $report)
        {{-- VOYAGE DETAILS --}}
        <tr>
            <td colspan="2"><strong>Voyage Details</strong></td>
        </tr>
        <tr>
            <td>Vessel Name:</td>
            <td>{{ $report->vessel->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Voyage No:</td>
            <td>{{ $report->voyage_no ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Date/Time (LT):</td>
            <td>{{ \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') }}</td>
        </tr>
        <tr>
            <td>GMT Offset:</td>
            <td>{{ $report->gmt_offset ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Latitude:</td>
            <td>{{ $report->port ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Longitude:</td>
            <td>{{ $report->bunkering_port ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Arrival Type:</td>
            <td>{{ $report->port_gmt_offset ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Arrival Port:</td>
            <td>{{ $report->supplier ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Anchored Hours:</td>
            <td>{{ $report->call_sign ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td>Drifting Hours:</td>
            <td>{{ $report->flag ?? 'N/A' }}</td>
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
                <td>{{ $report->noon_report->cp_ordered_speed ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Allowed M/E Cons. at C/P Speed:</td>
                <td>{{ $report->noon_report->me_cons_cp_speed ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Obs. Distance (NM):</td>
                <td>{{ $report->noon_report->obs_distance ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Steaming Time (Hrs):</td>
                <td>{{ $report->noon_report->steaming_time ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Avg Speed (Kts):</td>
                <td>{{ $report->noon_report->avg_speed ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Distance sailed from last port (NM):</td>
                <td>{{ $report->noon_report->distance_to_go ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Breakdown (Hrs):</td>
                <td>{{ $report->noon_report->breakdown ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>M/E Revs Counter (Noon to Noon):</td>
                <td>{{ $report->noon_report->maneuvering_hours ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Avg RPM:</td>
                <td>{{ $report->noon_report->avg_rpm ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Engine Distance (NM):</td>
                <td>{{ $report->noon_report->engine_distance ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Slip (%):</td>
                <td>{{ $report->noon_report->next_port ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Avg Power (KW):</td>
                <td>{{ $report->noon_report->avg_power ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Logged Distance (NM):</td>
                <td>{{ $report->noon_report->logged_distance ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Speed Through Water (Kts):</td>
                <td>{{ $report->noon_report->speed_through_water ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Course (Deg):</td>
                <td>{{ $report->noon_report->course ?? 'N/A' }}</td>
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
                <td>{{ $report->noon_report->condition ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Displacement (MT):</td>
                <td>{{ $report->noon_report->displacement ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Cargo Name:</td>
                <td>{{ $report->noon_report->cargo_name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Cargo Weight (MT):</td>
                <td>{{ $report->noon_report->cargo_weight ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Ballast Weight (MT):</td>
                <td>{{ $report->noon_report->ballast_weight ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Fresh Water (MT):</td>
                <td>{{ $report->noon_report->fresh_water ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Fwd Draft (m):</td>
                <td>{{ $report->noon_report->fwd_draft ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Aft Draft (m):</td>
                <td>{{ $report->noon_report->aft_draft ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>GM:</td>
                <td>{{ $report->noon_report->gm ?? 'N/A' }}</td>
            </tr>
        @endif

        <tr colspan="2">
            <td></td>
        </tr>

        {{-- ROB DETAILS --}}
        @if ($report->rob_fuel_reports && $report->rob_fuel_reports->count())
            <tr>
                <td colspan="13"><strong>ROB Details</strong></td>
            </tr>

            <tr>
                <td rowspan="2" style="width: 200px; border: 1px solid #000;"><strong>Bunker Type</strong></td>
                <td colspan="2" style="width: 200px; text-align: center; border: 1px solid #000;"><strong>ROB (in
                        MT)</strong></td>
                <td colspan="4" style="width: 200px; text-align: center; border: 1px solid #000;">
                    <strong>Consumption</strong>
                </td>
                <td colspan="2" style="width: 200px; text-align: center; border: 1px solid #000;"><strong>Cons./24
                        hr</strong></td>
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

                <tr colspan="2">
                    <td></td>
                </tr>

                {{-- ME CYL Section --}}
                {{-- Header Group Row --}}
                <tr>
                    <td rowspan="2" style="width: 200px; border: 1px solid #000;"><strong>Oil Grade</strong></td>
                    <td colspan="3" style="width: 200px; text-align: center; border: 1px solid #000;"><strong>ME
                            CYL</strong></td>
                    <td colspan="3" style="width: 200px; text-align: center; border: 1px solid #000;"><strong>ME
                            CC</strong></td>
                    <td colspan="3" style="width: 200px; text-align: center; border: 1px solid #000;"><strong>AE
                            CC</strong></td>
                </tr>

                {{-- Subheaders --}}
                <tr>
                    <td style="width: 200px; border: 1px solid #000;">Oil Quantity</td>
                    <td style="width: 200px; border: 1px solid #000;">Total Run Hrs.</td>
                    <td style="width: 200px; border: 1px solid #000;">Oil Cons.</td>

                    <td style="width: 200px; border: 1px solid #000;">Oil Quantity</td>
                    <td style="width: 200px; border: 1px solid #000;">Total Run Hrs.</td>
                    <td style="width: 200px; border: 1px solid #000;">Oil Cons.</td>

                    <td style="width: 200px; border: 1px solid #000;">Oil Quantity</td>
                    <td style="width: 200px; border: 1px solid #000;">Total Run Hrs.</td>
                    <td style="width: 200px; border: 1px solid #000;">Oil Cons.</td>
                </tr>

                {{-- Data Row --}}
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

        <tr colspan="2">
            <td></td>
        </tr>

        {{-- REMARKS --}}
        @if ($report->remarks)
            <tr>
                <td><strong>Remarks</strong></td>
                <td>{{ $report->remarks->remarks ?? 'N/A' }}</td>
            </tr>
        @endif

        <tr colspan="2">
            <td></td>
        </tr>

        {{-- MASTER INFO --}}
        @if ($report->master_info)
            <tr>
                <td><strong>Master's Name</strong></td>
                <td>{{ $report->master_info->master_info ?? 'N/A' }}</td>
            </tr>
        @endif
    @endforeach
</table>
