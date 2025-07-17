<table border="1" cellspacing="0" cellpadding="4" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            @php
                $headers = [
                    'Vessel',
                    'Voyage No',
                    'All Fast Date/Time (LT)',
                    'GMT Offset',
                    'Port',
                    'HSFO (MT)',
                    'BIOFUEL (MT)',
                    'VLSFO (MT)',
                    'LSMGO (MT)',
                    'Remarks',
                    'Master Information',
                ];
            @endphp

            @foreach ($headers as $header)
                <th style="width: 250px;"><strong>{{ $header }}</strong></th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $report)
            @if (!$loop->first)
                <tr>
                    <td colspan="11" style="height: 15px;"></td> {{-- Spacer row --}}
                </tr>
            @endif

            @php $firstRob = true; @endphp

            @forelse ($report->robs as $rob)
                <tr>
                    {{-- Show details only on first ROB row --}}
                    <td>{{ $firstRob ? ($report->vessel->name ?? '') : '' }}</td>
                    <td>{{ $firstRob ? ($report->voyage_no ?? '') : '' }}</td>
                    <td>
                        @if ($firstRob)
                            {{ $report->all_fast_datetime ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') : '' }}
                        @endif
                    </td>
                    <td>{{ $firstRob ? ($report->gmt_offset ?? '') : '' }}</td>
                    <td>{{ $firstRob ? ($report->port ?? '') : '' }}</td>

                    {{-- ROBs --}}
                    <td style="text-align: left;">{{ $rob->hsfo ?? '' }}</td>
                    <td style="text-align: left;">{{ $rob->biofuel ?? '' }}</td>
                    <td style="text-align: left;">{{ $rob->vlsfo ?? '' }}</td>
                    <td style="text-align: left;">{{ $rob->lsmgo ?? '' }}</td>

                    {{-- Remarks & Master Info --}}
                    <td>{{ $firstRob ? ($report->remarks->remarks ?? '') : '' }}</td>
                    <td>{{ $firstRob ? ($report->master_info->master_info ?? '') : '' }}</td>
                </tr>

                @php $firstRob = false; @endphp
            @empty
                {{-- If no ROBs, still show the report row with N/A in ROBs --}}
                <tr>
                    <td>{{ $report->vessel->name ?? '' }}</td>
                    <td>{{ $report->voyage_no ?? '' }}</td>
                    <td>
                        {{ $report->all_fast_datetime ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') : '' }}
                    </td>
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
