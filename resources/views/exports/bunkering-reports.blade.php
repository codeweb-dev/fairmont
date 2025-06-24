<table>
    <thead>
        <tr>
            <th>Report Type</th>
            <th>Vessel</th>
            <th>Unit</th>
            <th>Voyage No</th>
            <th>Bunkering Port</th>
            <th>Supplier</th>
            <th>Port ETD (LT)</th>
            <th>Port GMT Offset</th>
            <th>Bunker Completed (LT)</th>
            <th>Bunker GMT Offset</th>

            <th>HSFO (MT)</th>
            <th>HSFO Viscosity</th>
            <th>BIOFUEL (MT)</th>
            <th>BIOFUEL Viscosity</th>
            <th>VLSFO (MT)</th>
            <th>VLSFO Viscosity</th>
            <th>LSMGO (MT)</th>
            <th>LSMGO Viscosity</th>

            <th>Port Delivery</th>
            <th>EOSP</th>
            <th>EOSP GMT</th>
            <th>Barge</th>
            <th>Barge GMT</th>
            <th>COSP</th>
            <th>COSP GMT</th>
            <th>Anchor</th>
            <th>Anchor GMT</th>
            <th>Pumping</th>
            <th>Pumping GMT</th>

            <th>Master's Info</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $r)
        <tr>
            <td>{{ $r->report_type }}</td>
            <td>{{ $r->vessel->name ?? '' }}</td>
            <td>{{ $r->unit->name ?? '' }}</td>
            <td>{{ $r->voyage_no }}</td>
            <td>{{ $r->bunkering_port }}</td>
            <td>{{ $r->supplier }}</td>
            <td>{{ $r->port_etd }}</td>
            <td>{{ $r->port_gmt_offset }}</td>
            <td>{{ $r->bunker_completed }}</td>
            <td>{{ $r->bunker_gmt_offset }}</td>

            <td>{{ $r->bunker->hsfo_quantity ?? '' }}</td>
            <td>{{ $r->bunker->hsfo_viscosity ?? '' }}</td>
            <td>{{ $r->bunker->biofuel_quantity ?? '' }}</td>
            <td>{{ $r->bunker->biofuel_viscosity ?? '' }}</td>
            <td>{{ $r->bunker->vlsfo_quantity ?? '' }}</td>
            <td>{{ $r->bunker->vlsfo_viscosity ?? '' }}</td>
            <td>{{ $r->bunker->lsmgo_quantity ?? '' }}</td>
            <td>{{ $r->bunker->lsmgo_viscosity ?? '' }}</td>

            <td>{{ $r->assiociated_information->port_delivery ?? '' }}</td>
            <td>{{ $r->assiociated_information->eosp ?? '' }}</td>
            <td>{{ $r->assiociated_information->eosp_gmt ?? '' }}</td>
            <td>{{ $r->assiociated_information->barge ?? '' }}</td>
            <td>{{ $r->assiociated_information->barge_gmt ?? '' }}</td>
            <td>{{ $r->assiociated_information->cosp ?? '' }}</td>
            <td>{{ $r->assiociated_information->cosp_gmt ?? '' }}</td>
            <td>{{ $r->assiociated_information->anchor ?? '' }}</td>
            <td>{{ $r->assiociated_information->anchor_gmt ?? '' }}</td>
            <td>{{ $r->assiociated_information->pumping ?? '' }}</td>
            <td>{{ $r->assiociated_information->pumping_gmt ?? '' }}</td>

            <td>{{ $r->master_info->master_info ?? '' }}</td>
            <td>{{ $r->remarks->remarks ?? '' }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
