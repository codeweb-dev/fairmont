@foreach ($reports as $report)
    @php
        $rob = $report->robs->first();
        $recv = $report->received;
        $cons = $report->consumption;
    @endphp

    <table>
        <tr><td style="font-weight: bold;">Voyage Report Details</td></tr>
    </table>

    <table>
        {{-- Voyage Details --}}
        <tr><td colspan="2" style="font-weight: bold; width: 150px;">Voyage Details</td></tr>
        <tr><td style="width: 150px;">Report Type:</td><td style="width: 150px;">{{ $report->report_type }}</td></tr>
        <tr><td>Vessel:</td><td>{{ $report->vessel->name ?? 'N/A' }}</td></tr>
        <tr><td>Voyage No:</td><td>{{ $report->voyage_no ?? 'N/A' }}</td></tr>
        <tr><td>Date:</td><td>{{ \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y') }}</td></tr>

        <tr><td colspan="7"></td></tr>

        {{-- Location --}}
        <tr><td colspan="2" style="font-weight: bold;">Location</td></tr>
        <tr><td>Port Departure (COSP):</td><td>{{ $report->location->port_departure ?? 'N/A' }}</td></tr>
        <tr><td>Port Arrival (EOSP):</td><td>{{ $report->location->port_arrival ?? 'N/A' }}</td></tr>

        <tr><td colspan="7"></td></tr>

        {{-- Off Hire --}}
        <tr><td colspan="2" style="font-weight: bold;">Off Hire</td></tr>
        <tr><td>Off Hire Hours:</td><td>{{ $report->off_hire->hire_hours ?? 'N/A' }}</td></tr>
        <tr><td>Off Hire Reason:</td><td>{{ $report->off_hire->hire_reason ?? 'N/A' }}</td></tr>

        <tr><td colspan="7"></td></tr>

        {{-- Engine --}}
        <tr><td colspan="2" style="font-weight: bold;">Engine</td></tr>
        <tr><td>Avg ME RPM:</td><td>{{ $report->engine->avg_me_rpm ?? 'N/A' }}</td></tr>
        <tr><td>Avg ME kW:</td><td>{{ $report->engine->avg_me_kw ?? 'N/A' }}</td></tr>
        <tr><td>TDR (Nm):</td><td>{{ $report->engine->tdr ?? 'N/A' }}</td></tr>
        <tr><td>TST (Hrs):</td><td>{{ $report->engine->tst ?? 'N/A' }}</td></tr>
        <tr><td>Slip (%):</td><td>{{ $report->engine->slip ?? 'N/A' }}</td></tr>

        <tr><td colspan="7"></td></tr>

        {{-- ROB --}}
        <tr><td colspan="2" style="font-weight: bold;">ROB</td></tr>
        <tr><td>HSFO (MT):</td><td>{{ $rob->hsfo ?? 'N/A' }}</td></tr>
        <tr><td>VLSFO (MT):</td><td>{{ $rob->vlsfo ?? 'N/A' }}</td></tr>
        <tr><td>BIOFUEL (MT):</td><td>{{ $rob->biofuel ?? 'N/A' }}</td></tr>
        <tr><td>LSMGO (MT):</td><td>{{ $rob->lsmgo ?? 'N/A' }}</td></tr>
        <tr><td>ME CC OIL (LITRES):</td><td>{{ $rob->me_cc_oil ?? 'N/A' }}</td></tr>
        <tr><td>MC CYL OIL (LITRES):</td><td>{{ $rob->mc_cyl_oil ?? 'N/A' }}</td></tr>
        <tr><td>GE CC OIL (LITRES):</td><td>{{ $rob->ge_cc_oil ?? 'N/A' }}</td></tr>
        <tr><td>FW (MT):</td><td>{{ $rob->fw ?? 'N/A' }}</td></tr>
        <tr><td>FW Produced (MT):</td><td>{{ $rob->fw_produced ?? 'N/A' }}</td></tr>

        <tr><td colspan="7"></td></tr>

        {{-- Received --}}
        <tr><td colspan="2" style="font-weight: bold;">Received</td></tr>
        <tr><td>HSFO (MT):</td><td>{{ $recv->hsfo ?? 'N/A' }}</td></tr>
        <tr><td>VLSFO (MT):</td><td>{{ $recv->vlsfo ?? 'N/A' }}</td></tr>
        <tr><td>BIOFUEL (MT):</td><td>{{ $recv->biofuel ?? 'N/A' }}</td></tr>
        <tr><td>LSMGO (MT):</td><td>{{ $recv->lsmgo ?? 'N/A' }}</td></tr>
        <tr><td>ME CC OIL (LITRES):</td><td>{{ $recv->me_cc_oil ?? 'N/A' }}</td></tr>
        <tr><td>MC CYL OIL (LITRES):</td><td>{{ $recv->mc_cyl_oil ?? 'N/A' }}</td></tr>
        <tr><td>GE CC OIL (LITRES):</td><td>{{ $recv->ge_cc_oil ?? 'N/A' }}</td></tr>
        <tr><td>FW (MT):</td><td>{{ $recv->fw ?? 'N/A' }}</td></tr>
        <tr><td>FW Produced (MT):</td><td>{{ $recv->fw_produced ?? 'N/A' }}</td></tr>

        <tr><td colspan="7"></td></tr>

        {{-- Consumption --}}
        <tr><td colspan="2" style="font-weight: bold;">Consumption</td></tr>
        <tr><td>HSFO (MT):</td><td>{{ $cons->hsfo ?? 'N/A' }}</td></tr>
        <tr><td>VLSFO (MT):</td><td>{{ $cons->vlsfo ?? 'N/A' }}</td></tr>
        <tr><td>BIOFUEL (MT):</td><td>{{ $cons->biofuel ?? 'N/A' }}</td></tr>
        <tr><td>LSMGO (MT):</td><td>{{ $cons->lsmgo ?? 'N/A' }}</td></tr>
        <tr><td>ME CC OIL (LITRES):</td><td>{{ $cons->me_cc_oil ?? 'N/A' }}</td></tr>
        <tr><td>MC CYL OIL (LITRES):</td><td>{{ $cons->mc_cyl_oil ?? 'N/A' }}</td></tr>
        <tr><td>GE CC OIL (LITRES):</td><td>{{ $cons->ge_cc_oil ?? 'N/A' }}</td></tr>
        <tr><td>FW (MT):</td><td>{{ $cons->fw ?? 'N/A' }}</td></tr>
        <tr><td>FW Produced (MT):</td><td>{{ $cons->fw_produced ?? 'N/A' }}</td></tr>

        <tr><td colspan="7"></td></tr>

        {{-- Remarks --}}
        <tr><td colspan="2" style="font-weight: bold;">Remarks</td></tr>
        <tr><td>Remarks:</td><td>{{ $report->remarks->remarks ?? 'N/A' }}</td></tr>

        <tr><td colspan="7"></td></tr>

        {{-- Master Information --}}
        <tr><td colspan="2" style="font-weight: bold;">Master Information</td></tr>
        <tr><td>Master’s Info:</td><td>{{ $report->master_info->master_info ?? 'N/A' }}</td></tr>
    </table>

    <br><br>
@endforeach
