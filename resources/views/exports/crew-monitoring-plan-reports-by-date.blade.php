<table border="1" cellspacing="0" cellpadding="4" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            {{-- Board Crew headers --}}
            <th style="width: 150px;">No</th>
            <th style="width: 150px;">Crew Surname</th>
            <th style="width: 150px;">Crew First Name</th>
            <th style="width: 150px;">Rank</th>
            <th style="width: 150px;">Crew Nationality</th>
            <th style="width: 150px;">Joining Date</th>
            <th style="width: 150px;">Days to Contract Completion</th>
            <th style="width: 150px;">Current Date</th>
            <th style="width: 150px;">Date to Contract Completion</th>
            <th style="width: 150px;">No of Months On Board</th>

            {{-- Crew Change headers --}}
            <th style="width: 150px;">Port</th>
            <th style="width: 150px;">Country</th>
            <th style="width: 150px;">Date of Joiners Boarding</th>
            <th style="width: 150px;">Date of Off-signers Sign Off</th>
            <th style="width: 150px;">Joiners Ranks</th>
            <th style="width: 150px;">Off-signers Ranks</th>
            <th style="width: 150px;">Total Crew Change</th>
            <th style="width: 150px;">Reason for Change</th>
            <th style="width: 150px;">Remarks</th>

            {{-- General --}}
            <th style="width: 150px;">Remarks</th>
            <th style="width: 150px;">Master Information</th>
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
                    {{-- Board Crew columns --}}
                    <td style="width: 150px;">{{ $crew->no ?? '' }}</td>
                    <td style="width: 150px;">{{ $crew->crew_surname ?? '' }}</td>
                    <td style="width: 150px;">{{ $crew->crew_first_name ?? '' }}</td>
                    <td style="width: 150px;">{{ $crew->rank ?? '' }}</td>
                    <td style="width: 150px;">{{ $crew->crew_nationality ?? '' }}</td>
                    <td style="width: 150px;">{{ $crew?->joining_date ? \Carbon\Carbon::parse($crew->joining_date)->format('M d, Y h:i A') : '' }}</td>
                    <td style="width: 150px;">{{ $crew->days_contract_completion ?? '' }}</td>
                    <td style="width: 150px;">{{ $crew?->current_date ? \Carbon\Carbon::parse($crew->current_date)->format('M d, Y h:i A') : '' }}</td>
                    <td style="width: 150px;">{{ $crew?->contract_completion ? \Carbon\Carbon::parse($crew->contract_completion)->format('M d, Y h:i A') : '' }}</td>
                    <td style="width: 150px;">{{ $crew->months_on_board ?? '' }}</td>

                    {{-- Crew Change columns --}}
                    <td style="width: 150px;">{{ $change->port ?? '' }}</td>
                    <td style="width: 150px;">{{ $change->country ?? '' }}</td>
                    <td style="width: 150px;">{{ $change?->joiners_boarding ? \Carbon\Carbon::parse($change->joiners_boarding)->format('M d, Y h:i A') : '' }}</td>
                    <td style="width: 150px;">{{ $change?->off_signers ? \Carbon\Carbon::parse($change->off_signers)->format('M d, Y h:i A') : '' }}</td>
                    <td style="width: 150px;">{{ $change->joiner_ranks ?? '' }}</td>
                    <td style="width: 150px;">{{ $change->off_signers_ranks ?? '' }}</td>
                    <td style="width: 150px;">{{ $change->total_crew_change ?? '' }}</td>
                    <td style="width: 150px;">{{ $change->reason_change ?? '' }}</td>
                    <td style="width: 150px;">{{ $change->remarks ?? '' }}</td>

                    {{-- General --}}
                    <td style="width: 150px;">{{ $report->remarks->remarks ?? '' }}</td>
                    <td style="width: 150px;">{{ $report->master_info->master_info ?? '' }}</td>
                </tr>
            @endfor
        @endforeach
    </tbody>
</table>
