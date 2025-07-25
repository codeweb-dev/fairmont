<table border="1">
    <thead>
        <tr>
            @php
                $headers = [
                    'Vessel', 'Report Type', 'Reporting Period',

                    'Total Landed Ashore (m3)', 'Total Incinerated (m3)',
                    'Total Disposed at Sea (m3)', 'Total Landed Ashore (m3)', 'Total Incinerated (In m3)',
                    'Total Landed Ashore (m3)', 'Total Incinerated (m3)',
                    'Total Landed Ashore (m3)', 'Total Incinerated (m3)',
                    'Total Landed Ashore (m3)', 'Total Incinerated (m3)',
                    'Total Landed Ashore (m3)', 'Total Incinerated (m3)',
                    'Total Landed Ashore (m3)', 'Total Landed Ashore (m3)', 'Total Incinerated (In m3)',
                    'Total Disposed at Sea (m3)', 'Total Garbage Landed Ashore (m3)', 'Total Garbage Disposed at Sea (In m3)',

                    'Total Landed Ashore (m3)', 'Total Incinerated (m3)',
                    'Total Quantity of Sludge Generated (m3)', 'Total Fuel Consumed (MT)', 'Ratio of Sludge Generated to Bunkers Consumed',
                    'Remarks (if target exceeded)',

                    'Total Bilge Water Discharged Through OWS (m3)', 'Total Bilge Water Landed to Shore (m3)', 'Total Bilge Water Generated (m3)',

                    'Paper Consumption (reams)', 'Printer Cartridges (units)', 'Remarks (if target exceeded)',

                    'Fresh Water Generated (m3)', 'Fresh Water Consumed (m3)',

                    'Number of Ballast Water Exchanges Performed', 'Number of Ballast Operations', 'Number of De-Ballast Operations',
                    'Total Water Intake During Ballasting (m3)', 'Total Water Out During De-Ballasting (m3)', 'Total Ballast Water Exchange Amount (m3)',

                    'Total Number of Propeller Cleanings', 'Total Number of Hull Cleanings',

                    'Total Sailing Days', 'Eco Speed Sailing Days', 'Full Speed Sailing Days',

                    'No. of Fatalities', 'LTI (Lost Time Injuries)', 'No. of Recordable Injuries',

                    'No. of Corruption/Bribery/Entertainment for Port Officials',

                    'Number of PSC Inspections', 'PSC No. of Deficiencies', 'PSC Detentions (if any)',
                    'Number of Flag State Inspections', 'Flag No. of Deficiencies',
                    'Third Party Inspections (Charterers, Owners, RISQ, Others)', 'Third Party No. of Deficiencies',

                    'Overall Remarks', 'Master Information'
                ];
            @endphp

            @foreach ($headers as $header)
                <th style="width: 250px;"><strong>{{ $header }}</strong></th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $report)
            @if (!$loop->first)
                <tr>
                    <td colspan="11" style="height: 15px;"></td> {{-- Spacer row --}}
                </tr>
            @endif

            <tr>
                <td style="width: 250px; text-align: left;">{{ $report->vessel->name ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->report_type }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->all_fast_datetime ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') : '' }}</td>

                {{-- Waste --}}
                <td style="width: 250px; text-align: left;">{{ $report->waste->plastics_landed_ashore ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->plastics_incinerated ?? '' }}</td>

                <td style="width: 250px; text-align: left;">{{ $report->waste->food_disposed_sea ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->food_landed_ashore ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->food_total_incinerated ?? '' }}</td>

                <td style="width: 250px; text-align: left;">{{ $report->waste->domestic_landed_ashore ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->domestic_incinerated ?? '' }}</td>

                <td style="width: 250px; text-align: left;">{{ $report->waste->cooking_oil_landed_ashore ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->cooking_oil_incinerated ?? '' }}</td>

                <td style="width: 250px; text-align: left;">{{ $report->waste->incinerator_ash_landed_ashore ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->incinerator_ash_incinerated ?? '' }}</td>

                <td style="width: 250px; text-align: left;">{{ $report->waste->operational_landed_ashore ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->operational_incinerated ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->ewaste_landed_ashore ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->ewaste_landed_total_incinerated ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->cargo_residues_landed_ashore ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->cargo_residues_disposed_at_sea ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->total_garbage_disposed_sea ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->total_garbage_landed_ashore ?? '' }}</td>

                {{-- Sludge --}}
                <td style="width: 250px; text-align: left;">{{ $report->waste->sludge_landed_ashore ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->sludge_incinerated ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->sludge_generated ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->fuel_consumed ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->sludge_bunker_ratio ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->sludge_remarks ?? '' }}</td>

                {{-- Bilge --}}
                <td style="width: 250px; text-align: left;">{{ $report->waste->bilge_discharged_ows ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->bilge_landed_ashore ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->bilge_generated ?? '' }}</td>

                {{-- Consumption --}}
                <td style="width: 250px; text-align: left;">{{ $report->waste->paper_consumption ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->printer_cartridges ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->consumption_remarks ?? '' }}</td>

                {{-- Fresh Water --}}
                <td style="width: 250px; text-align: left;">{{ $report->waste->fresh_water_generated ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->fresh_water_consumed ?? '' }}</td>

                {{-- Ballast --}}
                <td style="width: 250px; text-align: left;">{{ $report->waste->ballast_exchanges ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->ballast_operations ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->deballast_operations ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->ballast_intake ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->ballast_out ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->ballast_exchange_amount ?? '' }}</td>

                {{-- Cleaning --}}
                <td style="width: 250px; text-align: left;">{{ $report->waste->propeller_cleanings ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->waste->hull_cleanings ?? '' }}</td>

                {{-- Voyage --}}
                <td style="width: 250px; text-align: left;">{{ $report->call_sign ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->flag ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->port_of_registry ?? '' }}</td>

                {{-- Crew --}}
                <td style="width: 250px; text-align: left;">{{ $report->official_number ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->imo_number ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->class_society ?? '' }}</td>

                {{-- Corruption --}}
                <td style="width: 250px; text-align: left;">{{ $report->class_no ?? '' }}</td>

                {{-- Inspection --}}
                <td style="width: 250px; text-align: left;">{{ $report->pi_club ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->loa ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->lbp ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->breadth_extreme ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->depth_moulded ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->height_maximum ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->bridge_front_bow ?? '' }}</td>

                {{-- Remarks & Master --}}
                <td style="width: 250px; text-align: left;">{{ $report->remarks->remarks ?? '' }}</td>
                <td style="width: 250px; text-align: left;">{{ $report->master_info->master_info ?? '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
