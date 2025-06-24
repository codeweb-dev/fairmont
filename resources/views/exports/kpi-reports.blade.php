<table>
    <thead>
        <tr>
            <th>Report Type</th>
            <th>Vessel</th>
            <th>Unit</th>
            <th>Date</th>
            <th>Plastics Landed Ashore</th>
            <th>Plastics Incinerated</th>
            <th>Food Disposed at Sea</th>
            <th>Food Landed Ashore</th>
            <th>Domestic Landed Ashore</th>
            <th>Domestic Incinerated</th>
            <th>Cooking Oil Landed Ashore</th>
            <th>Cooking Oil Incinerated</th>
            <th>Incinerator Ash Landed Ashore</th>
            <th>Incinerator Ash Incinerated</th>
            <th>Operational Landed Ashore</th>
            <th>Operational Incinerated</th>
            <th>E-Waste Landed Ashore</th>
            <th>Cargo Residues Landed Ashore</th>
            <th>Total Garbage Disposed at Sea</th>
            <th>Total Garbage Landed Ashore</th>
            <th>Sludge Landed Ashore</th>
            <th>Sludge Incinerated</th>
            <th>Sludge Generated</th>
            <th>Fuel Consumed</th>
            <th>Sludge to Bunker Ratio</th>
            <th>Sludge Remarks</th>
            <th>Bilge Discharged OWS</th>
            <th>Bilge Landed Ashore</th>
            <th>Bilge Generated</th>
            <th>Paper Consumption</th>
            <th>Printer Cartridges</th>
            <th>Consumption Remarks</th>
            <th>Fresh Water Generated</th>
            <th>Fresh Water Consumed</th>
            <th>Ballast Exchanges</th>
            <th>Ballast Operations</th>
            <th>De-Ballast Operations</th>
            <th>Ballast Intake</th>
            <th>Ballast Out</th>
            <th>Ballast Exchange Amount</th>
            <th>Propeller Cleanings</th>
            <th>Hull Cleanings</th>
            <th>Total Sailing Days</th>
            <th>Eco Speed Sailing Days</th>
            <th>Full Speed Sailing Days</th>
            <th>No. of Fatalities</th>
            <th>LTI</th>
            <th>No. of Recordable Injuries</th>
            <th>MACN Corruption Reports</th>
            <th>PSC Inspections</th>
            <th>PSC Deficiencies</th>
            <th>PSC Detentions</th>
            <th>Flag State Inspections</th>
            <th>Flag State Inspections (Repeat)</th>
            <th>Third Party Inspections</th>
            <th>Third Party Deficiencies</th>
            <th>Master's Info</th>
            <th>Remarks</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $report)
            <tr>
                <td>{{ $report->report_type }}</td>
                <td>{{ $report->vessel->name ?? '-' }}</td>
                <td>{{ $report->unit->name ?? '-' }}</td>
                <td>{{ $report->all_fast_datetime ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y') : '-' }}</td>
                <td>{{ $report->waste->plastics_landed_ashore ?? '-' }}</td>
                <td>{{ $report->waste->plastics_incinerated ?? '-' }}</td>
                <td>{{ $report->waste->food_disposed_sea ?? '-' }}</td>
                <td>{{ $report->waste->food_landed_ashore ?? '-' }}</td>
                <td>{{ $report->waste->domestic_landed_ashore ?? '-' }}</td>
                <td>{{ $report->waste->domestic_incinerated ?? '-' }}</td>
                <td>{{ $report->waste->cooking_oil_landed_ashore ?? '-' }}</td>
                <td>{{ $report->waste->cooking_oil_incinerated ?? '-' }}</td>
                <td>{{ $report->waste->incinerator_ash_landed_ashore ?? '-' }}</td>
                <td>{{ $report->waste->incinerator_ash_incinerated ?? '-' }}</td>
                <td>{{ $report->waste->operational_landed_ashore ?? '-' }}</td>
                <td>{{ $report->waste->operational_incinerated ?? '-' }}</td>
                <td>{{ $report->waste->ewaste_landed_ashore ?? '-' }}</td>
                <td>{{ $report->waste->cargo_residues_landed_ashore ?? '-' }}</td>
                <td>{{ $report->waste->total_garbage_disposed_sea ?? '-' }}</td>
                <td>{{ $report->waste->total_garbage_landed_ashore ?? '-' }}</td>
                <td>{{ $report->waste->sludge_landed_ashore ?? '-' }}</td>
                <td>{{ $report->waste->sludge_incinerated ?? '-' }}</td>
                <td>{{ $report->waste->sludge_generated ?? '-' }}</td>
                <td>{{ $report->waste->fuel_consumed ?? '-' }}</td>
                <td>{{ $report->waste->sludge_bunker_ratio ?? '-' }}</td>
                <td>{{ $report->waste->sludge_remarks ?? '-' }}</td>
                <td>{{ $report->waste->bilge_discharged_ows ?? '-' }}</td>
                <td>{{ $report->waste->bilge_landed_ashore ?? '-' }}</td>
                <td>{{ $report->waste->bilge_generated ?? '-' }}</td>
                <td>{{ $report->waste->paper_consumption ?? '-' }}</td>
                <td>{{ $report->waste->printer_cartridges ?? '-' }}</td>
                <td>{{ $report->waste->consumption_remarks ?? '-' }}</td>
                <td>{{ $report->waste->fresh_water_generated ?? '-' }}</td>
                <td>{{ $report->waste->fresh_water_consumed ?? '-' }}</td>
                <td>{{ $report->waste->ballast_exchanges ?? '-' }}</td>
                <td>{{ $report->waste->ballast_operations ?? '-' }}</td>
                <td>{{ $report->waste->deballast_operations ?? '-' }}</td>
                <td>{{ $report->waste->ballast_intake ?? '-' }}</td>
                <td>{{ $report->waste->ballast_out ?? '-' }}</td>
                <td>{{ $report->waste->ballast_exchange_amount ?? '-' }}</td>
                <td>{{ $report->waste->propeller_cleanings ?? '-' }}</td>
                <td>{{ $report->waste->hull_cleanings ?? '-' }}</td>
                <td>{{ $report->call_sign ?? '-' }}</td>
                <td>{{ $report->flag ?? '-' }}</td>
                <td>{{ $report->port_of_registry ?? '-' }}</td>
                <td>{{ $report->official_number ?? '-' }}</td>
                <td>{{ $report->imo_number ?? '-' }}</td>
                <td>{{ $report->class_society ?? '-' }}</td>
                <td>{{ $report->class_no ?? '-' }}</td>
                <td>{{ $report->pi_club ?? '-' }}</td>
                <td>{{ $report->loa ?? '-' }}</td>
                <td>{{ $report->lbp ?? '-' }}</td>
                <td>{{ $report->breadth_extreme ?? '-' }}</td>
                <td>{{ $report->depth_moulded ?? '-' }}</td>
                <td>{{ $report->height_maximum ?? '-' }}</td>
                <td>{{ $report->bridge_front_bow ?? '-' }}</td>
                <td>{{ $report->master_info->master_info ?? '-' }}</td>
                <td>{{ $report->remarks->remarks ?? '-' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
