<table border="1">
    <thead>
        <tr>
            @php
                $headers = [
                    'Vessel', 'Report Type', 'Reporting Period',

                    'Total Landed Ashore (m3)', 'Total Incinerated (m3)',
                    'Total Disposed at Sea (m3)', 'Total Landed Ashore (m3)',
                    'Total Landed Ashore (m3)', 'Total Incinerated (m3)',
                    'Total Landed Ashore (m3)', 'Total Incinerated (m3)',
                    'Total Landed Ashore (m3)', 'Total Incinerated (m3)',
                    'Total Landed Ashore (m3)', 'Total Incinerated (m3)',
                    'Total Landed Ashore (m3)', 'Total Landed Ashore (m3)',
                    'Total Disposed at Sea (m3)', 'Total Garbage Landed Ashore (m3)',

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
                <th style="width: 250px;">{{ $header }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $report)
            <tr>
                <td style="width: 250px;">{{ $report->vessel->name ?? '' }}</td>
                <td style="width: 250px;">{{ $report->report_type }}</td>
                <td style="width: 250px;">{{ $report->all_fast_datetime ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') : '' }}</td>

                {{-- Waste --}}
                <td style="width: 250px;">{{ $report->waste->plastics_landed_ashore ?? '' }}</td>
                <td style="width: 250px;">{{ $report->waste->plastics_incinerated ?? '' }}</td>

                <td style="width: 250px;">{{ $report->waste->food_disposed_sea ?? '' }}</td>
                <td style="width: 250px;">{{ $report->waste->food_landed_ashore ?? '' }}</td>

                <td style="width: 250px;">{{ $report->waste->domestic_landed_ashore ?? '' }}</td>
                <td style="width: 250px;">{{ $report->waste->domestic_incinerated ?? '' }}</td>

                <td style="width: 250px;">{{ $report->waste->cooking_oil_landed_ashore ?? '' }}</td>
                <td style="width: 250px;">{{ $report->waste->cooking_oil_incinerated ?? '' }}</td>

                <td style="width: 250px;">{{ $report->waste->incinerator_ash_landed_ashore ?? '' }}</td>
                <td style="width: 250px;">{{ $report->waste->incinerator_ash_incinerated ?? '' }}</td>

                <td style="width: 250px;">{{ $report->waste->operational_landed_ashore ?? '' }}</td>
                <td style="width: 250px;">{{ $report->waste->operational_incinerated ?? '' }}</td>
                <td style="width: 250px;">{{ $report->waste->ewaste_landed_ashore ?? '' }}</td>
                <td style="width: 250px;">{{ $report->waste->cargo_residues_landed_ashore ?? '' }}</td>
                <td style="width: 250px;">{{ $report->waste->total_garbage_disposed_sea ?? '' }}</td>
                <td style="width: 250px;">{{ $report->waste->total_garbage_landed_ashore ?? '' }}</td>

                {{-- Sludge --}}
                <td style="width: 250px;">{{ $report->waste->sludge_landed_ashore ?? '' }}</td>
                <td style="width: 250px;">{{ $report->waste->sludge_incinerated ?? '' }}</td>
                <td style="width: 250px;">{{ $report->waste->sludge_generated ?? '' }}</td>
                <td style="width: 250px;">{{ $report->waste->fuel_consumed ?? '' }}</td>
                <td style="width: 250px;">{{ $report->waste->sludge_bunker_ratio ?? '' }}</td>
                <td style="width: 250px;">{{ $report->waste->sludge_remarks ?? '' }}</td>

                {{-- Bilge --}}
                <td style="width: 250px;">{{ $report->waste->bilge_discharged_ows ?? '' }}</td>
                <td style="width: 250px;">{{ $report->waste->bilge_landed_ashore ?? '' }}</td>
                <td style="width: 250px;">{{ $report->waste->bilge_generated ?? '' }}</td>

                {{-- Consumption --}}
                <td style="width: 250px;">{{ $report->waste->paper_consumption ?? '' }}</td>
                <td style="width: 250px;">{{ $report->waste->printer_cartridges ?? '' }}</td>
                <td style="width: 250px;">{{ $report->waste->consumption_remarks ?? '' }}</td>

                {{-- Fresh Water --}}
                <td style="width: 250px;">{{ $report->waste->fresh_water_generated ?? '' }}</td>
                <td style="width: 250px;">{{ $report->waste->fresh_water_consumed ?? '' }}</td>

                {{-- Ballast --}}
                <td style="width: 250px;">{{ $report->waste->ballast_exchanges ?? '' }}</td>
                <td style="width: 250px;">{{ $report->waste->ballast_operations ?? '' }}</td>
                <td style="width: 250px;">{{ $report->waste->deballast_operations ?? '' }}</td>
                <td style="width: 250px;">{{ $report->waste->ballast_intake ?? '' }}</td>
                <td style="width: 250px;">{{ $report->waste->ballast_out ?? '' }}</td>
                <td style="width: 250px;">{{ $report->waste->ballast_exchange_amount ?? '' }}</td>

                {{-- Cleaning --}}
                <td style="width: 250px;">{{ $report->waste->propeller_cleanings ?? '' }}</td>
                <td style="width: 250px;">{{ $report->waste->hull_cleanings ?? '' }}</td>

                {{-- Voyage --}}
                <td style="width: 250px;">{{ $report->call_sign ?? '' }}</td>
                <td style="width: 250px;">{{ $report->flag ?? '' }}</td>
                <td style="width: 250px;">{{ $report->port_of_registry ?? '' }}</td>

                {{-- Crew --}}
                <td style="width: 250px;">{{ $report->official_number ?? '' }}</td>
                <td style="width: 250px;">{{ $report->imo_number ?? '' }}</td>
                <td style="width: 250px;">{{ $report->class_society ?? '' }}</td>

                {{-- Corruption --}}
                <td style="width: 250px;">{{ $report->class_no ?? '' }}</td>

                {{-- Inspection --}}
                <td style="width: 250px;">{{ $report->pi_club ?? '' }}</td>
                <td style="width: 250px;">{{ $report->loa ?? '' }}</td>
                <td style="width: 250px;">{{ $report->lbp ?? '' }}</td>
                <td style="width: 250px;">{{ $report->breadth_extreme ?? '' }}</td>
                <td style="width: 250px;">{{ $report->depth_moulded ?? '' }}</td>
                <td style="width: 250px;">{{ $report->height_maximum ?? '' }}</td>
                <td style="width: 250px;">{{ $report->bridge_front_bow ?? '' }}</td>

                {{-- Remarks & Master --}}
                <td style="width: 250px;">{{ $report->remarks->remarks ?? '' }}</td>
                <td style="width: 250px;">{{ $report->master_info->master_info ?? '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
