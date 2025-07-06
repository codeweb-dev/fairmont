@foreach($reports as $report)
    <table>
        <tr><td colspan="2" style="font-weight: bold;">General Info</td></tr>
        <tr><td style="width: 150px;">Vessel</td><td>{{ $report->vessel->name ?? '' }}</td></tr>
        <tr><td style="width: 150px;">Unit</td><td>{{ $report->unit->name ?? '' }}</td></tr>

        @foreach($report->board_crew as $i => $crew)
            <tr><td colspan="2"></td></tr>
            <tr><td colspan="2" style="font-weight: bold;">Board Crew {{ $i + 1}}</td></tr>
            <tr><td style="width: 150px;">No</td><td>{{ $crew->no ?? '' }}</td></tr>
            <tr><td style="width: 150px;">Crew Surname</td><td>{{ $crew->crew_surname ?? '' }}</td></tr>
            <tr><td style="width: 150px;">Crew First Name</td><td>{{ $crew->crew_first_name ?? '' }}</td></tr>
            <tr><td style="width: 150px;">Rank</td><td>{{ $crew->rank ?? '' }}</td></tr>
            <tr><td style="width: 150px;">Crew Nationality</td><td>{{ $crew->crew_nationality ?? '' }}</td></tr>
            <tr><td style="width: 150px;">Joining Date</td><td>{{ \Carbon\Carbon::parse($crew->joining_date)->format('M d, Y h:i A') }}</td></tr>
            <tr><td style="width: 150px;">Contract Completion</td><td>{{ \Carbon\Carbon::parse($crew->contract_completion)->format('M d, Y h:i A') }}</td></tr>
            <tr><td style="width: 150px;">Current Date</td><td>{{ \Carbon\Carbon::parse($crew->current_date)->format('M d, Y h:i A') }}</td></tr>
            <tr><td style="width: 150px;">Date to Contract Completion</td><td>{{ $crew->days_contract_completion ?? '' }}</td></tr>
            <tr><td style="width: 150px;">No of Months On Board</td><td>{{ $crew->months_on_board ?? '' }}</td></tr>
        @endforeach

        @foreach($report->crew_change as $i => $change)
            <tr><td colspan="2"></td></tr>
            <tr><td colspan="2" style="font-weight: bold;">Crew Change {{ $i + 1 }}</td></tr>
            <tr><td style="width: 150px;">Port</td><td>{{ $change->port ?? '' }}</td></tr>
            <tr><td style="width: 150px;">Country</td><td>{{ $change->country ?? '' }}</td></tr>
            <tr><td style="width: 150px;">Date of Joiners Boarding</td><td>{{ \Carbon\Carbon::parse($change->joiners_boarding)->format('M d, Y h:i A') }}</td></tr>
            <tr><td style="width: 150px;">Date of Off-signers Sign Off</td><td>{{ \Carbon\Carbon::parse($change->off_signers)->format('M d, Y h:i A') }}</td></tr>
            <tr><td style="width: 150px;">Joiners Ranks</td><td>{{ $change->joiner_ranks ?? '' }}</td></tr>
            <tr><td style="width: 150px;">Off-Signers Ranks</td><td>{{ $change->off_signer_ranks ?? '' }}</td></tr>
            <tr><td style="width: 150px;">Total Crew Change</td><td>{{ $change->total_crew_change ?? '' }}</td></tr>
            <tr><td style="width: 150px;">Reason for Change</td><td>{{ $change->reason_change ?? '' }}</td></tr>
            <tr><td style="width: 150px;">Remarks</td><td>{{ $change->remarks ?? '' }}</td></tr>
        @endforeach

        <tr><td colspan="2"></td></tr>
        <tr><td style="width: 150px;">Master Information</td><td>{{ $report->master_info->master_info ?? 'N/A' }}</td></tr>
    </table>
@endforeach
