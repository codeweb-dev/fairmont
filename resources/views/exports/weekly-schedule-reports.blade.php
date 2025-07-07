<table>
    <tr>
        <td colspan="6" style="font-weight: bold;">Weekly Schedule Report Details</td>
    </tr>
    <tr>
        <td></td>
    </tr>

    {{-- Schedule Details --}}
    <tr>
        <td colspan="6" style="font-weight: bold; width: 150px;">Schedule Details</td>
    </tr>
    <tr>
        <td style="width: 150px;"><strong>Vessel Name:</strong></td>
        <td colspan="5" style="width: 150px;">{{ $reports->first()->vessel->name ?? '' }}</td>
    </tr>
    <tr>
        <td style="width: 150px;"><strong>Voyage No:</strong></td>
        <td colspan="5" style="width: 150px;">{{ $reports->first()->voyage_no ?? '' }}</td>
    </tr>
    <tr>
        <td style="width: 150px;"><strong>Date:</strong></td>
        <td colspan="5" style="width: 150px;">
            {{ optional($reports->first()->all_fast_datetime)
                ? \Carbon\Carbon::parse($reports->first()->all_fast_datetime)->format('M d, Y h:i A')
                : '' }}
        </td>
    </tr>

    <tr>
        <td colspan="6" style="height: 20px;"></td>
    </tr>

    {{-- Ports and Agents Grouped --}}
    @foreach ($reports as $report)
        @foreach ($report->ports as $i => $port)
            {{-- Port Info Header --}}
            <tr>
                <td colspan="6" style="font-weight: bold; width: 150px;">
                    Port {{ $i + 1 }} - {{ $port->port ?? '' }}
                </td>
            </tr>
            <tr>
                <td style="width: 150px;"><strong>Activity</strong></td>
                <td style="width: 150px;">{{ $port->activity ?? '' }}</td>
                <td style="width: 150px;"><strong>ETA/ETB</strong></td>
                <td style="width: 150px;">{{ $port->eta_etb ?? '' }}</td>
                <td style="width: 150px;"><strong>ETCD</strong></td>
                <td style="width: 150px;">{{ $port->etcd ?? '' }}</td>
            </tr>
            <tr>
                <td style="width: 150px;"><strong>Cargo</strong></td>
                <td style="width: 150px;">{{ $port->cargo ?? '' }}</td>
                <td style="width: 150px;"><strong>Cargo Qty</strong></td>
                <td style="width: 150px;">{{ $port->cargo_qty ?? '' }}</td>
                <td style="width: 150px;"><strong>Remarks</strong></td>
                <td style="width: 150px;">{{ $port->remarks ?? '' }}</td>
            </tr>

            {{-- Agents Header --}}
            <tr>
                <td colspan="6" style="font-weight: bold; width: 150px;">Agent(s)</td>
            </tr>
            <tr>
                <th style="border:1px solid #000; width: 150px;">Name</th>
                <th style="border:1px solid #000; width: 150px;">Address</th>
                <th style="border:1px solid #000; width: 150px;">PIC</th>
                <th style="border:1px solid #000; width: 150px;">Phone</th>
                <th style="border:1px solid #000; width: 150px;">Mobile</th>
                <th style="border:1px solid #000; width: 150px;">Email</th>
            </tr>

            @forelse($port->agents as $agent)
                <tr>
                    <td style="border:1px solid #000; width: 150px;">{{ $agent->name ?? '' }}</td>
                    <td style="border:1px solid #000; width: 150px;">{{ $agent->address ?? '' }}</td>
                    <td style="border:1px solid #000; width: 150px;">{{ $agent->pic_name ?? '' }}</td>
                    <td style="border:1px solid #000; width: 150px;">{{ $agent->telephone ?? '' }}</td>
                    <td style="border:1px solid #000; width: 150px;">{{ $agent->mobile ?? '' }}</td>
                    <td style="border:1px solid #000; width: 150px;">{{ $agent->email ?? '' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="width: 150px;">No agent data available</td>
                </tr>
            @endforelse
        @endforeach
    @endforeach

    <tr colspan="2">
        <td></td>
    </tr>

    {{-- REMARKS --}}
    @if ($report->remarks)
        <tr>
            <td><strong>Remarks</strong></td>
            <td>{{ $report->remarks->remarks ?? '' }}</td>
        </tr>
    @endif

    <tr colspan="2">
        <td></td>
    </tr>

    {{-- MASTER INFO --}}
    @if ($report->master_info)
        <tr>
            <td><strong>Master's Name</strong></td>
            <td>{{ $report->master_info->master_info ?? '' }}</td>
        </tr>
    @endif
</table>
