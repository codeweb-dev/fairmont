<table border="1" cellspacing="0" cellpadding="4">
    <thead>
        <tr>
            @php
                $headers = [
                    'Vessel', 'Voyage No', 'Date',

                    // Location
                    'Port Departure (COSP)', 'Port Arrival (EOSP)',

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
                <th style="width: 250px;"><strong>{{ $header }}</strong></th>
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
                    <td colspan="11" style="height: 20px;"></td> {{-- Spacer row --}}
                </tr>
            @endif

            <tr>
                {{-- Voyage --}}
                <td style="text-align: left;">{{ $report->vessel->name ?? '' }}</td>
                <td style="text-align: left;">{{ $report->voyage_no ?? '' }}</td>
                <td style="text-align: left;">{{ \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') }}</td>

                {{-- Location --}}
                <td style="text-align: left;">{{ $report->location->port_departure ? \Carbon\Carbon::parse($report->location->port_departure)->format('M d, Y h:i A') : '' }}</td>
                <td style="text-align: left;">{{ $report->location->port_arrival ? \Carbon\Carbon::parse($report->location->port_arrival)->format('M d, Y h:i A') : '' }}</td>

                {{-- Off Hire --}}
                <td style="text-align: left;">{{ $report->off_hire->hire_hours ?? '' }}</td>
                <td style="text-align: left;">{{ $report->off_hire->hire_reason ?? '' }}</td>

                {{-- Engine --}}
                <td style="text-align: left;">{{ $report->engine->avg_me_rpm ?? '' }}</td>
                <td style="text-align: left;">{{ $report->engine->avg_me_kw ?? '' }}</td>
                <td style="text-align: left;">{{ $report->engine->tdr ?? '' }}</td>
                <td style="text-align: left;">{{ $report->engine->tst ?? '' }}</td>
                <td style="text-align: left;">{{ $report->engine->slip ?? '' }}</td>

                {{-- ROB --}}
                <td style="text-align: left;">{{ $rob->hsfo ?? '' }}</td>
                <td style="text-align: left;">{{ $rob->vlsfo ?? '' }}</td>
                <td style="text-align: left;">{{ $rob->biofuel ?? '' }}</td>
                <td style="text-align: left;">{{ $rob->lsmgo ?? '' }}</td>
                <td style="text-align: left;">{{ $rob->me_cc_oil ?? '' }}</td>
                <td style="text-align: left;">{{ $rob->mc_cyl_oil ?? '' }}</td>
                <td style="text-align: left;">{{ $rob->ge_cc_oil ?? '' }}</td>
                <td style="text-align: left;">{{ $rob->fw ?? '' }}</td>
                <td style="text-align: left;">{{ $rob->fw_produced ?? '' }}</td>

                {{-- Received --}}
                <td style="text-align: left;">{{ $recv->hsfo ?? '' }}</td>
                <td style="text-align: left;">{{ $recv->vlsfo ?? '' }}</td>
                <td style="text-align: left;">{{ $recv->biofuel ?? '' }}</td>
                <td style="text-align: left;">{{ $recv->lsmgo ?? '' }}</td>
                <td style="text-align: left;">{{ $recv->me_cc_oil ?? '' }}</td>
                <td style="text-align: left;">{{ $recv->mc_cyl_oil ?? '' }}</td>
                <td style="text-align: left;">{{ $recv->ge_cc_oil ?? '' }}</td>
                <td style="text-align: left;">{{ $recv->fw ?? '' }}</td>
                <td style="text-align: left;">{{ $recv->fw_produced ?? '' }}</td>

                {{-- Consumption --}}
                <td style="text-align: left;">{{ $cons->hsfo ?? '' }}</td>
                <td style="text-align: left;">{{ $cons->vlsfo ?? '' }}</td>
                <td style="text-align: left;">{{ $cons->biofuel ?? '' }}</td>
                <td style="text-align: left;">{{ $cons->lsmgo ?? '' }}</td>
                <td style="text-align: left;">{{ $cons->me_cc_oil ?? '' }}</td>
                <td style="text-align: left;">{{ $cons->mc_cyl_oil ?? '' }}</td>
                <td style="text-align: left;">{{ $cons->ge_cc_oil ?? '' }}</td>
                <td style="text-align: left;">{{ $cons->fw ?? '' }}</td>
                <td style="text-align: left;">{{ $cons->fw_produced ?? '' }}</td>

                {{-- Remarks & Master --}}
                <td style="text-align: left;">{{ $report->remarks->remarks ?? '' }}</td>
                <td style="text-align: left;">{{ $report->master_info->master_info ?? '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
