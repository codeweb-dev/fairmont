<table>
    <thead>
        <tr>
            <th>Vessel</th>
            <th>Unit</th>
            <th>Master's Info</th>
            <th>Type</th>

            {{-- Board Crew --}}
            <th>First Name</th>
            <th>Surname</th>
            <th>Rank</th>
            <th>Joining Date</th>
            <th>Contract Completion</th>

            {{-- Crew Change --}}
            <th>Port</th>
            <th>Country</th>
            <th>Joiners Boarding</th>
            <th>Off-signers</th>
            <th>Joiner Ranks</th>
            <th>Off-signer Ranks</th>
            <th>Total Crew Change</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reports as $report)
            @foreach($report->board_crew as $crew)
                <tr>
                    <td>{{ $report->vessel->name }}</td>
                    <td>{{ $report->unit->name }}</td>
                    <td>{{ $report->master_info->master_info ?? '-' }}</td>
                    <td>Board Crew</td>

                    {{-- Board Crew Details --}}
                    <td>{{ $crew->crew_first_name }}</td>
                    <td>{{ $crew->crew_surname }}</td>
                    <td>{{ $crew->rank }}</td>
                    <td>{{ $crew->joining_date }}</td>
                    <td>{{ $crew->contract_completion }}</td>

                    {{-- Empty Crew Change Columns --}}
                    <td colspan="7"></td>
                </tr>
            @endforeach

            @foreach($report->crew_change as $change)
                <tr>
                    <td>{{ $report->vessel->name }}</td>
                    <td>{{ $report->unit->name }}</td>
                    <td>{{ $report->master_info->master_info ?? '-' }}</td>
                    <td>Crew Change</td>

                    {{-- Empty Board Crew Columns --}}
                    <td colspan="5"></td>

                    {{-- Crew Change Details --}}
                    <td>{{ $change->port }}</td>
                    <td>{{ $change->country }}</td>
                    <td>{{ $change->joiners_boarding }}</td>
                    <td>{{ $change->off_signers }}</td>
                    <td>{{ $change->joiner_ranks }}</td>
                    <td>{{ $change->off_signer_ranks }}</td>
                    <td>{{ $change->total_crew_change }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
