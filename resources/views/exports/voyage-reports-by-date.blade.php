<table border="1" cellspacing="0" cellpadding="4">
    <thead>
        <tr>
            @php
                $headers = [
                    'Report Type', 'Vessel', 'Voyage No', 'Date',

                    // Location
                    'Port of Departure (COSP)', 'Port of Arrival (EOSP)',

                    // Off Hire
                    'Off Hire Hours', 'Off Hire Reason',

                    // Engine
                    'Avg ME RPM', 'Avg ME kW', 'TDR (Nm)', 'TST (Hrs)', 'Slip (%)',

                    // ROB
                    'HSFO (MT)', 'VLSFO (MT)', 'BIOFUEL (MT)', 'LSMGO (MT)',
                    'ME CC OIL (LITRES)', 'MC CYL OIL (LITRES)', 'GE CC OIL (LITRES)',
                    'FW (MT)', 'FW Produced (MT)',

                    // Received
                    'HSFO (MT)', 'VLSFO (MT)', 'BIOFUEL (MT)', 'LSMGO (MT)',
                    'ME CC OIL (LITRES)', 'MC CYL OIL (LITRES)', 'GE CC OIL (LITRES)',
                    'FW (MT)', 'FW Produced (MT)',

                    // Consumption
                    'HSFO (MT)', 'VLSFO (MT)', 'BIOFUEL (MT)', 'LSMGO (MT)',
                    'ME CC OIL (LITRES)', 'MC CYL OIL (LITRES)', 'GE CC OIL (LITRES)',
                    'FW (MT)', 'FW Produced (MT)',

                    // Remarks and Master
                    'Remarks', 'Master Infomation'
                ];
            @endphp

            @foreach ($headers as $header)
                <th style="width: 250px;">{{ $header }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $report)
            @php
                $rob = $report->robs->first();
                $recv = $report->received;
                $cons = $report->consumption;
            @endphp

            @if (!$loop->first)
                <tr>
                    <td colspan="11" style="height: 15px;"></td> {{-- Spacer row --}}
                </tr>
            @endif

            <tr>
                {{-- Voyage --}}
                <td>{{ $report->report_type }}</td>
                <td>{{ $report->vessel->name ?? '' }}</td>
                <td>{{ $report->voyage_no ?? '' }}</td>
                <td>{{ \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') }}</td>

                {{-- Location --}}
                <td>{{ $report->location->port_departure ? \Carbon\Carbon::parse($report->location->port_departure)->format('M d, Y h:i A') : '' }}</td>
                <td>{{ $report->location->port_arrival ? \Carbon\Carbon::parse($report->location->port_arrival)->format('M d, Y h:i A') : '' }}</td>

                {{-- Off Hire --}}
                <td>{{ $report->off_hire->hire_hours ?? '' }}</td>
                <td>{{ $report->off_hire->hire_reason ?? '' }}</td>

                {{-- Engine --}}
                <td>{{ $report->engine->avg_me_rpm ?? '' }}</td>
                <td>{{ $report->engine->avg_me_kw ?? '' }}</td>
                <td>{{ $report->engine->tdr ?? '' }}</td>
                <td>{{ $report->engine->tst ?? '' }}</td>
                <td>{{ $report->engine->slip ?? '' }}</td>

                {{-- ROB --}}
                <td>{{ $rob->hsfo ?? '' }}</td>
                <td>{{ $rob->vlsfo ?? '' }}</td>
                <td>{{ $rob->biofuel ?? '' }}</td>
                <td>{{ $rob->lsmgo ?? '' }}</td>
                <td>{{ $rob->me_cc_oil ?? '' }}</td>
                <td>{{ $rob->mc_cyl_oil ?? '' }}</td>
                <td>{{ $rob->ge_cc_oil ?? '' }}</td>
                <td>{{ $rob->fw ?? '' }}</td>
                <td>{{ $rob->fw_produced ?? '' }}</td>

                {{-- Received --}}
                <td>{{ $recv->hsfo ?? '' }}</td>
                <td>{{ $recv->vlsfo ?? '' }}</td>
                <td>{{ $recv->biofuel ?? '' }}</td>
                <td>{{ $recv->lsmgo ?? '' }}</td>
                <td>{{ $recv->me_cc_oil ?? '' }}</td>
                <td>{{ $recv->mc_cyl_oil ?? '' }}</td>
                <td>{{ $recv->ge_cc_oil ?? '' }}</td>
                <td>{{ $recv->fw ?? '' }}</td>
                <td>{{ $recv->fw_produced ?? '' }}</td>

                {{-- Consumption --}}
                <td>{{ $cons->hsfo ?? '' }}</td>
                <td>{{ $cons->vlsfo ?? '' }}</td>
                <td>{{ $cons->biofuel ?? '' }}</td>
                <td>{{ $cons->lsmgo ?? '' }}</td>
                <td>{{ $cons->me_cc_oil ?? '' }}</td>
                <td>{{ $cons->mc_cyl_oil ?? '' }}</td>
                <td>{{ $cons->ge_cc_oil ?? '' }}</td>
                <td>{{ $cons->fw ?? '' }}</td>
                <td>{{ $cons->fw_produced ?? '' }}</td>

                {{-- Remarks & Master --}}
                <td>{{ $report->remarks->remarks ?? '' }}</td>
                <td>{{ $report->master_info->master_info ?? '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
