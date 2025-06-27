@foreach($reports as $report)
    <table border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse; width: 100%; margin-bottom: 30px;">
        <tr><td colspan="2" style="font-weight: bold;">General Info</td></tr>
        <tr><td style="width: 150px;">Vessel</td><td>{{ $report->vessel->name }}</td></tr>
        <tr><td style="width: 150px;">Unit</td><td>{{ $report->unit->name }}</td></tr>
        <tr><td style="width: 150px;">Master's Info</td><td>{{ $report->master_info->master_info ?? '-' }}</td></tr>

        @foreach($report->board_crew as $crew)
            <tr><td colspan="2"></td></tr>
            <tr><td colspan="2" style="font-weight: bold;">Board Crew</td></tr>
            <tr><td>First Name</td><td>{{ $crew->crew_first_name }}</td></tr>
            <tr><td>Surname</td><td>{{ $crew->crew_surname }}</td></tr>
            <tr><td>Rank</td><td>{{ $crew->rank }}</td></tr>
            <tr><td>Joining Date</td><td>{{ \Carbon\Carbon::parse($crew->joining_date)->format('M d, Y h:i A') }}</td></tr>
            <tr><td>Contract Completion</td><td>{{ \Carbon\Carbon::parse($crew->contract_completion)->format('M d, Y h:i A') }}</td></tr>
        @endforeach

        @foreach($report->crew_change as $change)
            <tr><td colspan="2"></td></tr>
            <tr><td colspan="2" style="font-weight: bold;">Crew Change</td></tr>
            <tr><td>Port</td><td>{{ $change->port }}</td></tr>
            <tr><td>Country</td><td>{{ $change->country }}</td></tr>
            <tr><td>Joiners Boarding</td><td>{{ \Carbon\Carbon::parse($change->joiners_boarding)->format('M d, Y h:i A') }}</td></tr>
            <tr><td>Off-signers</td><td>{{ \Carbon\Carbon::parse($change->off_signers)->format('M d, Y h:i A') }}</td></tr>
            <tr><td>Joiner Ranks</td><td>{{ $change->joiner_ranks }}</td></tr>
            <tr><td>Off-signer Ranks</td><td>{{ $change->off_signer_ranks }}</td></tr>
            <tr><td>Total Crew Change</td><td>{{ $change->total_crew_change }}</td></tr>
        @endforeach
    </table>
@endforeach
