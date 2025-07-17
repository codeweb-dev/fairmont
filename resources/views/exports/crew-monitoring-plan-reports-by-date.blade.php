<table border="1" cellspacing="0" cellpadding="4" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            {{-- Board Crew headers --}}
            <th style="width: 250px; text-align: left;"><strong>No</strong></th>
            <th style="width: 250px; text-align: left;"><strong>Crew Surname</strong></th>
            <th style="width: 250px; text-align: left;"><strong>Crew First Name</strong></th>
            <th style="width: 250px; text-align: left;"><strong>Rank</strong></th>
            <th style="width: 250px; text-align: left;"><strong>Crew Nationality</strong></th>
            <th style="width: 250px; text-align: left;"><strong>Joining Date</strong></th>
            <th style="width: 250px; text-align: left;"><strong>Days to Contract Completion</strong></th>
            <th style="width: 250px; text-align: left;"><strong>Current Date</strong></th>
            <th style="width: 250px; text-align: left;"><strong>Date to Contract Completion</strong></th>
            <th style="width: 250px; text-align: left;"><strong>No of Months On Board</strong></th>

            {{-- Crew Change headers --}}
            <th style="width: 250px; text-align: left;"><strong>Port</strong></th>
            <th style="width: 250px; text-align: left;"><strong>Country</strong></th>
            <th style="width: 250px; text-align: left;"><strong>Date of Joiners Boarding</strong></th>
            <th style="width: 250px; text-align: left;"><strong>Date of Off-signers Sign Off</strong></th>
            <th style="width: 250px; text-align: left;"><strong>Joiners Ranks</strong></th>
            <th style="width: 250px; text-align: left;"><strong>Off-signers Ranks</strong></th>
            <th style="width: 250px; text-align: left;"><strong>Total Crew Change</strong></th>
            <th style="width: 250px; text-align: left;"><strong>Reason for Change</strong></th>
            <th style="width: 250px; text-align: left;"><strong>Remarks</strong></th>

            {{-- General --}}
            <th style="width: 250px; text-align: left;"><strong>Remarks</strong></th>
            <th style="width: 250px; text-align: left;"><strong>Master Information</strong></th>
        </tr>
    </thead>

    <tbody>
        @foreach ($reports as $report)
            @php
                $crewList = $report->board_crew ?? [];
                $changeList = $report->crew_change ?? [];
                $maxRows = max(count($crewList), count($changeList));
            @endphp

            @for ($i = 0; $i < $maxRows; $i++)
                @php
                    $crew = $crewList[$i] ?? null;
                    $change = $changeList[$i] ?? null;
                @endphp

                <tr>
                    {{-- Board Crew --}}
                    <td style="width: 250px; text-align: left;">{{ $crew->no ?? '' }}</td>
                    <td style="width: 250px; text-align: left;">{{ $crew->crew_surname ?? '' }}</td>
                    <td style="width: 250px; text-align: left;">{{ $crew->crew_first_name ?? '' }}</td>
                    <td style="width: 250px; text-align: left;">{{ $crew->rank ?? '' }}</td>
                    <td style="width: 250px; text-align: left;">{{ $crew->crew_nationality ?? '' }}</td>
                    <td style="width: 250px; text-align: left;">
                        {{ $crew?->joining_date ? \Carbon\Carbon::parse($crew->joining_date)->format('M d, Y h:i A') : '' }}
                    </td>
                    <td style="width: 250px; text-align: left;">{{ $crew->days_contract_completion ?? '' }}</td>
                    <td style="width: 250px; text-align: left;">
                        {{ $crew?->current_date ? \Carbon\Carbon::parse($crew->current_date)->format('M d, Y h:i A') : '' }}
                    </td>
                    <td style="width: 250px; text-align: left;">
                        {{ $crew?->contract_completion ? \Carbon\Carbon::parse($crew->contract_completion)->format('M d, Y h:i A') : '' }}
                    </td>
                    <td style="width: 250px; text-align: left;">{{ $crew->months_on_board ?? '' }}</td>

                    {{-- Crew Change --}}
                    <td style="width: 250px; text-align: left;">{{ $change->port ?? '' }}</td>
                    <td style="width: 250px; text-align: left;">{{ $change->country ?? '' }}</td>
                    <td style="width: 250px; text-align: left;">
                        {{ $change?->joiners_boarding ? \Carbon\Carbon::parse($change->joiners_boarding)->format('M d, Y h:i A') : '' }}
                    </td>
                    <td style="width: 250px; text-align: left;">
                        {{ $change?->off_signers ? \Carbon\Carbon::parse($change->off_signers)->format('M d, Y h:i A') : '' }}
                    </td>
                    <td style="width: 250px; text-align: left;">{{ $change->joiner_ranks ?? '' }}</td>
                    <td style="width: 250px; text-align: left;">{{ $change->off_signers_ranks ?? '' }}</td>
                    <td style="width: 250px; text-align: left;">{{ $change->total_crew_change ?? '' }}</td>
                    <td style="width: 250px; text-align: left;">{{ $change->reason_change ?? '' }}</td>
                    <td style="width: 250px; text-align: left;">{{ $change->remarks ?? '' }}</td>

                    {{-- General --}}
                    <td style="width: 250px; text-align: left;">
                        {{ $i === 0 ? ($report->remarks->remarks ?? '') : '' }}
                    </td>
                    <td style="width: 250px; text-align: left;">
                        {{ $i === 0 ? ($report->master_info->master_info ?? '') : '' }}
                    </td>
                </tr>
            @endfor
        @endforeach
    </tbody>
</table>
