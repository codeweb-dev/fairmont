<table border="1" cellspacing="0" cellpadding="4" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            @php
                $headers = [
                    // Vessel Info
                    'Vessel Name',
                    'Call Sign',
                    'Flag',
                    'Port of Registry',
                    'Official Number',
                    'IMO Number',
                    'Class Society',
                    'Class No',
                    'P&I Club',
                    'LOA',
                    'LBP',
                    'Breadth',
                    'Depth',
                    'Height',
                    'Bridge Front Bow',
                    'Bridge Front Stern',
                    'Light Ship Displacement',
                    'Keel Laid',
                    'Launched',
                    'Delivered',
                    'Shipyard',

                    // Port/Deliverable
                    'Voyage No',
                    'Charterers',
                    'Cargo',

                    // Agent Info
                    'Port of Calling',
                    'Country',
                    'Purpose',
                    'ATA/ETA Date',
                    'ATA/ETA Time',
                    'Ship Info Date',
                    'Ship Info Time',
                    'GMT',
                    'Duration Days',
                    'Total Days',

                    // Remarks & Master
                    'Remarks',
                    'Master Information',
                ];
            @endphp

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
                $firstRowRendered = false;
            @endphp

            @if (!$loop->first)
                <tr><td colspan="60" style="height: 20px;"></td></tr> {{-- Spacer --}}
            @endif

            @foreach ($ports as $port)
                @php
                    $agents = $port->agents ?? [];
                    $agentCount = count($agents) ?: 1;
                @endphp

                @for ($i = 0; $i < $agentCount; $i++)
                    @php
                        $agent = $agents[$i] ?? null;
                    @endphp

                    <tr>
                        {{-- Vessel Info (only first row across the entire report) --}}
                        @if (!$firstRowRendered)
                            <td style="text-align: left;">{{ $vessel->name ?? '' }}</td>
                            <td style="text-align: left;">{{ $report->call_sign ?? '' }}</td>
                            <td style="text-align: left;">{{ $report->flag ?? '' }}</td>
                            <td style="text-align: left;">{{ $report->port_of_registry ?? '' }}</td>
                            <td style="text-align: left;">{{ $report->official_number ?? '' }}</td>
                            <td style="text-align: left;">{{ $report->imo_number ?? '' }}</td>
                            <td style="text-align: left;">{{ $report->class_society ?? '' }}</td>
                            <td style="text-align: left;">{{ $report->class_no ?? '' }}</td>
                            <td style="text-align: left;">{!! $report->pi_club ?? '' !!}</td>
                            <td style="text-align: left;">{{ $report->loa ?? '' }}</td>
                            <td style="text-align: left;">{{ $report->lbp ?? '' }}</td>
                            <td style="text-align: left;">{{ $report->breadth_extreme ?? '' }}</td>
                            <td style="text-align: left;">{{ $report->depth_moulded ?? '' }}</td>
                            <td style="text-align: left;">{{ $report->height_maximum ?? '' }}</td>
                            <td style="text-align: left;">{{ $report->bridge_front_bow ?? '' }}</td>
                            <td style="text-align: left;">{{ $report->bridge_front_stern ?? '' }}</td>
                            <td style="text-align: left;">{{ $report->light_ship_displacement ?? '' }}</td>
                            <td style="text-align: left;">
                                {{ $report->keel_laid ? \Carbon\Carbon::parse($report->keel_laid)->format('M d, Y h:i A') : '' }}
                            </td>
                            <td style="text-align: left;">
                                {{ $report->launched ? \Carbon\Carbon::parse($report->launched)->format('M d, Y h:i A') : '' }}
                            </td>
                            <td style="text-align: left;">
                                {{ $report->delivered ? \Carbon\Carbon::parse($report->delivered)->format('M d, Y h:i A') : '' }}
                            </td>
                            <td style="text-align: left;">{{ $report->shipyard ?? '' }}</td>
                        @else
                            {{-- Leave cells blank to maintain table structure --}}
                            @for ($j = 0; $j < 21; $j++)
                                <td></td>
                            @endfor
                        @endif

                        @if ($i === 0)
                            {{-- Port / Deliverable --}}
                            <td>{{ $port->voyage_no ?? '' }}</td>
                            <td>{{ $port->charterers ?? '' }}</td>
                            <td>{{ $port->cargo ?? '' }}</td>
                        @else
                            <td></td>
                            <td></td>
                            <td></td>
                        @endif

                        {{-- Agent Info --}}
                        <td style="text-align: left;">{{ $agent?->port_of_calling ?? '' }}</td>
                        <td style="text-align: left;">{{ $agent?->country ?? '' }}</td>
                        <td style="text-align: left;">{{ $agent?->purpose ?? '' }}</td>
                        <td style="text-align: left;">{{ $agent?->ata_eta_date ?? '' }}</td>
                        <td style="text-align: left;">{{ $agent?->ata_eta_time ?? '' }}</td>
                        <td style="text-align: left;">{{ $agent?->ship_info_date ?? '' }}</td>
                        <td style="text-align: left;">{{ $agent?->ship_info_time ?? '' }}</td>
                        <td style="text-align: left;">{{ $agent?->gmt ?? '' }}</td>
                        <td style="text-align: left;">{{ $agent?->duration_days ?? '' }}</td>
                        <td style="text-align: left;">{{ $agent?->total_days ?? '' }}</td>

                        {{-- Remarks & Master Info (only first row across the entire report) --}}
                        @if (!$firstRowRendered)
                            <td style="text-align: left;">{{ $report->remarks->remarks ?? '' }}</td>
                            <td style="text-align: left;">{{ $report->master_info->master_info ?? '' }}</td>
                            @php $firstRowRendered = true; @endphp
                        @else
                            <td></td>
                            <td></td>
                        @endif
                    </tr>
                @endfor
            @endforeach
        @endforeach
    </tbody>
</table>
