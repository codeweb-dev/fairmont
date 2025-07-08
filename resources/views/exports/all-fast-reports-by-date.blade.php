<table border="1" cellspacing="0" cellpadding="4" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            @php
                $headers = [
                    'Vessel', 'Voyage No', 'All Fast Date/Time (LT)', 'GMT Offset', 'Port',
                    'HSFO (MT)', 'BIOFUEL (MT)', 'VLSFO (MT)', 'LSMGO (MT)',
                    'Remarks', 'Master Information'
                ];
            @endphp

            @foreach ($headers as $header)
                <th style="width: 250px;">{{ $header }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $report)
            @forelse ($report->robs as $rob)
                <tr>
                    {{-- Voyage Details --}}
                    <td>{{ $report->vessel->name ?? '' }}</td>
                    <td>{{ $report->voyage_no ?? '' }}</td>
                    <td>{{ $report->all_fast_datetime ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') : '' }}</td>
                    <td>{{ $report->gmt_offset ?? '' }}</td>
                    <td>{{ $report->port ?? '' }}</td>

                    {{-- ROBs --}}
                    <td>{{ $rob->hsfo ?? '' }}</td>
                    <td>{{ $rob->biofuel ?? '' }}</td>
                    <td>{{ $rob->vlsfo ?? '' }}</td>
                    <td>{{ $rob->lsmgo ?? '' }}</td>

                    {{-- Remarks & Master Info --}}
                    <td>{{ $report->remarks->remarks ?? '' }}</td>
                    <td>{{ $report->master_info->master_info ?? '' }}</td>
                </tr>
            @empty
                {{-- If no ROBs, still show the report row with N/A in ROBs --}}
                <tr>
                    <td>{{ $report->vessel->name ?? '' }}</td>
                    <td>{{ $report->voyage_no ?? '' }}</td>
                    <td>{{ $report->all_fast_datetime ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') : '' }}</td>
                    <td>{{ $report->gmt_offset ?? '' }}</td>
                    <td>{{ $report->port ?? '' }}</td>

                    <td colspan="4" style="text-align: center;">No ROB Data</td>

                    <td>{{ $report->remarks->remarks ?? '' }}</td>
                    <td>{{ $report->master_info->master_info ?? '' }}</td>
                </tr>
            @endforelse
        @endforeach
    </tbody>
</table>
