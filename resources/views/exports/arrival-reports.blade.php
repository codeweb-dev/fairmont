<table>
    <thead>
        <tr>
            <th colspan="2">Arrival Report Summary</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $report)
            <tr><td colspan="2"><strong>Report Type:</strong> {{ $report->report_type }}</td></tr>
            <tr><td>Vessel</td><td>{{ $report->vessel->name }}</td></tr>
            <tr><td>Unit</td><td>{{ $report->unit->name }}</td></tr>
            <tr><td>All Fast Date/Time</td><td>{{ $report->all_fast_datetime }}</td></tr>
            <tr><td>GMT Offset</td><td>{{ $report->gmt_offset }}</td></tr>
            <tr><td>Port</td><td>{{ $report->port }}</td></tr>
            <tr><td>Bunkering Port</td><td>{{ $report->bunkering_port }}</td></tr>
            <tr><td>Port GMT Offset</td><td>{{ $report->port_gmt_offset }}</td></tr>
            <tr><td>Supplier</td><td>{{ $report->supplier }}</td></tr>

            @if ($report->noon_report)
                <tr><td colspan="2"><strong>Noon Report Details</strong></td></tr>
                <tr><td>CP Ordered Speed</td><td>{{ $report->noon_report->cp_ordered_speed }}</td></tr>
                <tr><td>ME Cons. C/P Speed</td><td>{{ $report->noon_report->me_cons_cp_speed }}</td></tr>
                <tr><td>Observed Distance</td><td>{{ $report->noon_report->obs_distance }}</td></tr>
                <tr><td>Steaming Time</td><td>{{ $report->noon_report->steaming_time }}</td></tr>
                <tr><td>Avg Speed</td><td>{{ $report->noon_report->avg_speed }}</td></tr>
                <tr><td>Distance to Go</td><td>{{ $report->noon_report->distance_to_go }}</td></tr>
                <tr><td>Breakdown</td><td>{{ $report->noon_report->breakdown }}</td></tr>
                <tr><td>Maneuvering Hours</td><td>{{ $report->noon_report->maneuvering_hours }}</td></tr>
                <tr><td>Avg RPM</td><td>{{ $report->noon_report->avg_rpm }}</td></tr>
                <tr><td>Engine Distance</td><td>{{ $report->noon_report->engine_distance }}</td></tr>
                <tr><td>Slip</td><td>{{ $report->noon_report->next_port }}</td></tr>
                <tr><td>Avg Power</td><td>{{ $report->noon_report->avg_power }}</td></tr>
                <tr><td>Logged Distance</td><td>{{ $report->noon_report->logged_distance }}</td></tr>
                <tr><td>Speed Through Water</td><td>{{ $report->noon_report->speed_through_water }}</td></tr>
                <tr><td>Course</td><td>{{ $report->noon_report->course }}</td></tr>
                <tr><td>Condition</td><td>{{ $report->noon_report->condition }}</td></tr>
                <tr><td>Displacement</td><td>{{ $report->noon_report->displacement }}</td></tr>
                <tr><td>Cargo Name</td><td>{{ $report->noon_report->cargo_name }}</td></tr>
                <tr><td>Cargo Weight</td><td>{{ $report->noon_report->cargo_weight }}</td></tr>
                <tr><td>Ballast Weight</td><td>{{ $report->noon_report->ballast_weight }}</td></tr>
                <tr><td>Fresh Water</td><td>{{ $report->noon_report->fresh_water }}</td></tr>
                <tr><td>Fwd Draft</td><td>{{ $report->noon_report->fwd_draft }}</td></tr>
                <tr><td>Aft Draft</td><td>{{ $report->noon_report->aft_draft }}</td></tr>
                <tr><td>GM</td><td>{{ $report->noon_report->gm }}</td></tr>
            @endif

            @if ($report->rob_fuel_reports && $report->rob_fuel_reports->count())
                <tr><td colspan="2"><strong>ROB Fuel Summary</strong></td></tr>
                @foreach ($report->rob_fuel_reports as $fuel)
                    <tr><td colspan="2"><strong>Fuel Type: {{ $fuel->fuel_type }}</strong></td></tr>
                    <tr><td>Previous</td><td>{{ $fuel->previous }}</td></tr>
                    <tr><td>Current</td><td>{{ $fuel->current }}</td></tr>
                    <tr><td>ME Propulsion</td><td>{{ $fuel->me_propulsion }}</td></tr>
                    <tr><td>AE Cons</td><td>{{ $fuel->ae_cons }}</td></tr>
                    <tr><td>Boiler Cons</td><td>{{ $fuel->boiler_cons }}</td></tr>
                    <tr><td>Incinerators</td><td>{{ $fuel->incinerators }}</td></tr>
                    <tr><td>ME 24</td><td>{{ $fuel->me_24 }}</td></tr>
                    <tr><td>AE 24</td><td>{{ $fuel->ae_24 }}</td></tr>
                    <tr><td>Total Cons</td><td>{{ $fuel->total_cons }}</td></tr>

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

            @if ($report->master_info)
                <tr><td><strong>Master's Info</strong></td><td>{{ $report->master_info->master_info }}</td></tr>
            @endif

            @if ($report->remarks)
                <tr><td><strong>Remarks</strong></td><td>{{ $report->remarks->remarks }}</td></tr>
            @endif

            <tr><td colspan="2"><hr></td></tr>
        @endforeach
    </tbody>
</table>
