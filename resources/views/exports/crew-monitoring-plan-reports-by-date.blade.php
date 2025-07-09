<table border="1" cellspacing="0" cellpadding="4" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            @php
                $headers = [
                    'Vessel',

                    // Board Crew
                    'Board Crew No', 'Crew Surname', 'Crew First Name', 'Rank', 'Crew Nationality',
                    'Joining Date', 'Days to contract completion', 'Current Date',
                    'Date to Contract Completion', 'No of Months On Board',

                    // Crew Change
                    'Port', 'Country', 'Date of Joiners Boarding',
                    'Date of Off-signers Sign Off', 'Joiners Ranks', 'Off-signers Ranks',
                    'Total Crew Change', 'Reason for Change', 'Change Remarks',

                    // Report Remarks & Master Info
                    'Remarks', 'Master Information',
                ];
            @endphp

            @foreach ($headers as $header)
                <th style="width: 250px;">{{ $header }}</th>
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
                    {{-- General Info --}}
                    <td>{{ $report->vessel->name ?? 'N/A' }}</td>

                    {{-- Board Crew Info --}}
                    <td>{{ $crew?->no ?? '' }}</td>
                    <td>{{ $crew?->crew_surname ?? '' }}</td>
                    <td>{{ $crew?->crew_first_name ?? '' }}</td>
                    <td>{{ $crew?->rank ?? '' }}</td>
                    <td>{{ $crew?->crew_nationality ?? '' }}</td>
                    <td>{{ $crew?->joining_date ? \Carbon\Carbon::parse($crew->joining_date)->format('M d, Y h:i A') : '' }}</td>
                    <td>{{ $crew?->contract_completion ? \Carbon\Carbon::parse($crew->contract_completion)->format('M d, Y h:i A') : '' }}</td>
                    <td>{{ $crew?->current_date ? \Carbon\Carbon::parse($crew->current_date)->format('M d, Y h:i A') : '' }}</td>
                    <td>{{ $crew?->days_contract_completion ?? '' }}</td>
                    <td>{{ $crew?->months_on_board ?? '' }}</td>

                    {{-- Crew Change Info --}}
                    <td>{{ $change?->port ?? '' }}</td>
                    <td>{{ $change?->country ?? '' }}</td>
                    <td>{{ $change?->joiners_boarding ? \Carbon\Carbon::parse($change->joiners_boarding)->format('M d, Y h:i A') : '' }}</td>
                    <td>{{ $change?->off_signers ? \Carbon\Carbon::parse($change->off_signers)->format('M d, Y h:i A') : '' }}</td>
                    <td>{{ $change?->joiner_ranks ?? '' }}</td>
                    <td>{{ $change?->off_signer_ranks ?? '' }}</td>
                    <td>{{ $change?->total_crew_change ?? '' }}</td>
                    <td>{{ $change?->reason_change ?? '' }}</td>
                    <td>{{ $change?->remarks ?? '' }}</td>

                    {{-- Remarks and Master --}}
                    <td>{{ $report->remarks->remarks ?? '' }}</td>
                    <td>{{ $report->master_info->master_info ?? '' }}</td>
                </tr>
            @endfor
        @endforeach
    </tbody>
</table>
