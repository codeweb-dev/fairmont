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
                <th style="width: 250px;">{{ $header }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $r)
            <tr>
                {{-- Bunkering Details --}}
                <td>{{ $r->vessel->name ?? '' }}</td>
                <td>{{ $r->voyage_no ?? '' }}</td>
                <td>{{ $r->bunkering_port ?? '' }}</td>
                <td>{{ $r->supplier ?? '' }}</td>
                <td>{{ $r->port_etd ?? '' }}</td>
                <td>{{ $r->port_gmt_offset ?? '' }}</td>
                <td>{{ $r->bunker_completed ?? '' }}</td>
                <td>{{ $r->bunker_gmt_offset ?? '' }}</td>

                {{-- Bunker Quantities --}}
                <td>{{ $r->bunker->hsfo_quantity ?? '' }}</td>
                <td>{{ $r->bunker->hsfo_viscosity ?? '' }}</td>
                <td>{{ $r->bunker->biofuel_quantity ?? '' }}</td>
                <td>{{ $r->bunker->biofuel_viscosity ?? '' }}</td>
                <td>{{ $r->bunker->vlsfo_quantity ?? '' }}</td>
                <td>{{ $r->bunker->vlsfo_viscosity ?? '' }}</td>
                <td>{{ $r->bunker->lsmgo_quantity ?? '' }}</td>
                <td>{{ $r->bunker->lsmgo_viscosity ?? '' }}</td>

                {{-- Associated Info --}}
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

                {{-- Remarks --}}
                <td>{{ $r->remarks->remarks ?? '' }}</td>

                {{-- Master Info --}}
                <td>{{ $r->master_info->master_info ?? '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
