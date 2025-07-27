<table border="1" cellspacing="0" cellpadding="4" style="border-collapse: collapse; width: 100%;">
    <thead>
        @php
            $headers = [
                'Vessel Name',
                'Voyage No',
                'Date',
                'Port',
                'Activity',
                'ETA/ETB',
                'ETCD',
                'Cargo',
                'Cargo Qty',
                'Remarks',
                'Name',
                'Address',
                'PIC',
                'Phone',
                'Mobile',
                'Email',
                'Remarks',
                'Master Information',
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
                $reportDate = optional($report->all_fast_datetime)
                    ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A')
                    : '';
                $isFirstRow = true;
            @endphp

            @foreach ($ports as $port)
                @php
                    $agents = $port->agents ?? [];
                    $agentCount = count($agents) ?: 1;
                    $firstAgentRow = true;
                @endphp

                @if (!$loop->first)
                    <tr>
                        <td colspan="60" style="height: 20px;"></td>
                    </tr> {{-- Spacer --}}
                @endif

                @for ($i = 0; $i < $agentCount; $i++)
                    @php $agent = $agents[$i] ?? null; @endphp

                    <tr>
                        {{-- Report-level: only on first row --}}
                        <td style="text-align: left;">{{ $isFirstRow ? $vessel->name ?? '' : '' }}</td>
                        <td style="text-align: left;">{{ $isFirstRow ? $report->voyage_no ?? '' : '' }}</td>
                        <td style="text-align: left;">{{ $isFirstRow ? $reportDate : '' }}</td>

                        {{-- Port-level: only on first agent row of the port --}}
                        <td style="text-align: left;">{{ $firstAgentRow ? $port->port ?? '' : '' }}</td>
                        <td style="text-align: left;">{{ $firstAgentRow ? $port->activity ?? '' : '' }}</td>
                        <td style="text-align: left;">{{ $firstAgentRow ? $port->eta_etb ?? '' : '' }}</td>
                        <td style="text-align: left;">{{ $firstAgentRow ? $port->etcd ?? '' : '' }}</td>
                        <td style="text-align: left;">{{ $firstAgentRow ? $port->cargo ?? '' : '' }}</td>
                        <td style="text-align: left;">{{ $firstAgentRow ? $port->cargo_qty ?? '' : '' }}</td>
                        <td style="text-align: left;">{{ $firstAgentRow ? $port->remarks ?? '' : '' }}</td>

                        {{-- Agent-level --}}
                        <td style="text-align: left;">{{ $agent?->name ?? '' }}</td>
                        <td style="text-align: left;">{{ $agent?->address ?? '' }}</td>
                        <td style="text-align: left;">{{ $agent?->pic_name ?? '' }}</td>
                        <td style="text-align: left;">{{ $agent?->telephone ?? '' }}</td>
                        <td style="text-align: left;">{{ $agent?->mobile ?? '' }}</td>
                        <td style="text-align: left;">{{ $agent?->email ?? '' }}</td>

                        {{-- Footer: only on first overall row --}}
                        <td style="text-align: left;">{{ $isFirstRow ? $remarks : '' }}</td>
                        <td style="text-align: left;">{{ $isFirstRow ? $master : '' }}</td>
                    </tr>

                    @php
                        $isFirstRow = false;
                        $firstAgentRow = false;
                    @endphp
                @endfor
            @endforeach
        @endforeach
    </tbody>
</table>
