@foreach ($reports as $report)
    <table>
        <thead>
            <tr>
                <th colspan="13"><strong>Crew Monitoring Plan Report Details</strong></th>
            </tr>
            <tr>
                <td colspan="13">
                </td>
            </tr>
        </thead>
        <tr>
            <td colspan="2" style="font-weight: bold;">General Info</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">Vessel Name</td>
            <td style="width: 250px; text-align: left;">{{ $report->vessel->name ?? '' }}</td>
        </tr>

        @if ($viewType === 'on-board' && $report->board_crew->isNotEmpty())
            @foreach ($report->board_crew as $i => $crew)
                <tr>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td colspan="2" style="font-weight: bold;">Board Crew {{ $i + 1 }}</td>
                </tr>
                <tr>
                    <td style="width: 250px; text-align: left;">No</td>
                    <td style="width: 250px; text-align: left;">{{ $crew->no ?? '' }}</td>
                </tr>
                <tr>
                    <td style="width: 250px; text-align: left;">Crew Surname</td>
                    <td style="width: 250px; text-align: left;">{{ $crew->crew_surname ?? '' }}</td>
                </tr>
                <tr>
                    <td style="width: 250px; text-align: left;">Crew First Name</td>
                    <td style="width: 250px; text-align: left;">{{ $crew->crew_first_name ?? '' }}</td>
                </tr>
                <tr>
                    <td style="width: 250px; text-align: left;">Rank</td>
                    <td style="width: 250px; text-align: left;">{{ $crew->rank ?? '' }}</td>
                </tr>
                <tr>
                    <td style="width: 250px; text-align: left;">Crew Nationality</td>
                    <td style="width: 250px; text-align: left;">{{ $crew->crew_nationality ?? '' }}</td>
                </tr>
                <tr>
                    <td style="width: 250px; text-align: left;">Joining Date</td>
                    <td style="width: 250px; text-align: left;">
                        {{ $crew->joining_date ? \Carbon\Carbon::parse($crew->joining_date)->format('M d, Y h:i A') : '' }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 250px; text-align: left;">Days to contract completion</td>
                    <td style="width: 250px; text-align: left;">
                        {{ $crew->contract_completion ? \Carbon\Carbon::parse($crew->contract_completion)->format('M d, Y h:i A') : '' }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 250px; text-align: left;">Current Date</td>
                    <td style="width: 250px; text-align: left;">
                        {{ $crew->current_date ? \Carbon\Carbon::parse($crew->current_date)->format('M d, Y h:i A') : '' }}
                    </td>
                </tr>
                <tr>
                    <td style="width: 250px; text-align: left;">Date to Contract Completion</td>
                    <td style="width: 250px; text-align: left;">{{ $crew->days_contract_completion ?? '' }}</td>
                </tr>
                <tr>
                    <td style="width: 250px; text-align: left;">No of Months On Board</td>
                    <td style="width: 250px; text-align: left;">{{ $crew->months_on_board ?? '' }}</td>
                </tr>
            @endforeach
        @endif

        @if ($viewType === 'crew-change')
            @if ($report->crew_change->isNotEmpty())
                @foreach ($report->crew_change as $i => $change)
                    <tr>
                        <td colspan="2"></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="font-weight: bold;">Crew Change {{ $i + 1 }}</td>
                    </tr>
                    <tr>
                        <td style="width: 250px; text-align: left;">Port</td>
                        <td style="width: 250px; text-align: left;">{{ $change->port ?? '' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 250px; text-align: left;">Country</td>
                        <td style="width: 250px; text-align: left;">{{ $change->country ?? '' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 250px; text-align: left;">Date of Joiners Boarding</td>
                        <td style="width: 250px; text-align: left;">
                            {{ $change->joiners_boarding ? \Carbon\Carbon::parse($change->joiners_boarding)->format('M d, Y h:i A') : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 250px; text-align: left;">Date of Off-signers Sign Off</td>
                        <td style="width: 250px; text-align: left;">
                            {{ $change->off_signers ? \Carbon\Carbon::parse($change->off_signers)->format('M d, Y h:i A') : '' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 250px; text-align: left;">Joiners Ranks</td>
                        <td style="width: 250px; text-align: left;">{{ $change->joiner_ranks ?? '' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 250px; text-align: left;">Off-Signers Ranks</td>
                        <td style="width: 250px; text-align: left;">{{ $change->off_signers_ranks ?? '' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 250px; text-align: left;">Total Crew Change</td>
                        <td style="width: 250px; text-align: left;">{{ $change->total_crew_change ?? '' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 250px; text-align: left;">Reason for Change</td>
                        <td style="width: 250px; text-align: left;">{{ $change->reason_change ?? '' }}</td>
                    </tr>
                    <tr>
                        <td style="width: 250px; text-align: left;">Remarks</td>
                        <td style="width: 250px; text-align: left;">{{ $change->remarks ?? '' }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="2" style="color: red; font-weight: bold;">No Crew Change Data Found (error display)
                    </td>
                </tr>
            @endif
        @endif

        <tr colspan="2">
            <td></td>
        </tr>

        {{-- REMARKS --}}
        @if ($report->remarks)
            <tr>
                <td><strong>Remarks</strong></td>
                <td style="width: 250px; text-align: left;">{{ $report->remarks->remarks ?? '' }}</td>
            </tr>
        @endif

        <tr colspan="2">
            <td></td>
        </tr>

        {{-- MASTER INFO --}}
        @if ($report->master_info)
            <tr>
                <td><strong>Master's Name</strong></td>
                <td style="width: 250px; text-align: left;">{{ $report->master_info->master_info ?? '' }}</td>
            </tr>
        @endif
    </table>
@endforeach
