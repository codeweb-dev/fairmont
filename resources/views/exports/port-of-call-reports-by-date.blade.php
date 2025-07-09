<table border="1" cellspacing="0" cellpadding="4" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            @php
                $headers = [
                    // Vessel Info
                    'Vessel Name', 'Call Sign', 'Flag', 'Port of Registry', 'Official Number', 'IMO Number',
                    'Class Society', 'Class No', 'P&I Club', 'LOA', 'LBP', 'Breadth', 'Depth', 'Height',
                    'Bridge Front Bow', 'Bridge Front Stern', 'Light Ship Displacement',
                    'Keel Laid', 'Launched', 'Delivered', 'Shipyard',

                    // Port/Deliverable
                    'Voyage No', 'Charterers', 'Cargo',

                    // Agent Info
                    'Agent Port', 'Agent Country', 'Agent Purpose',
                    'ATA/ETA Date', 'ATA/ETA Time', 'Ship Info Date', 'Ship Info Time',
                    'GMT', 'Duration Days', 'Total Days',

                    // Remarks & Master
                    'Remarks', 'Master Information',
                ];
            @endphp

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
            @endphp

            @if (!$loop->first)
                <tr>
                    <td colspan="11" style="height: 15px;"></td> {{-- Spacer row --}}
                </tr>
            @endif

            @foreach ($ports as $port)
                @php
                    $agents = $port->agents ?? [];
                    $agentCount = count($agents) ?: 1; // Show at least one row even if no agents
                @endphp

                @for ($i = 0; $i < $agentCount; $i++)
                    @php
                        $agent = $agents[$i] ?? null;
                    @endphp

                    <tr>
                        {{-- Vessel Info --}}
                        <td>{{ $vessel->name ?? '' }}</td>
                        <td>{{ $report->call_sign ?? '' }}</td>
                        <td>{{ $report->flag ?? '' }}</td>
                        <td>{{ $report->port_of_registry ?? '' }}</td>
                        <td>{{ $report->official_number ?? '' }}</td>
                        <td>{{ $report->imo_number ?? '' }}</td>
                        <td>{{ $report->class_society ?? '' }}</td>
                        <td>{{ $report->class_no ?? '' }}</td>
                        <td>{!! $report->pi_club ?? '' !!}</td>
                        <td>{{ $report->loa ?? '' }}</td>
                        <td>{{ $report->lbp ?? '' }}</td>
                        <td>{{ $report->breadth_extreme ?? '' }}</td>
                        <td>{{ $report->depth_moulded ?? '' }}</td>
                        <td>{{ $report->height_maximum ?? '' }}</td>
                        <td>{{ $report->bridge_front_bow ?? '' }}</td>
                        <td>{{ $report->bridge_front_stern ?? '' }}</td>
                        <td>{{ $report->light_ship_displacement ?? '' }}</td>
                        <td>{{ $report->keel_laid ? \Carbon\Carbon::parse($report->keel_laid)->format('M d, Y h:i A') : '' }}</td>
                        <td>{{ $report->launched ? \Carbon\Carbon::parse($report->launched)->format('M d, Y h:i A') : '' }}</td>
                        <td>{{ $report->delivered ? \Carbon\Carbon::parse($report->delivered)->format('M d, Y h:i A') : '' }}</td>
                        <td>{{ $report->shipyard ?? '' }}</td>

                        {{-- Port / Deliverable --}}
                        <td>{{ $port->voyage_no ?? '' }}</td>
                        <td>{{ $port->charterers ?? '' }}</td>
                        <td>{{ $port->cargo ?? '' }}</td>

                        {{-- Agent Info --}}
                        <td>{{ $agent?->port_of_calling ?? '' }}</td>
                        <td>{{ $agent?->country ?? '' }}</td>
                        <td>{{ $agent?->purpose ?? '' }}</td>
                        <td>{{ $agent?->ata_eta_date ?? '' }}</td>
                        <td>{{ $agent?->ata_eta_time ?? '' }}</td>
                        <td>{{ $agent?->ship_info_date ?? '' }}</td>
                        <td>{{ $agent?->ship_info_time ?? '' }}</td>
                        <td>{{ $agent?->gmt ?? '' }}</td>
                        <td>{{ $agent?->duration_days ?? '' }}</td>
                        <td>{{ $agent?->total_days ?? '' }}</td>

                        {{-- Remarks & Master Info --}}
                        <td>{{ $report->remarks->remarks ?? '' }}</td>
                        <td>{{ $report->master_info->master_info ?? '' }}</td>
                    </tr>
                @endfor
            @endforeach
        @endforeach
    </tbody>
</table>
