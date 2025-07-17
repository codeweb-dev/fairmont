<table border="1" cellspacing="0" cellpadding="4" style="border-collapse: collapse; width: 100%;">
    @foreach ($reports as $r)
        {{-- Section Title --}}
        <tr>
            <td colspan="2" style="font-weight: bold; background-color: #f0f0f0;">Bunkering Report Details</td>
        </tr>

        <tr>
            <td style="width: 250px; text-align: left;"></td>
            <td style="width: 250px; text-align: left;"></td>
        </tr>

        {{-- Bunkering Details --}}
        <tr>
            <td colspan="2" style="font-weight: bold;">Bunkering Details</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">Vessel Name:</td>
            <td style="width: 250px; text-align: left;">{{ $r->vessel->name ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">Voyage No:</td>
            <td style="width: 250px; text-align: left;">{{ $r->voyage_no ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">Bunkering Port:</td>
            <td style="width: 250px; text-align: left;">{{ $r->bunkering_port ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">Supplier:</td>
            <td style="width: 250px; text-align: left;">{{ $r->supplier ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">Port ETD (LT):</td>
            <td style="width: 250px; text-align: left;">{{ $r->port_etd ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">Port GMT Offset:</td>
            <td style="width: 250px; text-align: left;">{{ $r->port_gmt_offset ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">Bunker Completed (LT):</td>
            <td style="width: 250px; text-align: left;">{{ $r->bunker_completed ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">Bunker GMT Offset:</td>
            <td style="width: 250px; text-align: left;">{{ $r->bunker_gmt_offset ?? '' }}</td>
        </tr>


        <tr>
            <td style="width: 250px; text-align: left;"></td>
            <td style="width: 250px; text-align: left;"></td>
        </tr>

        {{-- Bunker Quantities --}}
        <tr>
            <td colspan="2" style="font-weight: bold;">Bunker Type Quantity Taken (in MT)</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">HSFO Quantity (MT):</td>
            <td style="width: 250px; text-align: left;">{{ $r->bunker->hsfo_quantity ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">HSFO Viscosity (CST):</td>
            <td style="width: 250px; text-align: left;">{{ $r->bunker->hsfo_viscosity ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">BIOFUEL Quantity (MT):</td>
            <td style="width: 250px; text-align: left;">{{ $r->bunker->biofuel_quantity ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">BIOFUEL Viscosity (CST):</td>
            <td style="width: 250px; text-align: left;">{{ $r->bunker->biofuel_viscosity ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">VLSFO Quantity (MT):</td>
            <td style="width: 250px; text-align: left;">{{ $r->bunker->vlsfo_quantity ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">VLSFO Viscosity (CST):</td>
            <td style="width: 250px; text-align: left;">{{ $r->bunker->vlsfo_viscosity ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">LSMGO Quantity (MT):</td>
            <td style="width: 250px; text-align: left;">{{ $r->bunker->lsmgo_quantity ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">LSMGO Viscosity (CST):</td>
            <td style="width: 250px; text-align: left;">{{ $r->bunker->lsmgo_viscosity ?? '' }}</td>
        </tr>

        <tr>
            <td style="width: 250px; text-align: left;"></td>
            <td style="width: 250px; text-align: left;"></td>
        </tr>

        {{-- Associated Information --}}
        <tr>
            <td colspan="2" style="font-weight: bold;">Associated Information</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">In Port vs Off Shore Delivery:</td>
            <td style="width: 250px; text-align: left;">{{ $r->assiociated_information->port_delivery ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">EOSP (LT):</td>
            <td style="width: 250px; text-align: left;">{{ $r->assiociated_information->eosp ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">EOSP GMT Offset:</td>
            <td style="width: 250px; text-align: left;">{{ $r->assiociated_information->eosp_gmt ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">Barge Alongside (LT):</td>
            <td style="width: 250px; text-align: left;">{{ $r->assiociated_information->barge ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">Barge Alongside GMT Offset:</td>
            <td style="width: 250px; text-align: left;">{{ $r->assiociated_information->barge_gmt ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">COSP (LT):</td>
            <td style="width: 250px; text-align: left;">{{ $r->assiociated_information->cosp ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">COSP GMT Offset:</td>
            <td style="width: 250px; text-align: left;">{{ $r->assiociated_information->cosp_gmt ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">Anchor Dropped (LT):</td>
            <td style="width: 250px; text-align: left;">{{ $r->assiociated_information->anchor ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">Anchor Dropped GMT Offset:</td>
            <td style="width: 250px; text-align: left;">{{ $r->assiociated_information->anchor_gmt ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">Pumping Completed (LT):</td>
            <td style="width: 250px; text-align: left;">{{ $r->assiociated_information->pumping ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">Pumping Completed GMT Offset:</td>
            <td style="width: 250px; text-align: left;">{{ $r->assiociated_information->pumping_gmt ?? '' }}</td>
        </tr>

        <tr>
            <td style="width: 250px; text-align: left;"></td>
            <td style="width: 250px; text-align: left;"></td>
        </tr>

        {{-- Remarks --}}
        <tr>
            <td colspan="2" style="font-weight: bold;">Remarks</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">Remarks:</td>
            <td style="width: 250px; text-align: left;">{{ $r->remarks->remarks ?? '' }}</td>
        </tr>

        <tr>
            <td style="width: 250px; text-align: left;"></td>
            <td style="width: 250px; text-align: left;"></td>
        </tr>

        {{-- Master Info --}}
        <tr>
            <td colspan="2" style="font-weight: bold;">Master Information</td>
        </tr>
        <tr>
            <td style="width: 250px; text-align: left;">Master's Name:</td>
            <td style="width: 250px; text-align: left;">{{ $r->master_info->master_info ?? '' }}</td>
        </tr>
    @endforeach
</table>
