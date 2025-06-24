<table>
    <thead>
        <tr>
            <th>Vessel</th>
            <th>Unit</th>
            <th>Call Sign</th>
            <th>Flag</th>
            <th>Port Registry</th>
            <th>Official Number</th>
            <th>IMO Number</th>
            <th>Class Society</th>
            <th>Class No</th>
            <th>P&amp;I Club</th>
            <th>LOA</th>
            <th>LBP</th>
            <th>Breadth (Extreme)</th>
            <th>Depth (Moulded)</th>
            <th>Height (Maximum)</th>
            <th>Bridge Front Bow</th>
            <th>Bridge Front Stern</th>
            <th>Light Ship Displacement</th>
            <th>Keel Laid</th>
            <th>Launched</th>
            <th>Delivered</th>
            <th>Shipyard</th>
            <th>Master Info</th>
            <th>Voyage No</th>
            <th>Cargo</th>
            <th>Charterers</th>
            <th>Agent: Port of Calling</th>
            <th>Agent: Country</th>
            <th>Agent: Purpose</th>
            <th>Agent: ATA/ETA Date</th>
            <th>Agent: ATA/ETA Time</th>
            <th>Agent: Duration (Days)</th>
            <th>Agent: Total (Days)</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $report)
            @foreach ($report->ports as $port)
                @if ($port->agents->isEmpty())
                    <tr>
                        <td>{{ e($report->vessel->name ?? '-') }}</td>
                        <td>{{ e($report->unit->name ?? '-') }}</td>
                        <td>{{ e($report->call_sign ?? '-') }}</td>
                        <td>{{ e($report->flag ?? '-') }}</td>
                        <td>{{ e($report->port_of_registry ?? '-') }}</td>
                        <td>{{ e($report->official_number ?? '-') }}</td>
                        <td>{{ e($report->imo_number ?? '-') }}</td>
                        <td>{{ e($report->class_society ?? '-') }}</td>
                        <td>{{ e($report->class_no ?? '-') }}</td>
                        <td>{{ e($report->pi_club ?? '-') }}</td>
                        <td>{{ e($report->loa ?? '-') }}</td>
                        <td>{{ e($report->lbp ?? '-') }}</td>
                        <td>{{ e($report->breadth_extreme ?? '-') }}</td>
                        <td>{{ e($report->depth_moulded ?? '-') }}</td>
                        <td>{{ e($report->height_maximum ?? '-') }}</td>
                        <td>{{ e($report->bridge_front_bow ?? '-') }}</td>
                        <td>{{ e($report->bridge_front_stern ?? '-') }}</td>
                        <td>{{ e($report->light_ship_displacement ?? '-') }}</td>
                        <td>{{ e($report->keel_laid ?? '-') }}</td>
                        <td>{{ e($report->launched ?? '-') }}</td>
                        <td>{{ e($report->delivered ?? '-') }}</td>
                        <td>{{ e($report->shipyard ?? '-') }}</td>
                        <td>{{ e($report->master_info->master_info ?? '-') }}</td>
                        <td>{{ e($port->voyage_no ?? '-') }}</td>
                        <td>{{ e($port->cargo ?? '-') }}</td>
                        <td>{{ e($port->charterers ?? '-') }}</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                        <td>-</td>
                    </tr>
                @else
                    @foreach ($port->agents as $agent)
                        <tr>
                            <td>{{ e($report->vessel->name ?? '-') }}</td>
                            <td>{{ e($report->unit->name ?? '-') }}</td>
                            <td>{{ e($report->call_sign ?? '-') }}</td>
                            <td>{{ e($report->flag ?? '-') }}</td>
                            <td>{{ e($report->port_of_registry ?? '-') }}</td>
                            <td>{{ e($report->official_number ?? '-') }}</td>
                            <td>{{ e($report->imo_number ?? '-') }}</td>
                            <td>{{ e($report->class_society ?? '-') }}</td>
                            <td>{{ e($report->class_no ?? '-') }}</td>
                            <td>{{ e($report->pi_club ?? '-') }}</td>
                            <td>{{ e($report->loa ?? '-') }}</td>
                            <td>{{ e($report->lbp ?? '-') }}</td>
                            <td>{{ e($report->breadth_extreme ?? '-') }}</td>
                            <td>{{ e($report->depth_moulded ?? '-') }}</td>
                            <td>{{ e($report->height_maximum ?? '-') }}</td>
                            <td>{{ e($report->bridge_front_bow ?? '-') }}</td>
                            <td>{{ e($report->bridge_front_stern ?? '-') }}</td>
                            <td>{{ e($report->light_ship_displacement ?? '-') }}</td>
                            <td>{{ e($report->keel_laid ?? '-') }}</td>
                            <td>{{ e($report->launched ?? '-') }}</td>
                            <td>{{ e($report->delivered ?? '-') }}</td>
                            <td>{{ e($report->shipyard ?? '-') }}</td>
                            <td>{{ e($report->master_info->master_info ?? '-') }}</td>
                            <td>{{ e($port->voyage_no ?? '-') }}</td>
                            <td>{{ e($port->cargo ?? '-') }}</td>
                            <td>{{ e($port->charterers ?? '-') }}</td>
                            <td>{{ e($agent->port_of_calling ?? '-') }}</td>
                            <td>{{ e($agent->country ?? '-') }}</td>
                            <td>{{ e($agent->purpose ?? '-') }}</td>
                            <td>{{ e($agent->ata_eta_date ?? '-') }}</td>
                            <td>{{ e($agent->ata_eta_time ?? '-') }}</td>
                            <td>{{ e($agent->duration_days ?? '-') }}</td>
                            <td>{{ e($agent->total_days ?? '-') }}</td>
                        </tr>
                    @endforeach
                @endif
            @endforeach
        @endforeach
    </tbody>
</table>
