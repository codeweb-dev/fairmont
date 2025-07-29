<table border="1" cellspacing="0" cellpadding="4" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            @php
                $headers = [
                    'Vessel Name',
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
                    <td colspan="11" style="height: 20px;"></td> {{-- Spacer row --}}
                </tr>
            @endif

            @php $firstRob = true; @endphp

            @forelse ($report->robs as $rob)
                <tr>
                    {{-- Show details only on first ROB row --}}
                    <td style="text-align: left;">{{ $firstRob ? ($report->vessel->name ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstRob ? ($report->voyage_no ?? '') : '' }}</td>
                    <td style="text-align: left;">
                        @if ($firstRob)
                            {{ $report->all_fast_datetime ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') : '' }}
                        @endif
                    </td>
                    <td style="text-align: left;">{{ $firstRob ? ($report->gmt_offset ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstRob ? ($report->port ?? '') : '' }}</td>

                    {{-- ROBs --}}
                    <td style="text-align: left;">{{ $rob->hsfo ?? '' }}</td>
                    <td style="text-align: left;">{{ $rob->biofuel ?? '' }}</td>
                    <td style="text-align: left;">{{ $rob->vlsfo ?? '' }}</td>
                    <td style="text-align: left;">{{ $rob->lsmgo ?? '' }}</td>

                    {{-- Remarks & Master Info --}}
                    <td style="text-align: left;">{{ $firstRob ? ($report->remarks->remarks ?? '') : '' }}</td>
                    <td style="text-align: left;">{{ $firstRob ? ($report->master_info->master_info ?? '') : '' }}</td>
                </tr>

                @php $firstRob = false; @endphp
            @empty
                {{-- If no ROBs, still show the report row with N/A in ROBs --}}
                <tr>
                    <td style="text-align: left;">{{ $report->vessel->name ?? '' }}</td>
                    <td style="text-align: left;">{{ $report->voyage_no ?? '' }}</td>
                    <td style="text-align: left;">
                        {{ $report->all_fast_datetime ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') : '' }}
                    </td style="text-align: left;">
                    <td style="text-align: left;">{{ $report->gmt_offset ?? '' }}</td>
                    <td style="text-align: left;">{{ $report->port ?? '' }}</td>

                    <td colspan="4" style="text-align: center;">No ROB Data</td>

                    <td style="text-align: left;">{{ $report->remarks->remarks ?? '' }}</td>
                    <td style="text-align: left;">{{ $report->master_info->master_info ?? '' }}</td>
                </tr>
            @endforelse
        @endforeach
    </tbody>
</table>
