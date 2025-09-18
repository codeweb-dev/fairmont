<table>
    <thead>
        <tr>
            <th colspan="13"><strong>All Fast Report Details</strong></th>
        </tr>

        <tr>
            <td colspan="13">
            </td>
        </tr>
    </thead>
    {{-- Header: Voyage Details --}}
    <tr>
        <td colspan="5" style="font-weight: bold; width: 250px;">Voyage Details</td>
    </tr>
    <tr>
        <td style="width: 250px;"><strong>Vessel Name:</strong></td>
        <td colspan="4" style="width: 250px; text-align: left;">{{ $reports->first()->vessel->name ?? '' }}</td>
    </tr>
    <tr>
        <td style="width: 250px;"><strong>Voyage No:</strong></td>
        <td colspan="4" style="width: 250px; text-align: left;">{{ $reports->first()->voyage_no ?? '' }}</td>
    </tr>
    <tr>
        <td style="width: 250px;"><strong>All Fast Date/Time (LT):</strong></td>
        <td colspan="4" style="width: 250px; text-align: left;">
            {{ \Carbon\Carbon::parse($reports->first()->all_fast_datetime)->format('M d, Y h:i A') }}</td>
    </tr>
    <tr>
        <td style="width: 250px;"><strong>GMT Offset:</strong></td>
        <td colspan="4" style="width: 250px; text-align: left;">{{ $reports->first()->gmt_offset ?? '' }}</td>
    </tr>
    <tr>
        <td style="width: 250px;"><strong>Port:</strong></td>
        <td colspan="4" style="width: 250px; text-align: left;">{{ $reports->first()->port ?? '' }}</td>
    </tr>

    {{-- Separator Row --}}
    <tr>
        <td colspan="5" style="height: 15px;"></td>
    </tr>

    {{-- Section: ROBs --}}
    <tr>
        <td colspan="8" style="font-weight: bold; width: 250px;">All Fast ROBs</td>
    </tr>
    <tr>
        <th style="border: 1px solid #000; width: 250px; text-align: center;"><strong>HSFO (MT)</strong></th>
        <th style="border: 1px solid #000; width: 250px; text-align: center;"><strong>BIOFUEL (MT)</strong></th>
        <th style="border: 1px solid #000; width: 250px; text-align: center;"><strong>VLSFO (MT)</strong></th>
        <th style="border: 1px solid #000; width: 250px; text-align: center;"><strong>LSFO (MT)</strong></th>
        <th style="border: 1px solid #000; width: 250px; text-align: center;"><strong>ULSFO (MT)</strong></th>
        <th style="border: 1px solid #000; width: 250px; text-align: center;"><strong>VLSMGO (MT)</strong></th>
        <th style="border: 1px solid #000; width: 250px; text-align: center;"><strong>LSMGO (MT)</strong></th>
        <th style="border: 1px solid #000; width: 250px; text-align: center;"><strong>ULSMGO (MT)</strong></th>
    </tr>

    @foreach ($reports as $report)
        @foreach ($report->robs as $rob)
            <tr>
                <td style="border: 1px solid #000; width: 250px; text-align: left;">{{ $rob->hsfo ?? '' }}</td>
                <td style="border: 1px solid #000; width: 250px; text-align: left;">{{ $rob->biofuel ?? '' }}</td>
                <td style="border: 1px solid #000; width: 250px; text-align: left;">{{ $rob->vlsfo ?? '' }}</td>
                <td style="border: 1px solid #000; width: 250px; text-align: left;">{{ $rob->lsfo ?? '' }}</td>
                <td style="border: 1px solid #000; width: 250px; text-align: left;">{{ $rob->ulsfo ?? '' }}</td>
                <td style="border: 1px solid #000; width: 250px; text-align: left;">{{ $rob->vlsmgo ?? '' }}</td>
                <td style="border: 1px solid #000; width: 250px; text-align: left;">{{ $rob->lsmgo ?? '' }}</td>
                <td style="border: 1px solid #000; width: 250px; text-align: left;">{{ $rob->ulsmgo ?? '' }}</td>
            </tr>
        @endforeach
    @endforeach

    <tr colspan="2">
        <td></td>
    </tr>

    {{-- REMARKS --}}
    @if ($report->remarks)
        <tr>
            <td><strong>Remarks</strong></td>
            <td style="text-align: left;">{{ $report->remarks->remarks ?? '' }}</td>
        </tr>
    @endif

    <tr colspan="2">
        <td></td>
    </tr>

    {{-- MASTER INFO --}}
    @if ($report->master_info)
        <tr>
            <td><strong>Master Information</strong></td>
            <td style="text-align: left;">{{ $report->master_info->master_info ?? '' }}</td>
        </tr>
    @endif
</table>
