<table border="1" cellspacing="0" cellpadding="4" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            @if ($viewing === 'on-board')
                <th style="width: 250px; text-align: left;"><strong>No</strong></th>
                <th style="width: 250px; text-align: left;"><strong>Vessel Name</strong></th>
                <th style="width: 250px; text-align: left;"><strong>Crew Surname</strong></th>
                <th style="width: 250px; text-align: left;"><strong>Crew First Name</strong></th>
                <th style="width: 250px; text-align: left;"><strong>Rank</strong></th>
                <th style="width: 250px; text-align: left;"><strong>Crew Nationality</strong></th>
                <th style="width: 250px; text-align: left;"><strong>Joining Date</strong></th>
                <th style="width: 250px; text-align: left;"><strong>Days to Contract Completion</strong></th>
                <th style="width: 250px; text-align: left;"><strong>Current Date</strong></th>
                <th style="width: 250px; text-align: left;"><strong>Date to Contract Completion</strong></th>
                <th style="width: 250px; text-align: left;"><strong>No of Months On Board</strong></th>
            @elseif ($viewing === 'crew-change')
                <th style="width: 250px; text-align: left;"><strong>Vessel Name</strong></th>
                <th style="width: 250px; text-align: left;"><strong>Port</strong></th>
                <th style="width: 250px; text-align: left;"><strong>Country</strong></th>
                <th style="width: 250px; text-align: left;"><strong>Date of Joiners Boarding</strong></th>
                <th style="width: 250px; text-align: left;"><strong>Date of Off-signers Sign Off</strong></th>
                <th style="width: 250px; text-align: left;"><strong>Joiners Ranks</strong></th>
                <th style="width: 250px; text-align: left;"><strong>Off-signers Ranks</strong></th>
                <th style="width: 250px; text-align: left;"><strong>Total Crew Change</strong></th>
                <th style="width: 250px; text-align: left;"><strong>Reason for Change</strong></th>
                <th style="width: 250px; text-align: left;"><strong>Remarks</strong></th>
            @endif

            {{-- General columns always visible --}}
            <th style="width: 250px; text-align: left;"><strong>Remarks</strong></th>
            <th style="width: 250px; text-align: left;"><strong>Master Information</strong></th>
        </tr>
    </thead>

    <tbody>
        @foreach ($reports as $report)
            @if (!$loop->first)
                <tr>
                    <td colspan="60" style="height: 20px;"></td>
                </tr> {{-- Spacer --}}
            @endif

            @php
                $rows = $viewing === 'on-board' ? $report->board_crew : $report->crew_change;
            @endphp

            @foreach ($rows as $i => $item)
                <tr>
                    @if ($viewing === 'on-board')
                        <td style="width: 250px; text-align: left;">{{ $item->no }}</td>
                        <td style="width: 250px; text-align: left;">{{ $item->vessel_name }}</td>
                        <td style="width: 250px; text-align: left;">{{ $item->crew_surname }}</td>
                        <td style="width: 250px; text-align: left;">{{ $item->crew_first_name }}</td>
                        <td style="width: 250px; text-align: left;">{{ $item->rank }}</td>
                        <td style="width: 250px; text-align: left;">{{ $item->crew_nationality }}</td>
                        <td style="width: 250px; text-align: left;">
                            {{ $item->joining_date ? \Carbon\Carbon::parse($item->joining_date)->format('M d, Y h:i A') : '' }}
                        </td>
                        <td style="width: 250px; text-align: left;">{{ $item->days_contract_completion }}</td>
                        <td style="width: 250px; text-align: left;">
                            {{ $item->current_date ? \Carbon\Carbon::parse($item->current_date)->format('M d, Y h:i A') : '' }}
                        </td>
                        <td style="width: 250px; text-align: left;">
                            {{ $item->contract_completion ? \Carbon\Carbon::parse($item->contract_completion)->format('M d, Y h:i A') : '' }}
                        </td>
                        <td style="width: 250px; text-align: left;">{{ $item->months_on_board }}</td>
                    @elseif ($viewing === 'crew-change')
                        <td style="width: 250px; text-align: left;">{{ $item->vessel_name }}</td>
                        <td style="width: 250px; text-align: left;">{{ $item->port }}</td>
                        <td style="width: 250px; text-align: left;">{{ $item->country }}</td>
                        <td style="width: 250px; text-align: left;">
                            {{ $item->joiners_boarding ? \Carbon\Carbon::parse($item->joiners_boarding)->format('M d, Y h:i A') : '' }}
                        </td>
                        <td style="width: 250px; text-align: left;">
                            {{ $item->off_signers ? \Carbon\Carbon::parse($item->off_signers)->format('M d, Y h:i A') : '' }}
                        </td>
                        <td style="width: 250px; text-align: left;">{{ $item->joiner_ranks }}</td>
                        <td style="width: 250px; text-align: left;">{{ $item->off_signers_ranks }}</td>
                        <td style="width: 250px; text-align: left;">{{ $item->total_crew_change }}</td>
                        <td style="width: 250px; text-align: left;">{{ $item->reason_change }}</td>
                        <td style="width: 250px; text-align: left;">{{ $item->remarks }}</td>
                    @endif

                    {{-- General columns --}}
                    <td style="width: 250px; text-align: left;">{{ $i === 0 ? $report->remarks->remarks ?? '' : '' }}
                    </td>
                    <td style="width: 250px; text-align: left;">
                        {{ $i === 0 ? $report->master_info->master_info ?? '' : '' }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
