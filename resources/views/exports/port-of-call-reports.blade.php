@foreach ($reports as $report)
    {{-- VESSEL DETAILS --}}
    <table>
        <tr><td colspan="2" style="font-weight: bold;">Vessel Details</td></tr>
        <tr><td style="width:150px;">Vessel Name:</td><td>{{ e($report->vessel->name ?? 'N/A') }}</td></tr>
        <tr><td>Call Sign:</td><td>{{ e($report->call_sign ?? 'N/A') }}</td></tr>
        <tr><td>Flag:</td><td>{{ e($report->flag ?? '-') }}</td></tr>
        <tr><td>Port of Registry:</td><td>{{ e($report->port_of_registry ?? 'N/A') }}</td></tr>
        <tr><td>Official Number:</td><td>{{ e($report->official_number ?? 'N/A') }}</td></tr>
        <tr><td>IMO Number:</td><td>{{ e($report->imo_number ?? 'N/A') }}</td></tr>
        <tr><td>Class Society:</td><td>{{ e($report->class_society ?? 'N/A') }}</td></tr>
        <tr><td>Class No:</td><td>{{ e($report->class_no ?? 'N/A') }}</td></tr>
        <tr><td>P&amp;I Club:</td><td>{{ html_entity_decode($report->pi_club ?? 'N/A') }}</td></tr>
        <tr><td>LOA:</td><td>{{ e($report->loa ?? 'N/A') }}</td></tr>
        <tr><td>LBP:</td><td>{{ e($report->lbp ?? 'N/A') }}</td></tr>
        <tr><td>Breadth (Extreme):</td><td>{{ e($report->breadth_extreme ?? 'N/A') }}</td></tr>
        <tr><td>Depth (Moulded):</td><td>{{ e($report->depth_moulded ?? 'N/A') }}</td></tr>
        <tr><td>Height (Maximum):</td><td>{{ e($report->height_maximum ?? 'N/A') }}</td></tr>
        <tr><td>Bridge Front Bow:</td><td>{{ e($report->bridge_front_bow ?? 'N/A') }}</td></tr>
        <tr><td>Bridge Front Stern:</td><td>{{ e($report->bridge_front_stern ?? 'N/A') }}</td></tr>
        <tr><td>Light Ship Displacement:</td><td>{{ e($report->light_ship_displacement ?? 'N/A') }}</td></tr>
        <tr><td>Keel Laid:</td><td>{{ e($report->keel_laid ?? 'N/A') }}</td></tr>
        <tr><td>Launched:</td><td>{{ e($report->launched ?? 'N/A') }}</td></tr>
        <tr><td>Delivered:</td><td>{{ e($report->delivered ?? 'N/A') }}</td></tr>
        <tr><td>Shipyard:</td><td>{{ e($report->shipyard ?? 'N/A') }}</td></tr>
    </table>

    {{-- DELIVERABLES + AGENTS PER PORT --}}
    @foreach ($report->ports as $index => $port)
        {{-- DELIVERABLE --}}
        <table>
            <tr><td colspan="4" style="font-weight: bold;">Deliverable #{{ $index + 1 }}</td></tr>
            <tr>
                <td style="width:150px;">Voyage No:</td>
                <td>{{ e($port->voyage_no ?? 'N/A') }}</td>
                <td style="width:150px;">Charterers:</td>
                <td>{{ e($port->charterers ?? 'N/A') }}</td>
            </tr>
            <tr>
                <td>Cargo:</td>
                <td>{{ e($port->cargo ?? 'N/A') }}</td>
            </tr>
        </table>

        {{-- AGENTS FOR THIS PORT --}}
        <table>
            <thead>
                <tr>
                    <th colspan="10" style="font-weight: bold;">Agents for Deliverable #{{ $index + 1 }}</th>
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
                @forelse ($port->agents as $agent)
                    <tr>
                        <td style="border: 1px solid #000;">{{ e($agent->port_of_calling ?? 'N/A') }}</td>
                        <td style="border: 1px solid #000;">{{ e($agent->country ?? 'N/A') }}</td>
                        <td style="border: 1px solid #000;">{{ e($agent->purpose ?? 'N/A') }}</td>
                        <td style="border: 1px solid #000;">{{ e($agent->ata_eta_date ?? 'N/A') }}</td>
                        <td style="border: 1px solid #000;">{{ e($agent->ata_eta_time ?? 'N/A') }}</td>
                        <td style="border: 1px solid #000;">{{ e($agent->ship_info_date ?? 'N/A') }}</td>
                        <td style="border: 1px solid #000;">{{ e($agent->ship_info_time ?? 'N/A') }}</td>
                        <td style="border: 1px solid #000;">{{ e($agent->gmt ?? 'N/A') }}</td>
                        <td style="border: 1px solid #000;">{{ e($agent->duration_days ?? 'N/A') }}</td>
                        <td style="border: 1px solid #000;">{{ e($agent->total_days ?? 'N/A') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" style="text-align: center; border: 1px solid #000;">No agents available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <br>
    @endforeach

    {{-- REMARKS --}}
    <table>
        <tr><td colspan="2" style="font-weight: bold;">Remarks</td></tr>
        <tr>
            <td style="width:150px;">Remarks:</td>
            <td style="width: 250px;">{{ $report->remarks->remarks ?? 'N/A' }}</td>
        </tr>
    </table>

    {{-- MASTER INFO --}}
    <table>
        <tr><td colspan="2" style="font-weight: bold;">Master Information</td></tr>
        <tr>
            <td style="width:150px;">Master's Name:</td>
            <td>{{ e($report->master_info->master_info ?? 'N/A') }}</td>
        </tr>
    </table>
@endforeach
