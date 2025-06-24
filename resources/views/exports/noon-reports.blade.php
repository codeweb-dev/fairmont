<table style="text-align: left;">
    <colgroup>
        <col style="width: 200px;">
        <col style="width: 450px;">
    </colgroup>
    <thead>
        <tr>
            <th colspan="2"></th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $report)
            {{-- Basic Info --}}
            <tr><td colspan="2"><strong>Voyage Details</strong></tr>
            <tr><td>Vessel</td><td>{{ $report->vessel->name }}</td></tr>
            <tr><td>Unit</td><td>{{ $report->unit->name }}</td></tr>
            <tr><td>Date/Time (LT)</td><td>{{ $report->all_fast_datetime }}</td></tr>
            <tr><td>GMT Offset</td><td>{{ $report->gmt_offset }}</td></tr>
            <tr><td>Latitude</td><td>{{ $report->port }}</td></tr>
            <tr><td>Longitude</td><td>{{ $report->bunkering_port }}</td></tr>
            <tr><td>Port of Departure</td><td>{{ $report->supplier }}</td></tr>

            <tr><td colspan="2"><br></tr>

            {{-- Noon Report Core --}}
            @if ($report->noon_report)
                <tr><td colspan="2"><strong>Details Since Last Report</strong></td></tr>
                <tr><td>CP/Ordered Speed (Kts)</td><td>{{ $report->noon_report->cp_ordered_speed }}</td></tr>
                <tr><td>Allowed M/E Cons. at C/P Speed</td><td>{{ $report->noon_report->me_cons_cp_speed }}</td></tr>
                <tr><td>Observed Distance</td><td>{{ $report->noon_report->obs_distance }}</td></tr>
                <tr><td>Steaming Time</td><td>{{ $report->noon_report->steaming_time }}</td></tr>
                <tr><td>Avg Speed</td><td>{{ $report->noon_report->avg_speed }}</td></tr>
                <tr><td>Distance to Go</td><td>{{ $report->noon_report->distance_to_go }}</td></tr>
                <tr><td>Course</td><td>{{ $report->noon_report->course }}</td></tr>
                <tr><td>Breakdown</td><td>{{ $report->noon_report->breakdown }}</td></tr>
                <tr><td>Avg RPM</td><td>{{ $report->noon_report->avg_rpm }}</td></tr>
                <tr><td>Engine Distance</td><td>{{ $report->noon_report->engine_distance }}</td></tr>
                <tr><td>Slip</td><td>{{ $report->noon_report->slip }}</td></tr>
                <tr><td>M/E Output %MCR</td><td>{{ $report->noon_report->me_output_mcr }}</td></tr>
                <tr><td>Avg Power (kW)</td><td>{{ $report->noon_report->avg_power }}</td></tr>
                <tr><td>Logged Distance</td><td>{{ $report->noon_report->logged_distance }}</td></tr>
                <tr><td>Speed Through Water</td><td>{{ $report->noon_report->speed_through_water }}</td></tr>
                <tr><td>Next Port</td><td>{{ $report->noon_report->next_port }}</td></tr>
                <tr><td>ETA Next Port</td><td>{{ $report->noon_report->eta_next_port }}</td></tr>
                <tr><td>ETA GMT Offset</td><td>{{ $report->noon_report->eta_gmt_offset }}</td></tr>
                <tr><td>Anchored Hours</td><td>{{ $report->noon_report->anchored_hours }}</td></tr>
                <tr><td>Drifting Hours</td><td>{{ $report->noon_report->drifting_hours }}</td></tr>
                <tr><td>Maneuvering Hours</td><td>{{ $report->noon_report->maneuvering_hours }}</td></tr>

                <tr><td colspan="2"><br></tr>

                {{-- Noon Conditions --}}
                <tr><td colspan="2"><strong>Noon Conditions</strong></td></tr>
                <tr><td>Condition</td><td>{{ $report->noon_report->condition }}</td></tr>
                <tr><td>Displacement</td><td>{{ $report->noon_report->displacement }}</td></tr>
                <tr><td>Cargo Name</td><td>{{ $report->noon_report->cargo_name }}</td></tr>
                <tr><td>Cargo Weight</td><td>{{ $report->noon_report->cargo_weight }}</td></tr>
                <tr><td>Ballast Weight</td><td>{{ $report->noon_report->ballast_weight }}</td></tr>
                <tr><td>Fresh Water</td><td>{{ $report->noon_report->fresh_water }}</td></tr>
                <tr><td>Fwd Draft</td><td>{{ $report->noon_report->fwd_draft }}</td></tr>
                <tr><td>Aft Draft</td><td>{{ $report->noon_report->aft_draft }}</td></tr>
                <tr><td>GM</td><td>{{ $report->noon_report->gm }}</td></tr>

                <tr><td colspan="2"><br></tr>

                {{-- Diesel Engine Hours --}}
                <tr><td colspan="2"><strong>Diesel Engine Hours</strong></td></tr>
                <tr><td>DG1 Run Hours</td><td>{{ $report->noon_report->dg1_run_hours }}</td></tr>
                <tr><td>DG2 Run Hours</td><td>{{ $report->noon_report->dg2_run_hours }}</td></tr>
                <tr><td>DG3 Run Hours</td><td>{{ $report->noon_report->dg3_run_hours }}</td></tr>
            @endif

            <tr><td colspan="2"><br></tr>

            {{-- Weather Observations --}}
            @if ($report->weather_observations && $report->weather_observations->count())
                <tr><td colspan="2"><strong>Weather (Every 6 Hours)</strong></td></tr>
                @foreach ($report->weather_observations as $w)
                    <tr><td>Time Block</td><td>{{ $w->time_block }}</td></tr>
                    <tr><td>Wind Force</td><td>{{ $w->wind_force }}</td></tr>
                    <tr><td>Wind Dir</td><td>{{ $w->wind_direction }}</td></tr>
                    <tr><td>Swell Height</td><td>{{ $w->swell_height }}</td></tr>
                    <tr><td>Swell Dir</td><td>{{ $w->swell_direction }}</td></tr>
                    <tr><td>Wind Sea Height</td><td>{{ $w->wind_sea_height }}</td></tr>
                    <tr><td>Sea Dir</td><td>{{ $w->sea_direction }}</td></tr>
                    <tr><td>Sea DS</td><td>{{ $w->sea_ds }}</td></tr>
                @endforeach
            @endif

            <tr><td colspan="2"><br></tr>

            {{-- ROB Summary --}}
            @if ($report->rob_fuel_reports && $report->rob_fuel_reports->count())
                <tr><td colspan="2"><strong>ROB Fuel Summary</strong></td></tr>
                @foreach ($report->rob_fuel_reports as $fuel)
                    <tr><td colspan="2"><strong>Fuel Type: {{ $fuel->fuel_type }}</strong></td></tr>
                    <tr><td>Previous</td><td>{{ $fuel->previous }}</td></tr>
                    <tr><td>Current</td><td>{{ $fuel->current }}</td></tr>
                    <tr><td>M/E Propulsion</td><td>{{ $fuel->me_propulsion }}</td></tr>
                    <tr><td>A/E Cons.</td><td>{{ $fuel->ae_cons }}</td></tr>
                    <tr><td>Boiler Cons.</td><td>{{ $fuel->boiler_cons }}</td></tr>
                    <tr><td>Incinerators</td><td>{{ $fuel->incinerators }}</td></tr>
                    <tr><td>Total Cons.</td><td>{{ $fuel->total_cons }}</td></tr>
                    <tr><td>M/E 24</td><td>{{ $fuel->me_24 }}</td></tr>
                    <tr><td>A/E 24</td><td>{{ $fuel->ae_24 }}</td></tr>

                    <tr><td colspan="2"><br></tr>

                    {{-- Lube Oils --}}
                    <tr><td colspan="2"><strong>Lube Oils</strong></td></tr>
                    <tr><td>ME CYL Grade</td><td>{{ $fuel->me_cyl_grade }}</td></tr>
                    <tr><td>ME CYL Qty</td><td>{{ $fuel->me_cyl_qty }}</td></tr>
                    <tr><td>ME CYL Hrs</td><td>{{ $fuel->me_cyl_hrs }}</td></tr>
                    <tr><td>ME CYL Cons</td><td>{{ $fuel->me_cyl_cons }}</td></tr>
                    <tr><td>ME CC Qty</td><td>{{ $fuel->me_cc_qty }}</td></tr>
                    <tr><td>ME CC Hrs</td><td>{{ $fuel->me_cc_hrs }}</td></tr>
                    <tr><td>ME CC Cons</td><td>{{ $fuel->me_cc_cons }}</td></tr>
                    <tr><td>AE CC Qty</td><td>{{ $fuel->ae_cc_qty }}</td></tr>
                    <tr><td>AE CC Hrs</td><td>{{ $fuel->ae_cc_hrs }}</td></tr>
                    <tr><td>AE CC Cons</td><td>{{ $fuel->ae_cc_cons }}</td></tr>
                @endforeach
            @endif

            <tr><td colspan="2"><br></tr>

            {{-- ROB Tanks --}}
            @if ($report->rob_tanks && $report->rob_tanks->count())
                <tr><td colspan="2"><strong>ROB Tanks</strong></td></tr>
                @foreach ($report->rob_tanks as $tank)
                    <tr>
                        <td>{{ $tank->tank_no }} ({{ $tank->grade }})</td>
                        <td>ROB: {{ $tank->rob }} {{ $tank->unit }} | Cap: {{ $tank->capacity }}</td>
                    </tr>
                @endforeach
            @endif

            <tr><td colspan="2"><br></tr>

            {{-- Remarks & Master's Info --}}
            <tr><td><strong>Remarks</strong></td><td>{{ optional($report->remarks)->remarks }}</td></tr>

            <tr><td colspan="2"><br></tr>
            <tr><td><strong>Master's Info</strong></td><td>{{ optional($report->master_info)->master_info }}</td></tr>
        @endforeach
    </tbody>
</table>
