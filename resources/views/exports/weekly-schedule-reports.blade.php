<table>
    {{-- Header: Schedule Details --}}
    <tr>
        <td colspan="7" style="font-weight: bold; width: 150px;">Schedule Details</td>
    </tr>
    <tr>
        <td style="width: 150px;"><strong>Vessel Name:</strong></td>
        <td colspan="6" style="width: 150px;">{{ $reports->first()->vessel->name ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td style="width: 150px;"><strong>Voyage No:</strong></td>
        <td colspan="6" style="width: 150px;">{{ $reports->first()->voyage_no ?? 'N/A' }}</td>
    </tr>
    <tr>
        <td style="width: 150px;"><strong>Date:</strong></td>
        <td colspan="6" style="width: 150px;">{{ \Carbon\Carbon::parse($reports->first()->all_fast_datetime)->format('M d, Y') }}</td>
    </tr>

    {{-- Space --}}
    <tr><td colspan="7"></td></tr>

    {{-- Header: Agent's Details --}}
    <tr>
        <td colspan="7" style="font-weight: bold; width: 150px;">Agent's Details</td>
    </tr>

    {{-- Port Info Table Header --}}
    <tr>
        <th style="border: 1px solid #000; width: 150px;">PORT</th>
        <th style="border: 1px solid #000; width: 150px;">ACTIVITY</th>
        <th style="border: 1px solid #000; width: 150px;">ETA/ETB</th>
        <th style="border: 1px solid #000; width: 150px;">ETCD</th>
        <th style="border: 1px solid #000; width: 150px;">CARGO</th>
        <th style="border: 1px solid #000; width: 150px;">CARGO QTY</th>
        <th style="border: 1px solid #000; width: 150px;">REMARKS</th>
    </tr>
    {{-- Port Info Rows --}}
    @foreach($reports as $report)
        @foreach($report->ports as $port)
            <tr>
                <td style="border: 1px solid #000; width: 150px;">{{ $port->port ?? 'N/A' }}</td>
                <td style="border: 1px solid #000; width: 150px;">{{ $port->activity ?? 'N/A' }}</td>
                <td style="border: 1px solid #000; width: 150px;">{{ $port->eta_etb ?? 'N/A' }}</td>
                <td style="border: 1px solid #000; width: 150px;">{{ $port->etcd ?? 'N/A' }}</td>
                <td style="border: 1px solid #000; width: 150px;">{{ $port->cargo ?? 'N/A' }}</td>
                <td style="border: 1px solid #000; width: 150px;">{{ $port->cargo_qty ?? 'N/A' }}</td>
                <td style="border: 1px solid #000; width: 150px;">{{ $port->remarks ?? 'N/A' }}</td>
            </tr>
        @endforeach
    @endforeach

    <tr><td colspan="7"></td></tr>

    {{-- Agent Contact Header --}}
    <tr>
        <td colspan="7" style="font-weight: bold; width: 150px;">Agent's Contact</td>
    </tr>
    <tr>
        <th style="border: 1px solid #000; width: 150px;">Agent's Name</th>
        <th style="border: 1px solid #000; width: 150px;">Address</th>
        <th style="border: 1px solid #000; width: 150px;">PIC Name</th>
        <th style="border: 1px solid #000; width: 150px;">Telephone</th>
        <th style="border: 1px solid #000; width: 150px;">Mobile</th>
        <th style="border: 1px solid #000; width: 150px;">Email</th>
        <th style="width: 150px;"></th>
    </tr>
    <tr>
        @php
            $agent = optional(optional($reports->first())->ports->first())->agents->first();
        @endphp
        <td style="border: 1px solid #000; width: 150px;">{{ $agent->name ?? 'N/A' }}</td>
        <td style="border: 1px solid #000; width: 150px;">{{ $agent->address ?? 'N/A' }}</td>
        <td style="border: 1px solid #000; width: 150px;">{{ $agent->pic_name ?? 'N/A' }}</td>
        <td style="border: 1px solid #000; width: 150px;">{{ $agent->telephone ?? 'N/A' }}</td>
        <td style="border: 1px solid #000; width: 150px;">{{ $agent->mobile ?? 'N/A' }}</td>
        <td style="border: 1px solid #000; width: 150px;">{{ $agent->email ?? 'N/A' }}</td>
        <td style="width: 150px;"></td>
    </tr>

    <tr><td colspan="7"></td></tr>

    {{-- Master's Info --}}
    <tr>
        <td colspan="7" style="font-weight: bold; width: 150px;">Master's Info</td>
    </tr>
    <tr>
        <td style="width: 150px;"><strong>Master's Name</strong></td>
        <td colspan="6" style="width: 150px;">{{ $report->master_info->master_info ?? 'N/A' }}</td>
    </tr>
</table>
