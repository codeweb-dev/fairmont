<table border="1">
    <thead>
        <tr>
            @php
                $headers = [
                    'Vessel Name', 'Voyage No', 'Bunkering Port', 'Supplier', 'Port ETD (LT)', 'Port GMT Offset',
                    'Bunker Completed (LT)', 'Bunker GMT Offset',

                    'HSFO Quantity (MT)', 'HSFO Viscosity (CST)',
                    'BIOFUEL Quantity (MT)', 'BIOFUEL Viscosity (CST)',
                    'VLSFO Quantity (MT)', 'VLSFO Viscosity (CST)',
                    'LSMGO Quantity (MT)', 'LSMGO Viscosity (CST)',

                    'In Port vs Off Shore Delivery', 'EOSP (LT)', 'EOSP GMT Offset',
                    'Barge Alongside (LT)', 'Barge Alongside GMT Offset',
                    'COSP (LT)', 'COSP GMT Offset',
                    'Anchor Dropped (LT)', 'Anchor Dropped GMT Offset',
                    'Pumping Completed (LT)', 'Pumping Completed GMT Offset',

                    'Remarks', 'Master Information'
                ];
            @endphp

            @foreach ($headers as $header)
                <th style="width: 250px;"><strong>{{ $header }}</strong></th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $r)
            @if (!$loop->first)
                <tr>
                    <td colspan="11" style="height: 20px;"></td> {{-- Spacer row --}}
                </tr>
            @endif

            <tr>
                {{-- Bunkering Details --}}
                <td style="text-align: left;">{{ $r->vessel->name ?? '' }}</td>
                <td style="text-align: left;">{{ $r->voyage_no ?? '' }}</td>
                <td style="text-align: left;">{{ $r->bunkering_port ?? '' }}</td>
                <td style="text-align: left;">{{ $r->supplier ?? '' }}</td>
                <td style="text-align: left;">{{ $r->port_etd ?? '' }}</td>
                <td style="text-align: left;">{{ $r->port_gmt_offset ?? '' }}</td>
                <td style="text-align: left;">{{ $r->bunker_completed ?? '' }}</td>
                <td style="text-align: left;">{{ $r->bunker_gmt_offset ?? '' }}</td>

                {{-- Bunker Quantities --}}
                <td style="text-align: left;">{{ $r->bunker->hsfo_quantity ?? '' }}</td>
                <td style="text-align: left;">{{ $r->bunker->hsfo_viscosity ?? '' }}</td>
                <td style="text-align: left;">{{ $r->bunker->biofuel_quantity ?? '' }}</td>
                <td style="text-align: left;">{{ $r->bunker->biofuel_viscosity ?? '' }}</td>
                <td style="text-align: left;">{{ $r->bunker->vlsfo_quantity ?? '' }}</td>
                <td style="text-align: left;">{{ $r->bunker->vlsfo_viscosity ?? '' }}</td>
                <td style="text-align: left;">{{ $r->bunker->lsmgo_quantity ?? '' }}</td>
                <td style="text-align: left;">{{ $r->bunker->lsmgo_viscosity ?? '' }}</td>

                {{-- Associated Info --}}
                <td style="text-align: left;">{{ $r->assiociated_information->port_delivery ?? '' }}</td>
                <td style="text-align: left;">{{ $r->assiociated_information->eosp ?? '' }}</td>
                <td style="text-align: left;">{{ $r->assiociated_information->eosp_gmt ?? '' }}</td>
                <td style="text-align: left;">{{ $r->assiociated_information->barge ?? '' }}</td>
                <td style="text-align: left;">{{ $r->assiociated_information->barge_gmt ?? '' }}</td>
                <td style="text-align: left;">{{ $r->assiociated_information->cosp ?? '' }}</td>
                <td style="text-align: left;">{{ $r->assiociated_information->cosp_gmt ?? '' }}</td>
                <td style="text-align: left;">{{ $r->assiociated_information->anchor ?? '' }}</td>
                <td style="text-align: left;">{{ $r->assiociated_information->anchor_gmt ?? '' }}</td>
                <td style="text-align: left;">{{ $r->assiociated_information->pumping ?? '' }}</td>
                <td style="text-align: left;">{{ $r->assiociated_information->pumping_gmt ?? '' }}</td>

                {{-- Remarks --}}
                <td style="text-align: left;">{{ $r->remarks->remarks ?? '' }}</td>

                {{-- Master Info --}}
                <td style="text-align: left;">{{ $r->master_info->master_info ?? '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
