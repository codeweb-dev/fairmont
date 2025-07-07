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
        <td style="width: 250px;"><strong>Vessel:</strong></td>
        <td colspan="4" style="width: 250px;">{{ $reports->first()->vessel->name ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td style="width: 250px;"><strong>Voyage No:</strong></td>
        <td colspan="4" style="width: 250px;">{{ $reports->first()->voyage_no ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td style="width: 250px;"><strong>All Fast Date/Time (LT):</strong></td>
        <td colspan="4" style="width: 250px;">
            {{ \Carbon\Carbon::parse($reports->first()->all_fast_datetime)->format('M d, Y h:i A') }}</td>
    </tr>
    <tr>
        <td style="width: 250px;"><strong>GMT Offset:</strong></td>
        <td colspan="4" style="width: 250px;">{{ $reports->first()->gmt_offset ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td style="width: 250px;"><strong>Port:</strong></td>
        <td colspan="4" style="width: 250px;">{{ $reports->first()->port ?? 'N/A' }}</td>
    </tr>

    {{-- Separator Row --}}
    <tr>
        <td colspan="5" style="height: 10px;"></td>
    </tr>

    {{-- Section: ROBs --}}
    <tr>
        <td colspan="5" style="font-weight: bold; width: 250px;">All Fast ROBs</td>
    </tr>
    <tr>
        <th style="border: 1px solid #000; width: 250px;">HSFO (MT)</th>
        <th style="border: 1px solid #000; width: 250px;">BIOFUEL (MT)</th>
        <th style="border: 1px solid #000; width: 250px;">VLSFO (MT)</th>
        <th style="border: 1px solid #000; width: 250px;">LSMGO (MT)</th>
    </tr>

    @foreach ($reports as $report)
        @foreach ($report->robs as $rob)
            <tr>
                <td style="border: 1px solid #000; width: 250px;">{{ $rob->hsfo ?? '' }}</td>
                <td style="border: 1px solid #000; width: 250px;">{{ $rob->biofuel ?? '' }}</td>
                <td style="border: 1px solid #000; width: 250px;">{{ $rob->vlsfo ?? '' }}</td>
                <td style="border: 1px solid #000; width: 250px;">{{ $rob->lsmgo ?? '' }}</td>
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
            <td>{{ $report->remarks->remarks ?? '' }}</td>
        </tr>
    @endif

    <tr colspan="2">
        <td></td>
    </tr>

    {{-- MASTER INFO --}}
    @if ($report->master_info)
        <tr>
            <td><strong>Master Information</strong></td>
            <td>{{ $report->master_info->master_info ?? '' }}</td>
        </tr>
    @endif
</table>
