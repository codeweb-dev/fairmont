@foreach ($reports as $report)
    @php
        $rob = $report->robs->first();
        $recv = $report->received;
        $cons = $report->consumption;
    @endphp

    <table>
        {{-- Voyage Details --}}
        <tr><td colspan="2" style="font-weight: bold; width: 150px;">Voyage Details</td></tr>
        <tr><td style="width: 150px;">Report Type:</td><td style="width: 150px;">{{ $report->report_type }}</td></tr>
        <tr><td>Vessel:</td><td>{{ $report->vessel->name ?? '-' }}</td></tr>
        <tr><td>Unit:</td><td>{{ $report->unit->name ?? '-' }}</td></tr>
        <tr><td>Voyage No:</td><td>{{ $report->voyage_no }}</td></tr>
        <tr><td>Date:</td><td>{{ \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y') }}</td></tr>

        <tr><td colspan="7"></td></tr>

        {{-- Location --}}
        <tr><td colspan="2" style="font-weight: bold;">Location</td></tr>
        <tr><td>Port Departure (COSP):</td><td>{{ $report->location->port_departure ?? '-' }}</td></tr>
        <tr><td>Port Arrival (EOSP):</td><td>{{ $report->location->port_arrival ?? '-' }}</td></tr>

        <tr><td colspan="7"></td></tr>

        {{-- Off Hire --}}
        <tr><td colspan="2" style="font-weight: bold;">Off Hire</td></tr>
        <tr><td>Off Hire Hours:</td><td>{{ $report->off_hire->hire_hours ?? '-' }}</td></tr>
        <tr><td>Off Hire Reason:</td><td>{{ $report->off_hire->hire_reason ?? '-' }}</td></tr>

        <tr><td colspan="7"></td></tr>

        {{-- Engine --}}
        <tr><td colspan="2" style="font-weight: bold;">Engine</td></tr>
        <tr><td>Avg ME RPM:</td><td>{{ $report->engine->avg_me_rpm ?? '-' }}</td></tr>
        <tr><td>Avg ME kW:</td><td>{{ $report->engine->avg_me_kw ?? '-' }}</td></tr>
        <tr><td>TDR (Nm):</td><td>{{ $report->engine->tdr ?? '-' }}</td></tr>
        <tr><td>TST (Hrs):</td><td>{{ $report->engine->tst ?? '-' }}</td></tr>
        <tr><td>Slip (%):</td><td>{{ $report->engine->slip ?? '-' }}</td></tr>

        <tr><td colspan="7"></td></tr>

        {{-- ROB --}}
        <tr><td colspan="2" style="font-weight: bold;">ROB</td></tr>
        <tr><td>HSFO (MT):</td><td>{{ $rob->hsfo ?? '-' }}</td></tr>
        <tr><td>VLSFO (MT):</td><td>{{ $rob->vlsfo ?? '-' }}</td></tr>
        <tr><td>BIOFUEL (MT):</td><td>{{ $rob->biofuel ?? '-' }}</td></tr>
        <tr><td>LSMGO (MT):</td><td>{{ $rob->lsmgo ?? '-' }}</td></tr>
        <tr><td>ME CC OIL (Litres):</td><td>{{ $rob->me_cc_oil ?? '-' }}</td></tr>
        <tr><td>MC CYL OIL (Litres):</td><td>{{ $rob->mc_cyl_oil ?? '-' }}</td></tr>
        <tr><td>GE CC OIL (Litres):</td><td>{{ $rob->ge_cc_oil ?? '-' }}</td></tr>
        <tr><td>FW (MT):</td><td>{{ $rob->fw ?? '-' }}</td></tr>
        <tr><td>FW Produced (MT):</td><td>{{ $rob->fw_produced ?? '-' }}</td></tr>

        <tr><td colspan="7"></td></tr>

        {{-- Received --}}
        <tr><td colspan="2" style="font-weight: bold;">Received</td></tr>
        <tr><td>HSFO:</td><td>{{ $recv->hsfo ?? '-' }}</td></tr>
        <tr><td>VLSFO:</td><td>{{ $recv->vlsfo ?? '-' }}</td></tr>
        <tr><td>BIOFUEL:</td><td>{{ $recv->biofuel ?? '-' }}</td></tr>
        <tr><td>LSMGO:</td><td>{{ $recv->lsmgo ?? '-' }}</td></tr>
        <tr><td>ME CC OIL:</td><td>{{ $recv->me_cc_oil ?? '-' }}</td></tr>
        <tr><td>MC CYL OIL:</td><td>{{ $recv->mc_cyl_oil ?? '-' }}</td></tr>
        <tr><td>GE CC OIL:</td><td>{{ $recv->ge_cc_oil ?? '-' }}</td></tr>
        <tr><td>FW:</td><td>{{ $recv->fw ?? '-' }}</td></tr>
        <tr><td>FW Produced:</td><td>{{ $recv->fw_produced ?? '-' }}</td></tr>

        <tr><td colspan="7"></td></tr>

        {{-- Consumption --}}
        <tr><td colspan="2" style="font-weight: bold;">Consumption</td></tr>
        <tr><td>HSFO:</td><td>{{ $cons->hsfo ?? '-' }}</td></tr>
        <tr><td>VLSFO:</td><td>{{ $cons->vlsfo ?? '-' }}</td></tr>
        <tr><td>BIOFUEL:</td><td>{{ $cons->biofuel ?? '-' }}</td></tr>
        <tr><td>LSMGO:</td><td>{{ $cons->lsmgo ?? '-' }}</td></tr>
        <tr><td>ME CC OIL:</td><td>{{ $cons->me_cc_oil ?? '-' }}</td></tr>
        <tr><td>MC CYL OIL:</td><td>{{ $cons->mc_cyl_oil ?? '-' }}</td></tr>
        <tr><td>GE CC OIL:</td><td>{{ $cons->ge_cc_oil ?? '-' }}</td></tr>
        <tr><td>FW:</td><td>{{ $cons->fw ?? '-' }}</td></tr>
        <tr><td>FW Produced:</td><td>{{ $cons->fw_produced ?? '-' }}</td></tr>

        <tr><td colspan="7"></td></tr>

        {{-- Master's Info --}}
        <tr><td colspan="2" style="font-weight: bold;">Master's Info</td></tr>
        <tr><td>Master’s Info:</td><td>{{ $report->master_info->master_info ?? '-' }}</td></tr>

        <tr><td colspan="7"></td></tr>

        {{-- Remarks --}}
        <tr><td colspan="2" style="font-weight: bold;">Remarks</td></tr>
        <tr><td>Remarks:</td><td>{{ $report->remarks->remarks ?? '-' }}</td></tr>
    </table>

    <br><br>
@endforeach
