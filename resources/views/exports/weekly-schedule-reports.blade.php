<table>
    <thead>
        <tr>
            <th>Vessel</th>
            <th>Unit</th>
            <th>Voyage No</th>
            <th>All Fast Date</th>
            <th>Port</th>
            <th>Activity</th>
            <th>ETA/ETB</th>
            <th>ETCD</th>
            <th>Cargo</th>
            <th>Cargo Qty</th>
            <th>Port Remarks</th>
            <th>Agent Name</th>
            <th>Agent Email</th>
            <th>Master’s Info</th>
        </tr>
    </thead>
    <tbody>
        @foreach($reports as $report)
            @foreach($report->ports as $port)
                @php
                    $agents = $port->agents;
                    $agent = $agents->first(); // take first or loop all
                @endphp
                <tr>
                    <td>{{ $report->vessel->name ?? '-' }}</td>
                    <td>{{ $report->unit->name ?? '-' }}</td>
                    <td>{{ $report->voyage_no }}</td>
                    <td>{{ $report->all_fast_datetime }}</td>
                    <td>{{ $port->port }}</td>
                    <td>{{ $port->activity }}</td>
                    <td>{{ $port->eta_etb }}</td>
                    <td>{{ $port->etcd }}</td>
                    <td>{{ $port->cargo }}</td>
                    <td>{{ $port->cargo_qty }}</td>
                    <td>{{ $port->remarks }}</td>

                    <td>{{ $agent->name ?? '-' }}</td>
                    <td>{{ $agent->address ?? '-' }}</td>
                    <td>{{ $agent->pic_name ?? '-' }}</td>
                    <td>{{ $agent->telephone ?? '-' }}</td>
                    <td>{{ $agent->mobile ?? '-' }}</td>
                    <td>{{ $agent->email ?? '-' }}</td>
                    <td>{{ $report->master_info->master_info ?? '-' }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
