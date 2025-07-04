@foreach ($reports as $report)
    <table>
        <tr>
            <td colspan="2"><strong>Bunkering Details</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Vessel</td>
            <td style="width: 250px;">{{ $report->vessel->name ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Report Type</td>
            <td style="width: 250px;">{{ $report->report_type ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Date</td>
            <td style="width: 250px;">{{ $report->all_fast_datetime ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') : 'N/A' }}
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="2"><strong>Waste Management</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Plastics Landed Ashore</td>
            <td style="width: 250px;">{{ $report->waste->plastics_landed_ashore ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Plastics Incinerated</td>
            <td style="width: 250px;">{{ $report->waste->plastics_incinerated ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Food Disposed at Sea</td>
            <td style="width: 250px;">{{ $report->waste->food_disposed_sea ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Food Landed Ashore</td>
            <td style="width: 250px;">{{ $report->waste->food_landed_ashore ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Domestic Landed Ashore</td>
            <td style="width: 250px;">{{ $report->waste->domestic_landed_ashore ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Domestic Incinerated</td>
            <td style="width: 250px;">{{ $report->waste->domestic_incinerated ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Cooking Oil Landed Ashore</td>
            <td style="width: 250px;">{{ $report->waste->cooking_oil_landed_ashore ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Cooking Oil Incinerated</td>
            <td style="width: 250px;">{{ $report->waste->cooking_oil_incinerated ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Incinerator Ash Landed Ashore</td>
            <td style="width: 250px;">{{ $report->waste->incinerator_ash_landed_ashore ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Incinerator Ash Incinerated</td>
            <td style="width: 250px;">{{ $report->waste->incinerator_ash_incinerated ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Operational Landed Ashore</td>
            <td style="width: 250px;">{{ $report->waste->operational_landed_ashore ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Operational Incinerated</td>
            <td style="width: 250px;">{{ $report->waste->operational_incinerated ?? 'N/A'N/A}}</td>
        </tr>
        <tr>
            <td style="width: 250px;">E-Waste Landed Ashore</td>
            <td style="width: 250px;">{{ $report->waste->ewaste_landed_ashore ?? 'N/A' }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="2"><strong>Cargo & Garbage</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Cargo Residues Landed Ashore</td>
            <td style="width: 250px;">{{ $report->waste->cargo_residues_landed_ashore ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Garbage Disposed at Sea</td>
            <td style="width: 250px;">{{ $report->waste->total_garbage_disposed_sea ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Garbage Landed Ashore</td>
            <td style="width: 250px;">{{ $report->waste->total_garbage_landed_ashore ?? 'N/A' }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="2"><strong>Sludge & Bunker</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Sludge Landed Ashore</td>
            <td style="width: 250px;">{{ $report->waste->sludge_landed_ashore ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Sludge Incinerated</td>
            <td style="width: 250px;">{{ $report->waste->sludge_incinerated ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Sludge Generated</td>
            <td style="width: 250px;">{{ $report->waste->sludge_generated ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Fuel Consumed</td>
            <td style="width: 250px;">{{ $report->waste->fuel_consumed ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Sludge to Bunker Ratio</td>
            <td style="width: 250px;">{{ $report->waste->sludge_bunker_ratio ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Sludge Remarks</td>
            <td style="width: 250px;">{{ $report->waste->sludge_remarks ?? 'N/A' }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="2"><strong>Bilge Water</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Bilge Discharged OWS</td>
            <td style="width: 250px;">{{ $report->waste->bilge_discharged_ows ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Bilge Landed Ashore</td>
            <td style="width: 250px;">{{ $report->waste->bilge_landed_ashore ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Bilge Generated</td>
            <td style="width: 250px;">{{ $report->waste->bilge_generated ?? 'N/A' }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="2"><strong>Consumption</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Paper Consumption</td>
            <td style="width: 250px;">{{ $report->waste->paper_consumption ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Printer Cartridges</td>
            <td style="width: 250px;">{{ $report->waste->printer_cartridges ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Consumption Remarks</td>
            <td style="width: 250px;">{{ $report->waste->consumption_remarks ?? 'N/A' }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="2"><strong>Fresh Water</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Generated</td>
            <td style="width: 250px;">{{ $report->waste->fresh_water_generated ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Consumed</td>
            <td style="width: 250px;">{{ $report->waste->fresh_water_consumed ?? 'N/A' }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="2"><strong>Ballast Water</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Exchanges</td>
            <td style="width: 250px;">{{ $report->waste->ballast_exchanges ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Operations</td>
            <td style="width: 250px;">{{ $report->waste->ballast_operations ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">De-Ballast Operations</td>
            <td style="width: 250px;">{{ $report->waste->deballast_operations ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Ballast Intake</td>
            <td style="width: 250px;">{{ $report->waste->ballast_intake ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Ballast Out</td>
            <td style="width: 250px;">{{ $report->waste->ballast_out ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Exchange Amount</td>
            <td style="width: 250px;">{{ $report->waste->ballast_exchange_amount ?? 'N/A' }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="2"><strong>Master's Info</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Master's Name</td>
            <td style="width: 250px;">{{ $report->master_info->master_info ?? 'N/A' }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="2"><strong>Remarks</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Remarks</td>
            <td style="width: 250px;">{{ $report->remarks->remarks ?? 'N/A' }}</td>
        </tr>
    </table>
@endforeach
