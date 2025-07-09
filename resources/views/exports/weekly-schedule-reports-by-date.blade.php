<table border="1" cellspacing="0" cellpadding="4" style="border-collapse: collapse; width: 100%;">
    <thead>
        @php
            $headers = [
                // Report-level
                'Vessel Name', 'Voyage No', 'Date',

                // Port-level
                'Port', 'Activity', 'ETA/ETB', 'ETCD',
                'Cargo', 'Cargo Qty', 'Remarks',

                // Agent-level
                'Name', 'Address', 'PIC',
                'Phone', 'Mobile', 'Email',

                // Footer Info
                'Remarks', 'Master Information',
            ];
        @endphp

        <tr>
            @foreach ($headers as $header)
                <th style="width: 250px;">{{ $header }}</th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @foreach ($reports as $report)
            @php
                $vessel = $report->vessel ?? null;
                $ports = $report->ports ?? [];
                $remarks = $report->remarks->remarks ?? '';
                $master = $report->master_info->master_info ?? '';
                $reportDate = optional($report->all_fast_datetime) ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') : '';
            @endphp

            @if (!$loop->first)
                <tr>
                    <td colspan="11" style="height: 15px;"></td> {{-- Spacer row --}}
                </tr>
            @endif

            @foreach ($ports as $port)
                @php
                    $agents = $port->agents ?? [];
                    $agentCount = count($agents) ?: 1; // Show at least one row if empty
                @endphp

                @for ($i = 0; $i < $agentCount; $i++)
                    @php
                        $agent = $agents[$i] ?? null;
                    @endphp

                    <tr>
                        {{-- Report-level --}}
                        <td>{{ $vessel->name ?? '' }}</td>
                        <td>{{ $report->voyage_no ?? '' }}</td>
                        <td>{{ $reportDate }}</td>

                        {{-- Port-level --}}
                        <td>{{ $port->port ?? '' }}</td>
                        <td>{{ $port->activity ?? '' }}</td>
                        <td>{{ $port->eta_etb ?? '' }}</td>
                        <td>{{ $port->etcd ?? '' }}</td>
                        <td>{{ $port->cargo ?? '' }}</td>
                        <td>{{ $port->cargo_qty ?? '' }}</td>
                        <td>{{ $port->remarks ?? '' }}</td>

                        {{-- Agent-level --}}
                        <td>{{ $agent?->name ?? '' }}</td>
                        <td>{{ $agent?->address ?? '' }}</td>
                        <td>{{ $agent?->pic_name ?? '' }}</td>
                        <td>{{ $agent?->telephone ?? '' }}</td>
                        <td>{{ $agent?->mobile ?? '' }}</td>
                        <td>{{ $agent?->email ?? '' }}</td>

                        {{-- Footer --}}
                        <td>{{ $remarks }}</td>
                        <td>{{ $master }}</td>
                    </tr>
                @endfor
            @endforeach
        @endforeach
    </tbody>
</table>
