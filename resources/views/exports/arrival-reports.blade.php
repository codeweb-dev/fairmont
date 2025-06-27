<table border="1" cellspacing="0" cellpadding="4" style="border-collapse: collapse; width: 100%;">
    @foreach ($reports as $report)
        {{-- VOYAGE DETAILS --}}
        <tr>
            <td colspan="2"><strong>Voyage Details</strong></td>
        </tr>
        <tr>
            <td>Vessel Name:</td>
            <td>{{ $report->vessel->name ?? '' }}</td>
        </tr>
        <tr>
            <td>Voyage No:</td>
            <td>{{ $report->voyage_no ?? '' }}</td>
        </tr>
        <tr>
            <td>Date/Time (LT):</td>
            <td>{{ \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') }}</td>
        </tr>
        <tr>
            <td>GMT Offset:</td>
            <td>{{ $report->gmt_offset ?? '' }}</td>
        </tr>
        <tr>
            <td>Latitude:</td>
            <td>{{ $report->port ?? '' }}</td>
        </tr>
        <tr>
            <td>Longitude:</td>
            <td>{{ $report->bunkering_port ?? '' }}</td>
        </tr>
        <tr>
            <td>Arrival Type:</td>
            <td>{{ $report->port_gmt_offset ?? '' }}</td>
        </tr>
        <tr>
            <td>Arrival Port:</td>
            <td>{{ $report->supplier ?? '' }}</td>
        </tr>
        <tr>
            <td>Anchored Hours:</td>
            <td>{{ $report->call_sign ?? '' }}</td>
        </tr>
        <tr>
            <td>Drifting Hours:</td>
            <td>{{ $report->flag ?? '' }}</td>
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
                <td>{{ $report->noon_report->cp_ordered_speed }}</td>
            </tr>
            <tr>
                <td>Allowed M/E Cons. at C/P Speed:</td>
                <td>{{ $report->noon_report->me_cons_cp_speed }}</td>
            </tr>
            <tr>
                <td>Obs. Distance (NM):</td>
                <td>{{ $report->noon_report->obs_distance }}</td>
            </tr>
            <tr>
                <td>Steaming Time (Hrs):</td>
                <td>{{ $report->noon_report->steaming_time }}</td>
            </tr>
            <tr>
                <td>Avg Speed (Kts):</td>
                <td>{{ $report->noon_report->avg_speed }}</td>
            </tr>
            <tr>
                <td>Distance sailed from last port (NM):</td>
                <td>{{ $report->noon_report->distance_to_go }}</td>
            </tr>
            <tr>
                <td>Breakdown (Hrs):</td>
                <td>{{ $report->noon_report->breakdown }}</td>
            </tr>
            <tr>
                <td>M/E Revs Counter (Noon to Noon):</td>
                <td>{{ $report->noon_report->maneuvering_hours }}</td>
            </tr>
            <tr>
                <td>Avg RPM:</td>
                <td>{{ $report->noon_report->avg_rpm }}</td>
            </tr>
            <tr>
                <td>Engine Distance (NM):</td>
                <td>{{ $report->noon_report->engine_distance }}</td>
            </tr>
            <tr>
                <td>Slip (%):</td>
                <td>{{ $report->noon_report->next_port }}</td>
            </tr>
            <tr>
                <td>Avg Power (KW):</td>
                <td>{{ $report->noon_report->avg_power }}</td>
            </tr>
            <tr>
                <td>Logged Distance (NM):</td>
                <td>{{ $report->noon_report->logged_distance }}</td>
            </tr>
            <tr>
                <td>Speed Through Water (Kts):</td>
                <td>{{ $report->noon_report->speed_through_water }}</td>
            </tr>
            <tr>
                <td>Course (Deg):</td>
                <td>{{ $report->noon_report->course }}</td>
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
                <td>{{ $report->noon_report->condition }}</td>
            </tr>
            <tr>
                <td>Displacement (MT):</td>
                <td>{{ $report->noon_report->displacement }}</td>
            </tr>
            <tr>
                <td>Cargo Name:</td>
                <td>{{ $report->noon_report->cargo_name }}</td>
            </tr>
            <tr>
                <td>Cargo Weight (MT):</td>
                <td>{{ $report->noon_report->cargo_weight }}</td>
            </tr>
            <tr>
                <td>Ballast Weight (MT):</td>
                <td>{{ $report->noon_report->ballast_weight }}</td>
            </tr>
            <tr>
                <td>Fresh Water (MT):</td>
                <td>{{ $report->noon_report->fresh_water }}</td>
            </tr>
            <tr>
                <td>Fwd Draft (m):</td>
                <td>{{ $report->noon_report->fwd_draft }}</td>
            </tr>
            <tr>
                <td>Aft Draft (m):</td>
                <td>{{ $report->noon_report->aft_draft }}</td>
            </tr>
            <tr>
                <td>GM:</td>
                <td>{{ $report->noon_report->gm }}</td>
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
                    <td style="width: 200px; border: 1px solid #000;">{{ $fuel->fuel_type }}</td>
                    <td style="width: 200px; border: 1px solid #000;">{{ $fuel->previous }}</td>
                    <td style="width: 200px; border: 1px solid #000;">{{ $fuel->current }}</td>
                    <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_propulsion }}</td>
                    <td style="width: 200px; border: 1px solid #000;">{{ $fuel->ae_cons }}</td>
                    <td style="width: 200px; border: 1px solid #000;">{{ $fuel->boiler_cons }}</td>
                    <td style="width: 200px; border: 1px solid #000;">{{ $fuel->incinerators }}</td>
                    <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_24 }}</td>
                    <td style="width: 200px; border: 1px solid #000;">{{ $fuel->ae_24 }}</td>
                    <td style="width: 200px; border: 1px solid #000;">{{ $fuel->total_cons }}</td>
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
                    <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cyl_grade }}</td>

                    <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cyl_qty }}</td>
                    <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cyl_hrs }}</td>
                    <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cyl_cons }}</td>

                    <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cc_qty }}</td>
                    <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cc_hrs }}</td>
                    <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cc_cons }}</td>

                    <td style="width: 200px; border: 1px solid #000;">{{ $fuel->ae_cc_qty }}</td>
                    <td style="width: 200px; border: 1px solid #000;">{{ $fuel->ae_cc_hrs }}</td>
                    <td style="width: 200px; border: 1px solid #000;">{{ $fuel->ae_cc_cons }}</td>
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
                <td>{{ $report->remarks->remarks }}</td>
            </tr>
        @endif

        <tr colspan="2">
            <td></td>
        </tr>

        {{-- MASTER INFO --}}
        @if ($report->master_info)
            <tr>
                <td><strong>Master's Name</strong></td>
                <td>{{ $report->master_info->master_info }}</td>
            </tr>
        @endif
    @endforeach
</table>
