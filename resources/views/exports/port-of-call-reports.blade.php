@foreach ($reports as $report)
    {{-- VESSEL DETAILS --}}
    <table>
        <tr>
            <td colspan="6" style="font-weight: bold;">Port Of Call Report Details</td>
        </tr>
        <tr>
            <td></td>
        </tr>

        <tr>
            <td colspan="2" style="font-weight: bold;">Vessel Details</td>
        </tr>
        <tr>
            <td style="width: 250px;">Vessel Name:</td>
            <td style="text-align: left;">{{ e($report->vessel->name ?? '') }}</td>
        </tr>
        <tr>s
            <td>Call Sign:</td>
            <td style="text-align: left;">{{ e($report->call_sign ?? '') }}</td>
        </tr>
        <tr>
            <td>Flag:</td>
            <td style="text-align: left;">{{ e($report->flag ?? '-') }}</td>
        </tr>
        <tr>
            <td>Port of Registry:</td>
            <td style="text-align: left;">{{ e($report->port_of_registry ?? '') }}</td>
        </tr>
        <tr>
            <td>Official Number:</td>
            <td style="text-align: left;">{{ e($report->official_number ?? '') }}</td>
        </tr>
        <tr>
            <td>IMO Number:</td>
            <td style="text-align: left;">{{ e($report->imo_number ?? '') }}</td>
        </tr>
        <tr>
            <td>Class Society:</td>
            <td style="text-align: left;">{{ e($report->class_society ?? '') }}</td>
        </tr>
        <tr>
            <td>Class No:</td>
            <td style="text-align: left;">{{ e($report->class_no ?? '') }}</td>
        </tr>
        <tr>
            <td>P&amp;I Club:</td>
            <td style="text-align: left;">{{ html_entity_decode($report->pi_club ?? '') }}</td>
        </tr>
        <tr>
            <td>LOA (Length Overall):</td>
            <td style="text-align: left;">{{ e($report->loa ?? '') }}</td>
        </tr>
        <tr>
            <td>LBP (Length Between Perpendiculars):</td>
            <td style="text-align: left;">{{ e($report->lbp ?? '') }}</td>
        </tr>
        <tr>
            <td>Breadth (Extreme):</td>
            <td style="text-align: left;">{{ e($report->breadth_extreme ?? '') }}</td>
        </tr>
        <tr>
            <td>Depth (Moulded):</td>
            <td style="text-align: left;">{{ e($report->depth_moulded ?? '') }}</td>
        </tr>
        <tr>
            <td>Height (Maximum):</td>
            <td style="text-align: left;">{{ e($report->height_maximum ?? '') }}</td>
        </tr>
        <tr>
            <td>Bridge Front Bow:</td>
            <td style="text-align: left;">{{ e($report->bridge_front_bow ?? '') }}</td>
        </tr>
        <tr>
            <td>Bridge Front Stern:</td>
            <td style="text-align: left;">{{ e($report->bridge_front_stern ?? '') }}</td>
        </tr>
        <tr>
            <td>Light Ship Displacement:</td>
            <td style="text-align: left;">{{ e($report->light_ship_displacement ?? '') }}</td>
        </tr>
        <tr>
            <td>Keel Laid:</td>
            <td style="text-align: left;">
                {{ $report->keel_laid ? \Carbon\Carbon::parse($report->keel_laid)->format('M d, Y h:i A') : '' }}</td>
        </tr>
        <tr>
            <td>Launched:</td>
            <td style="text-align: left;">
                {{ $report->launched ? \Carbon\Carbon::parse($report->launched)->format('M d, Y h:i A') : '' }}</td>
        </tr>
        <tr>
            <td>Delivered:</td>
            <td style="text-align: left;">
                {{ $report->delivered ? \Carbon\Carbon::parse($report->delivered)->format('M d, Y h:i A') : '' }}</td>
        </tr>
        <tr>
            <td>Shipyard:</td>
            <td style="text-align: left;">{{ e($report->shipyard ?? '') }}</td>
        </tr>
    </table>

    {{-- DELIVERABLES + AGENTS PER PORT --}}
    @foreach ($report->ports as $index => $port)
        {{-- DELIVERABLE --}}
        <table>
            <tr>
                <td colspan="4" style="font-weight: bold;">Deliverable #{{ $index + 1 }}</td>
            </tr>
            <tr>
                <td style="width:250px;"><strong>Voyage No:</strong></td>
                <td style="text-align: left;">{{ e($port->voyage_no ?? '') }}</td>
            </tr>
            <tr>
                <td style="width:250px;"><strong>Charterers:</strong></td>
                <td style="text-align: left;">{{ e($port->charterers ?? '') }}</td>
            </tr>
            <tr>
                <td><strong>Cargo:</strong></td>
                <td style="text-align: left;">{{ e($port->cargo ?? '') }}</td>
            </tr>
        </table>

        {{-- AGENTS FOR THIS PORT --}}
        <table>
            <thead>
                <tr>
                    <th style="width: 250px; border: 1px solid #000; text-align: left;"><strong>Port of Calling</strong>
                    </th>
                    <th style="width: 250px; border: 1px solid #000; text-align: left;"><strong>Country</strong></th>
                    <th style="width: 250px; border: 1px solid #000; text-align: left;"><strong>Purpose</strong></th>
                    <th style="width: 250px; border: 1px solid #000; text-align: left;"><strong>ATA/ETA Date</strong>
                    </th>
                    <th style="width: 250px; border: 1px solid #000; text-align: left;"><strong>Ship Info Date</strong>
                    </th>
                    <th style="width: 250px; border: 1px solid #000; text-align: left;"><strong>GMT</strong></th>
                    <th style="width: 250px; border: 1px solid #000; text-align: left;"><strong>Duration</strong></th>
                    <th style="width: 250px; border: 1px solid #000; text-align: left;"><strong>Total</strong></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($port->agents as $agent)
                    <tr>
                        <td style="border: 1px solid #000; text-align: left;">{{ e($agent->port_of_calling ?? '') }}
                        </td>
                        <td style="border: 1px solid #000; text-align: left;">{{ e($agent->country ?? '') }}</td>
                        <td style="border: 1px solid #000; text-align: left;">{{ e($agent->purpose ?? '') }}</td>
                        <td style="border: 1px solid #000; text-align: left;">
                            {{ e($agent->ata_eta_date ? \Carbon\Carbon::parse($agent->ata_eta_date)->format('M d, Y h:i A') : '') }}
                        </td>
                        <td style="border: 1px solid #000; text-align: left;">
                            {{ e($agent->ship_info_date ? \Carbon\Carbon::parse($agent->ship_info_date)->format('M d, Y h:i A') : '') }}
                        </td>
                        <td style="border: 1px solid #000; text-align: left;">{{ e($agent->gmt ?? '') }}</td>
                        <td style="border: 1px solid #000; text-align: left;">{{ e($agent->duration_days ?? '') }}</td>
                        <td style="border: 1px solid #000; text-align: left;">{{ e($agent->total_days ?? '') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="10" style="text-align: center; border: 1px solid #000;">No agents available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    @endforeach

    {{-- REMARKS --}}
    <table>
        <tr>
            <td colspan="2" style="font-weight: bold;">Remarks</td>
        </tr>
        <tr>
            <td style="width: 250px;">Remarks:</td>
            <td style="width: 250px; text-align: left;">{{ $report->remarks->remarks ?? '' }}</td>
        </tr>
    </table>

    {{-- MASTER INFO --}}
    <table>
        <tr>
            <td colspan="2" style="font-weight: bold;">Master Information</td>
        </tr>
        <tr>
            <td style="width: 250px;">Master's Name:</td>
            <td style="width: 250px; text-align: left;">{{ e($report->master_info->master_info ?? '') }}</td>
        </tr>
    </table>
@endforeach
