@foreach ($reports as $report)
    @php
        $rob = $report->robs->first();
        $recv = $report->received;
        $cons = $report->consumption;
    @endphp

    <table>
        <tr>
            <td colspan="6" style="font-weight: bold;">Voyage Report Details</td>
        </tr>
    </table>

    <table>
        {{-- Voyage Details --}}
        <tr>
            <td colspan="2" style="font-weight: bold; width: 250px;">Voyage Details</td>
        </tr>
        <tr>
            <td style="width: 250px;">Report Type:</td>
            <td style="width: 250px;">{{ $report->report_type }}</td>
        </tr>
        <tr>
            <td>Vessel:</td>
            <td style="text-align: left;">{{ $report->vessel->name ?? '' }}</td>
        </tr>
        <tr>
            <td>Voyage No:</td>
            <td style="text-align: left;">{{ $report->voyage_no ?? '' }}</td>
        </tr>
        <tr>
            <td>Date:</td>
            <td style="text-align: left;">{{ \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y') }}</td>
        </tr>

        <tr>
            <td colspan="7"></td>
        </tr>

        {{-- Location --}}
        <tr>
            <td colspan="2" style="font-weight: bold;">Location</td>
        </tr>
        <tr>
            <td>Port Departure (COSP):</td>
            <td style="text-align: left;">{{ $report->location->port_departure ?? '' }}</td>
        </tr>
        <tr>
            <td>Port Arrival (EOSP):</td>
            <td style="text-align: left;">{{ $report->location->port_arrival ?? '' }}</td>
        </tr>

        <tr>
            <td colspan="7"></td>
        </tr>

        {{-- Off Hire --}}
        <tr>
            <td colspan="2" style="font-weight: bold;">Off Hire</td>
        </tr>
        <tr>
            <td>Off Hire Hours:</td>
            <td style="text-align: left;">{{ $report->off_hire->hire_hours ?? '' }}</td>
        </tr>
        <tr>
            <td>Off Hire Reason:</td>
            <td style="text-align: left;">{{ $report->off_hire->hire_reason ?? '' }}</td>
        </tr>

        <tr>
            <td colspan="7"></td>
        </tr>

        {{-- Engine --}}
        <tr>
            <td colspan="2" style="font-weight: bold;">Engine</td>
        </tr>
        <tr>
            <td>Avg ME RPM:</td>
            <td style="text-align: left;">{{ $report->engine->avg_me_rpm ?? '' }}</td>
        </tr>
        <tr>
            <td>Avg ME kW:</td>
            <td style="text-align: left;">{{ $report->engine->avg_me_kw ?? '' }}</td>
        </tr>
        <tr>
            <td>TDR (Nm):</td>
            <td style="text-align: left;">{{ $report->engine->tdr ?? '' }}</td>
        </tr>
        <tr>
            <td>TST (Hrs):</td>
            <td style="text-align: left;">{{ $report->engine->tst ?? '' }}</td>
        </tr>
        <tr>
            <td>Slip (%):</td>
            <td style="text-align: left;">{{ $report->engine->slip ?? '' }}</td>
        </tr>

        <tr>
            <td colspan="7"></td>
        </tr>

        {{-- ROB --}}
        <tr>
            <td colspan="2" style="font-weight: bold;">ROB</td>
        </tr>
        <tr>
            <td>HSFO (MT):</td>
            <td style="text-align: left;">{{ $rob->hsfo ?? '' }}</td>
        </tr>
        <tr>
            <td>VLSFO (MT):</td>
            <td style="text-align: left;">{{ $rob->vlsfo ?? '' }}</td>
        </tr>
        <tr>
            <td>BIOFUEL (MT):</td>
            <td style="text-align: left;">{{ $rob->biofuel ?? '' }}</td>
        </tr>
        <tr>
            <td>LSMGO (MT):</td>
            <td style="text-align: left;">{{ $rob->lsmgo ?? '' }}</td>
        </tr>
        <tr>
            <td>ME CC OIL (LITRES):</td>
            <td style="text-align: left;">{{ $rob->me_cc_oil ?? '' }}</td>
        </tr>
        <tr>
            <td>MC CYL OIL (LITRES):</td>
            <td style="text-align: left;">{{ $rob->mc_cyl_oil ?? '' }}</td>
        </tr>
        <tr>
            <td>GE CC OIL (LITRES):</td>
            <td style="text-align: left;">{{ $rob->ge_cc_oil ?? '' }}</td>
        </tr>
        <tr>
            <td>FW (MT):</td>
            <td style="text-align: left;">{{ $rob->fw ?? '' }}</td>
        </tr>
        <tr>
            <td>FW Produced (MT):</td>
            <td style="text-align: left;">{{ $rob->fw_produced ?? '' }}</td>
        </tr>

        <tr>
            <td colspan="7"></td>
        </tr>

        {{-- Received --}}
        <tr>
            <td colspan="2" style="font-weight: bold;">Received</td>
        </tr>
        <tr>
            <td>HSFO (MT):</td>
            <td style="text-align: left;">{{ $recv->hsfo ?? '' }}</td>
        </tr>
        <tr>
            <td>VLSFO (MT):</td>
            <td style="text-align: left;">{{ $recv->vlsfo ?? '' }}</td>
        </tr>
        <tr>
            <td>BIOFUEL (MT):</td>
            <td style="text-align: left;">{{ $recv->biofuel ?? '' }}</td>
        </tr>
        <tr>
            <td>LSMGO (MT):</td>
            <td style="text-align: left;">{{ $recv->lsmgo ?? '' }}</td>
        </tr>
        <tr>
            <td>ME CC OIL (LITRES):</td>
            <td style="text-align: left;">{{ $recv->me_cc_oil ?? '' }}</td>
        </tr>
        <tr>
            <td>MC CYL OIL (LITRES):</td>
            <td style="text-align: left;">{{ $recv->mc_cyl_oil ?? '' }}</td>
        </tr>
        <tr>
            <td>GE CC OIL (LITRES):</td>
            <td style="text-align: left;">{{ $recv->ge_cc_oil ?? '' }}</td>
        </tr>
        <tr>
            <td>FW (MT):</td>
            <td style="text-align: left;">{{ $recv->fw ?? '' }}</td>
        </tr>
        <tr>
            <td>FW Produced (MT):</td>
            <td style="text-align: left;">{{ $recv->fw_produced ?? '' }}</td>
        </tr>

        <tr>
            <td colspan="7"></td>
        </tr>

        {{-- Consumption --}}
        <tr>
            <td colspan="2" style="font-weight: bold;">Consumption</td>
        </tr>
        <tr>
            <td>HSFO (MT):</td>
            <td style="text-align: left;">{{ $cons->hsfo ?? '' }}</td>
        </tr>
        <tr>
            <td>VLSFO (MT):</td>
            <td style="text-align: left;">{{ $cons->vlsfo ?? '' }}</td>
        </tr>
        <tr>
            <td>BIOFUEL (MT):</td>
            <td style="text-align: left;">{{ $cons->biofuel ?? '' }}</td>
        </tr>
        <tr>
            <td>LSMGO (MT):</td>
            <td style="text-align: left;">{{ $cons->lsmgo ?? '' }}</td>
        </tr>
        <tr>
            <td>ME CC OIL (LITRES):</td>
            <td style="text-align: left;">{{ $cons->me_cc_oil ?? '' }}</td>
        </tr>
        <tr>
            <td>MC CYL OIL (LITRES):</td>
            <td style="text-align: left;">{{ $cons->mc_cyl_oil ?? '' }}</td>
        </tr>
        <tr>
            <td>GE CC OIL (LITRES):</td>
            <td style="text-align: left;">{{ $cons->ge_cc_oil ?? '' }}</td>
        </tr>
        <tr>
            <td>FW (MT):</td>
            <td style="text-align: left;">{{ $cons->fw ?? '' }}</td>
        </tr>
        <tr>
            <td>FW Produced (MT):</td>
            <td style="text-align: left;">{{ $cons->fw_produced ?? '' }}</td>
        </tr>

        <tr>
            <td colspan="7"></td>
        </tr>

        {{-- Remarks --}}
        <tr>
            <td colspan="2" style="font-weight: bold;">Remarks</td>
        </tr>
        <tr>
            <td>Remarks:</td>
            <td style="text-align: left;">{{ $report->remarks->remarks ?? '' }}</td>
        </tr>

        <tr>
            <td colspan="7"></td>
        </tr>

        {{-- Master Information --}}
        <tr>
            <td colspan="2" style="font-weight: bold;">Master Information</td>
        </tr>
        <tr>
            <td>Master’s Info:</td>
            <td style="text-align: left;">{{ $report->master_info->master_info ?? '' }}</td>
        </tr>
    </table>

    <br><br>
@endforeach
