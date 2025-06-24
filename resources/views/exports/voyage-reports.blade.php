<table>
    <thead>
        <tr>
            <th>Report Type</th>
            <th>Vessel</th>
            <th>Unit</th>
            <th>Voyage No</th>
            <th>Date</th>
            <th>Port Departure (COSP)</th>
            <th>Port Arrival (EOSP)</th>
            <th>Off Hire Hours</th>
            <th>Off Hire Reason</th>
            <th>Avg ME RPM</th>
            <th>Avg ME kW</th>
            <th>TDR (Nm)</th>
            <th>TST (Hrs)</th>
            <th>Slip (%)</th>
            <th>HSFO (ROB)</th>
            <th>VLSFO (ROB)</th>
            <th>BIOFUEL (ROB)</th>
            <th>LSMGO (ROB)</th>
            <th>ME CC OIL (ROB)</th>
            <th>MC CYL OIL (ROB)</th>
            <th>GE CC OIL (ROB)</th>
            <th>FW (ROB)</th>
            <th>FW Produced (ROB)</th>
            <th>HSFO (Received)</th>
            <th>VLSFO (Received)</th>
            <th>BIOFUEL (Received)</th>
            <th>LSMGO (Received)</th>
            <th>ME CC OIL (Received)</th>
            <th>MC CYL OIL (Received)</th>
            <th>GE CC OIL (Received)</th>
            <th>FW (Received)</th>
            <th>FW Produced (Received)</th>
            <th>HSFO (Consumed)</th>
            <th>VLSFO (Consumed)</th>
            <th>BIOFUEL (Consumed)</th>
            <th>LSMGO (Consumed)</th>
            <th>ME CC OIL (Consumed)</th>
            <th>MC CYL OIL (Consumed)</th>
            <th>GE CC OIL (Consumed)</th>
            <th>FW (Consumed)</th>
            <th>FW Produced (Consumed)</th>
            <th>Master's Info</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $report)
            @php
                $rob = $report->robs->first();
                $recv = $report->received;
                $cons = $report->consumption;
            @endphp
            <tr>
                <td>{{ $report->report_type }}</td>
                <td>{{ $report->vessel->name ?? '-' }}</td>
                <td>{{ $report->unit->name ?? '-' }}</td>
                <td>{{ $report->voyage_no }}</td>
                <td>{{ $report->all_fast_datetime ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y') : '-' }}</td>
                <td>{{ $report->location->port_departure ?? '-' }}</td>
                <td>{{ $report->location->port_arrival ?? '-' }}</td>
                <td>{{ $report->off_hire->hire_hours ?? '-' }}</td>
                <td>{{ $report->off_hire->hire_reason ?? '-' }}</td>
                <td>{{ $report->engine->avg_me_rpm ?? '-' }}</td>
                <td>{{ $report->engine->avg_me_kw ?? '-' }}</td>
                <td>{{ $report->engine->tdr ?? '-' }}</td>
                <td>{{ $report->engine->tst ?? '-' }}</td>
                <td>{{ $report->engine->slip ?? '-' }}</td>

                {{-- ROB --}}
                <td>{{ $rob->hsfo ?? '-' }}</td>
                <td>{{ $rob->vlsfo ?? '-' }}</td>
                <td>{{ $rob->biofuel ?? '-' }}</td>
                <td>{{ $rob->lsmgo ?? '-' }}</td>
                <td>{{ $rob->me_cc_oil ?? '-' }}</td>
                <td>{{ $rob->mc_cyl_oil ?? '-' }}</td>
                <td>{{ $rob->ge_cc_oil ?? '-' }}</td>
                <td>{{ $rob->fw ?? '-' }}</td>
                <td>{{ $rob->fw_produced ?? '-' }}</td>

                {{-- Received --}}
                <td>{{ $recv->hsfo ?? '-' }}</td>
                <td>{{ $recv->vlsfo ?? '-' }}</td>
                <td>{{ $recv->biofuel ?? '-' }}</td>
                <td>{{ $recv->lsmgo ?? '-' }}</td>
                <td>{{ $recv->me_cc_oil ?? '-' }}</td>
                <td>{{ $recv->mc_cyl_oil ?? '-' }}</td>
                <td>{{ $recv->ge_cc_oil ?? '-' }}</td>
                <td>{{ $recv->fw ?? '-' }}</td>
                <td>{{ $recv->fw_produced ?? '-' }}</td>

                {{-- Consumption --}}
                <td>{{ $cons->hsfo ?? '-' }}</td>
                <td>{{ $cons->vlsfo ?? '-' }}</td>
                <td>{{ $cons->biofuel ?? '-' }}</td>
                <td>{{ $cons->lsmgo ?? '-' }}</td>
                <td>{{ $cons->me_cc_oil ?? '-' }}</td>
                <td>{{ $cons->mc_cyl_oil ?? '-' }}</td>
                <td>{{ $cons->ge_cc_oil ?? '-' }}</td>
                <td>{{ $cons->fw ?? '-' }}</td>
                <td>{{ $cons->fw_produced ?? '-' }}</td>

                <td>{{ $report->master_info->master_info ?? '-' }}</td>
                <td>{{ $report->remarks->remarks ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
