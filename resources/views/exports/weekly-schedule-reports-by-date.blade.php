<table border="1" cellspacing="0" cellpadding="4" style="border-collapse: collapse; width: 100%;">
    <thead>
        @php
            $headers = [
                'Vessel Name', 'Voyage No', 'Date',
                'Port', 'Activity', 'ETA/ETB', 'ETCD',
                'Cargo', 'Cargo Qty', 'Remarks',
                'Name', 'Address', 'PIC', 'Phone', 'Mobile', 'Email',
                'Remarks', 'Master Information',
            ];
        @endphp

        <tr>
            @foreach ($headers as $header)
                <th style="width: 250px;"><strong>{{ $header }}</strong></th>
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
                    <td colspan="18" style="height: 15px;"></td> {{-- Spacer row --}}
                </tr>
            @endif

            @foreach ($ports as $port)
                @php
                    $agents = $port->agents ?? [];
                    $agentCount = count($agents) ?: 1;
                    $firstAgent = true;
                @endphp

                @for ($i = 0; $i < $agentCount; $i++)
                    @php
                        $agent = $agents[$i] ?? null;
                    @endphp

                    <tr>
                        {{-- Report-level (show only on first agent row per port) --}}
                        <td style="text-align: left;">{{ $firstAgent ? ($vessel->name ?? '') : '' }}</td>
                        <td style="text-align: left;">{{ $firstAgent ? ($report->voyage_no ?? '') : '' }}</td>
                        <td style="text-align: left;">{{ $firstAgent ? $reportDate : '' }}</td>

                        {{-- Port-level --}}
                        <td style="text-align: left;">{{ $firstAgent ? ($port->port ?? '') : '' }}</td>
                        <td style="text-align: left;">{{ $firstAgent ? ($port->activity ?? '') : '' }}</td>
                        <td style="text-align: left;">{{ $firstAgent ? ($port->eta_etb ?? '') : '' }}</td>
                        <td style="text-align: left;">{{ $firstAgent ? ($port->etcd ?? '') : '' }}</td>
                        <td style="text-align: left;">{{ $firstAgent ? ($port->cargo ?? '') : '' }}</td>
                        <td style="text-align: left;">{{ $firstAgent ? ($port->cargo_qty ?? '') : '' }}</td>
                        <td style="text-align: left;">{{ $firstAgent ? ($port->remarks ?? '') : '' }}</td>

                        {{-- Agent-level --}}
                        <td style="text-align: left;">{{ $agent?->name ?? '' }}</td>
                        <td style="text-align: left;">{{ $agent?->address ?? '' }}</td>
                        <td style="text-align: left;">{{ $agent?->pic_name ?? '' }}</td>
                        <td style="text-align: left;">{{ $agent?->telephone ?? '' }}</td>
                        <td style="text-align: left;">{{ $agent?->mobile ?? '' }}</td>
                        <td style="text-align: left;">{{ $agent?->email ?? '' }}</td>

                        {{-- Footer --}}
                        <td style="text-align: left;">{{ $firstAgent ? $remarks : '' }}</td>
                        <td style="text-align: left;">{{ $firstAgent ? $master : '' }}</td>
                    </tr>

                    @php $firstAgent = false; @endphp
                @endfor
            @endforeach
        @endforeach
    </tbody>
</table>
