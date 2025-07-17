<table>
    <tr>
        <td colspan="6" style="font-weight: bold;">Weekly Schedule Report Details</td>
    </tr>
    <tr>
        <td></td>
    </tr>

    <tr>
        <td style="width: 150px;"><strong>Vessel Name:</strong></td>
        <td colspan="1" style="width: 150px; text-align: left">{{ $reports->first()->vessel->name ?? '' }}</td>
    </tr>
    <tr>
        <td style="width: 150px;"><strong>Voyage No:</strong></td>
        <td colspan="1" style="width: 150px; text-align: left">{{ $reports->first()->voyage_no ?? '' }}</td>
    </tr>
    <tr>
        <td style="width: 150px;"><strong>Date:</strong></td>
        <td colspan="1" style="width: 150px; text-align: left">
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
                <td style="width: 150px; text-align: left"><strong>Activity</strong></td>
                <td style="width: 150px; text-align: left">{{ $port->activity ?? '' }}</td>
                <td style="width: 150px; text-align: left"><strong>ETA/ETB</strong></td>
                <td style="width: 150px; text-align: left">{{ $port->eta_etb ?? '' }}</td>
                <td style="width: 150px; text-align: left"><strong>ETCD</strong></td>
                <td style="width: 150px; text-align: left">{{ $port->etcd ?? '' }}</td>
            </tr>
            <tr>
                <td style="width: 150px; text-align: left"><strong>Cargo</strong></td>
                <td style="width: 150px; text-align: left">{{ $port->cargo ?? '' }}</td>
                <td style="width: 150px; text-align: left"><strong>Cargo Qty</strong></td>
                <td style="width: 150px; text-align: left">{{ $port->cargo_qty ?? '' }}</td>
                <td style="width: 150px; text-align: left"><strong>Remarks</strong></td>
                <td style="width: 150px; text-align: left">{{ $port->remarks ?? '' }}</td>
            </tr>

            {{-- Agents Header --}}
            <tr>
                <td colspan="6" style="font-weight: bold; width: 150px;">Agent(s)</td>
            </tr>
            <tr>
                <th style="border:1px solid #000; width: 150px; text-align: center;"><strong>Name</strong></th>
                <th style="border:1px solid #000; width: 150px; text-align: center;"><strong>Address</strong></th>
                <th style="border:1px solid #000; width: 150px; text-align: center;"><strong>PIC</strong></th>
                <th style="border:1px solid #000; width: 150px; text-align: center;"><strong>Phone</strong></th>
                <th style="border:1px solid #000; width: 150px; text-align: center;"><strong>Mobile</strong></th>
                <th style="border:1px solid #000; width: 150px; text-align: center;"><strong>Email</strong></th>
            </tr>

            @forelse($port->agents as $agent)
                <tr>
                    <td style="border:1px solid #000; width: 150px; text-align: left;">{{ $agent->name ?? '' }}</td>
                    <td style="border:1px solid #000; width: 150px; text-align: left;">{{ $agent->address ?? '' }}</td>
                    <td style="border:1px solid #000; width: 150px; text-align: left;">{{ $agent->pic_name ?? '' }}</td>
                    <td style="border:1px solid #000; width: 150px; text-align: left;">{{ $agent->telephone ?? '' }}</td>
                    <td style="border:1px solid #000; width: 150px; text-align: left;">{{ $agent->mobile ?? '' }}</td>
                    <td style="border:1px solid #000; width: 150px; text-align: left;">{{ $agent->email ?? '' }}</td>
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
            <td style="text-align: left;">{{ $report->remarks->remarks ?? '' }}</td>
        </tr>
    @endif

    <tr colspan="2">
        <td></td>
    </tr>

    {{-- MASTER INFO --}}
    @if ($report->master_info)
        <tr>
            <td><strong>Master's Name</strong></td>
            <td style="text-align: left;">{{ $report->master_info->master_info ?? '' }}</td>
        </tr>
    @endif
</table>
