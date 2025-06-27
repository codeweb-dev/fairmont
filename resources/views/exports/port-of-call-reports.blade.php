@foreach ($reports as $report)

    {{-- VESSEL DETAILS --}}
    <table>
        <tr>
            <td colspan="2" style="font-weight: bold; width:150px;">Vessel Details</td>
        </tr>
        <tr><td style="width:150px;">Vessel Name:</td><td>{{ e($report->vessel->name ?? '-') }}</td></tr>
        <tr><td>Call Sign:</td><td>{{ e($report->call_sign ?? '-') }}</td></tr>
        <tr><td>Flag:</td><td>{{ e($report->flag ?? '-') }}</td></tr>
        <tr><td>Port of Registry:</td><td>{{ e($report->port_of_registry ?? '-') }}</td></tr>
        <tr><td>Official Number:</td><td>{{ e($report->official_number ?? '-') }}</td></tr>
        <tr><td>IMO Number:</td><td>{{ e($report->imo_number ?? '-') }}</td></tr>
        <tr><td>Class Society:</td><td>{{ e($report->class_society ?? '-') }}</td></tr>
        <tr><td>Class No:</td><td>{{ e($report->class_no ?? '-') }}</td></tr>
        <tr><td>P&amp;I Club:</td><td>{{ e($report->pi_club ?? '-') }}</td></tr>
        <tr><td>LOA:</td><td>{{ e($report->loa ?? '-') }}</td></tr>
        <tr><td>LBP:</td><td>{{ e($report->lbp ?? '-') }}</td></tr>
        <tr><td>Breadth (Extreme):</td><td>{{ e($report->breadth_extreme ?? '-') }}</td></tr>
        <tr><td>Depth (Moulded):</td><td>{{ e($report->depth_moulded ?? '-') }}</td></tr>
        <tr><td>Height (Maximum):</td><td>{{ e($report->height_maximum ?? '-') }}</td></tr>
        <tr><td>Bridge Front Bow:</td><td>{{ e($report->bridge_front_bow ?? '-') }}</td></tr>
        <tr><td>Bridge Front Stern:</td><td>{{ e($report->bridge_front_stern ?? '-') }}</td></tr>
        <tr><td>Light Ship Displacement:</td><td>{{ e($report->light_ship_displacement ?? '-') }}</td></tr>
        <tr><td>Keel Laid:</td><td>{{ e($report->keel_laid ?? '-') }}</td></tr>
        <tr><td>Launched:</td><td>{{ e($report->launched ?? '-') }}</td></tr>
        <tr><td>Delivered:</td><td>{{ e($report->delivered ?? '-') }}</td></tr>
        <tr><td>Shipyard:</td><td>{{ e($report->shipyard ?? '-') }}</td></tr>
    </table>

    {{-- DELIVERABLES --}}
    <table>
        <tr><td colspan="2" style="font-weight: bold;">Deliverables</td></tr>
        <tr><td style="width:150px;">Voyage No:</td><td>{{ e($report->ports->first()->voyage_no ?? '-') }}</td></tr>
        <tr><td>Charterers:</td><td>{{ e($report->ports->first()->charterers ?? '-') }}</td></tr>
        <tr><td>Cargo:</td><td>{{ e($report->ports->first()->cargo ?? '-') }}</td></tr>
    </table>

    {{-- AGENTS + PORT OF CALLING --}}
    <table>
        <thead>
            <tr>
                <th colspan="10" style="font-weight: bold;">Port of Call Details</th>
            </tr>
            <tr>
                <th style="width:150px; border: 1px solid #000;">Port</th>
                <th style="width:150px; border: 1px solid #000;">Country</th>
                <th style="width:150px; border: 1px solid #000;">Purpose</th>
                <th style="width:150px; border: 1px solid #000;" colspan="2">ATA / ETA</th>
                <th style="width:150px; border: 1px solid #000;" colspan="2">Ship's Info</th>
                <th style="width:150px; border: 1px solid #000;">GMT</th>
                <th style="width:150px; border: 1px solid #000;">Duration</th>
                <th style="width:150px; border: 1px solid #000;">Total</th>
            </tr>
            <tr>
                <th colspan="3"></th>
                <th style="border: 1px solid #000;">Date</th>
                <th style="border: 1px solid #000;">Time</th>
                <th style="border: 1px solid #000;">Date</th>
                <th style="border: 1px solid #000;">Time</th>
                <th colspan="3"></th>
            </tr>
        </thead>
        <tbody>
            @foreach ($report->ports as $port)
                @forelse ($port->agents as $agent)
                    <tr>
                        <td style="border: 1px solid #000;">{{ e($agent->port_of_calling ?? '-') }}</td>
                        <td style="border: 1px solid #000;">{{ e($agent->country ?? '-') }}</td>
                        <td style="border: 1px solid #000;">{{ e($agent->purpose ?? '-') }}</td>
                        <td style="border: 1px solid #000;">{{ e($agent->ata_eta_date ?? '-') }}</td>
                        <td style="border: 1px solid #000;">{{ e($agent->ata_eta_time ?? '-') }}</td>
                        <td style="border: 1px solid #000;">{{ e($agent->ship_info_date ?? '-') }}</td>
                        <td style="border: 1px solid #000;">{{ e($agent->ship_info_time ?? '-') }}</td>
                        <td style="border: 1px solid #000;">{{ e($agent->gmt ?? '-') }}</td>
                        <td style="border: 1px solid #000;">{{ e($agent->duration_days ?? '-') }}</td>
                        <td style="border: 1px solid #000;">{{ e($agent->total_days ?? '-') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" style="text-align: center; border: 1px solid #000;">No agent info available</td>
                    </tr>
                @endforelse
            @endforeach
        </tbody>
    </table>

    {{-- MASTER INFO --}}
    <table>
        <tr>
            <td colspan="2" style="font-weight: bold;">Master's Info</td>
        </tr>
        <tr>
            <td style="width:150px;">Master's Name:</td>
            <td>{{ e($report->master_info->master_info ?? '-') }}</td>
        </tr>
    </table>

    <br><br>

@endforeach
