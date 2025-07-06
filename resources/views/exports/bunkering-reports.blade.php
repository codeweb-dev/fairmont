@foreach ($reports as $r)
    {{-- Bunkering Details --}}
    <table>
        <tr><td colspan="2" style="font-weight: bold;">Bunkering Details</td></tr>
        <tr><td style="width: 250px;">Vessel Name:</td><td>{{ $r->vessel->name ?? '' }}</td></tr>
        <tr><td style="width: 250px;">Voyage No:</td><td>{{ $r->voyage_no ?? '' }}</td></tr>
        <tr><td style="width: 250px;">Bunkering Port:</td><td>{{ $r->bunkering_port ?? '' }}</td></tr>
        <tr><td style="width: 250px;">Supplier:</td><td>{{ $r->supplier ?? '' }}</td></tr>
        <tr><td style="width: 250px;">Port ETD (LT):</td><td>{{ $r->port_etd ?? '' }}</td></tr>
        <tr><td style="width: 250px;">Port GMT Offset:</td><td>{{ $r->port_gmt_offset ?? '' }}</td></tr>
        <tr><td style="width: 250px;">Bunker Completed (LT):</td><td>{{ $r->bunker_completed ?? '' }}</td></tr>
        <tr><td style="width: 250px;">Bunker GMT Offset:</td><td>{{ $r->bunker_gmt_offset ?? '' }}</td></tr>
    </table>

    {{-- Bunker Quantities --}}
    <table>
        <tr><td colspan="2" style="font-weight: bold;">Bunker Type Quantity Taken (in MT)</td></tr>
        <tr><td style="width: 250px;">HSFO Quantity (MT):</td><td>{{ $r->bunker->hsfo_quantity ?? '' }}</td></tr>
        <tr><td style="width: 250px;">HSFO Viscosity (CST):</td><td>{{ $r->bunker->hsfo_viscosity ?? '' }}</td></tr>
        <tr><td style="width: 250px;">BIOFUEL Quantity (MT):</td><td>{{ $r->bunker->biofuel_quantity ?? '' }}</td></tr>
        <tr><td style="width: 250px;">BIOFUEL Viscosity (CST):</td><td>{{ $r->bunker->biofuel_viscosity ?? '' }}</td></tr>
        <tr><td style="width: 250px;">VLSFO Quantity (MT):</td><td>{{ $r->bunker->vlsfo_quantity ?? '' }}</td></tr>
        <tr><td style="width: 250px;">VLSFO Viscosity (CST):</td><td>{{ $r->bunker->vlsfo_viscosity ?? '' }}</td></tr>
        <tr><td style="width: 250px;">LSMGO Quantity (MT):</td><td>{{ $r->bunker->lsmgo_quantity ?? '' }}</td></tr>
        <tr><td style="width: 250px;">LSMGO Viscosity (CST):</td><td>{{ $r->bunker->lsmgo_viscosity ?? '' }}</td></tr>
    </table>

    {{-- Associated Information --}}
    <table>
        <tr><td colspan="2" style="font-weight: bold;">Associated Information</td></tr>
        <tr><td style="width: 250px;">In Port vs Off Shore Delivery:</td><td>{{ $r->assiociated_information->port_delivery ?? '' }}</td></tr>
        <tr><td style="width: 250px;">EOSP (LT):</td><td>{{ $r->assiociated_information->eosp ?? '' }}</td></tr>
        <tr><td style="width: 250px;">EOSP GMT Offset:</td><td>{{ $r->assiociated_information->eosp_gmt ?? '' }}</td></tr>
        <tr><td style="width: 250px;">Barge Alongside (LT):</td><td>{{ $r->assiociated_information->barge ?? '' }}</td></tr>
        <tr><td style="width: 250px;">Barge Alongside GMT Offset:</td><td>{{ $r->assiociated_information->barge_gmt ?? '' }}</td></tr>
        <tr><td style="width: 250px;">COSP (LT):</td><td>{{ $r->assiociated_information->cosp ?? '' }}</td></tr>
        <tr><td style="width: 250px;">COSP GMT Offset:</td><td>{{ $r->assiociated_information->cosp_gmt ?? '' }}</td></tr>
        <tr><td style="width: 250px;">Anchor Dropped (LT):</td><td>{{ $r->assiociated_information->anchor ?? '' }}</td></tr>
        <tr><td style="width: 250px;">Anchor Dropped GMT Offset:</td><td>{{ $r->assiociated_information->anchor_gmt ?? '' }}</td></tr>
        <tr><td style="width: 250px;">Pumping Completed (LT):</td><td>{{ $r->assiociated_information->pumping ?? '' }}</td></tr>
        <tr><td style="width: 250px;">Pumping Completed GMT Offset:</td><td>{{ $r->assiociated_information->pumping_gmt ?? '' }}</td></tr>
    </table>

    {{-- Remarks --}}
    <table>
        <tr><td colspan="2" style="font-weight: bold;">Remarks</td></tr>
        <tr><td style="width: 250px;">Remarks:</td><td>{{ $r->remarks->remarks ?? '' }}</td></tr>
    </table>

    {{-- Master Info --}}
    <table>
        <tr><td colspan="2" style="font-weight: bold;">Master Information</td></tr>
        <tr><td style="width: 250px;">Master's Name:</td><td>{{ $r->master_info->master_info ?? '' }}</td></tr>
    </table>

    <br><br>
@endforeach
