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
            <td style="width: 250px;">Reporting Period</td>
            <td style="width: 250px;">
                {{ $report->all_fast_datetime ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') : 'N/A' }}
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="2"><strong>Waste Management</strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Plastics</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Landed Ashore (m3)</td>
            <td style="width: 250px;">{{ $report->waste->plastics_landed_ashore ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Incinerated (m3)</td>
            <td style="width: 250px;">{{ $report->waste->plastics_incinerated ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Food Waste</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Disposed at Sea (m3)</td>
            <td style="width: 250px;">{{ $report->waste->food_disposed_sea ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Landed Ashore (m3)</td>
            <td style="width: 250px;">{{ $report->waste->food_landed_ashore ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Domestic Waste</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Landed Ashore (m3)</td>
            <td style="width: 250px;">{{ $report->waste->domestic_landed_ashore ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Incinerated (m3)</td>
            <td style="width: 250px;">{{ $report->waste->domestic_incinerated ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Cooking Oil</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Landed Ashore (m3)</td>
            <td style="width: 250px;">{{ $report->waste->cooking_oil_landed_ashore ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Incinerated (m3)</td>
            <td style="width: 250px;">{{ $report->waste->cooking_oil_incinerated ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Incinerator Ash</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Landed Ashore (m3)</td>
            <td style="width: 250px;">{{ $report->waste->incinerator_ash_landed_ashore ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Incinerated (m3)</td>
            <td style="width: 250px;">{{ $report->waste->incinerator_ash_incinerated ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Operational Waste</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Landed Ashore (m3)</td>
            <td style="width: 250px;">{{ $report->waste->operational_landed_ashore ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Incinerated (m3)</td>
            <td style="width: 250px;">{{ $report->waste->operational_incinerated ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>E-Waste</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Landed Ashore (m3)</td>
            <td style="width: 250px;">{{ $report->waste->ewaste_landed_ashore ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Cargo Residues J/K</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Landed Ashore (m3)</td>
            <td style="width: 250px;">{{ $report->waste->cargo_residues_landed_ashore ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Total Garbage</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Disposed at Sea (m3)</td>
            <td style="width: 250px;">{{ $report->waste->total_garbage_disposed_sea ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Garbage Landed Ashore (m3)</td>
            <td style="width: 250px;">{{ $report->waste->total_garbage_landed_ashore ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Sludge & Bunker</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Landed Ashore (m3)</td>
            <td style="width: 250px;">{{ $report->waste->sludge_landed_ashore ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Incinerated (m3)</td>
            <td style="width: 250px;">{{ $report->waste->sludge_incinerated ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Quantity of Sludge Generated (m3)</td>
            <td style="width: 250px;">{{ $report->waste->sludge_generated ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Fuel Consumed (MT)</td>
            <td style="width: 250px;">{{ $report->waste->fuel_consumed ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Ratio of Sludge Generated to Bunkers Consumed</td>
            <td style="width: 250px;">{{ $report->waste->sludge_bunker_ratio ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Remarks (if target exceeded)</td>
            <td style="width: 250px;">{{ $report->waste->sludge_remarks ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Bilge Water</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Bilge Water Discharged Through OWS (m3)</td>
            <td style="width: 250px;">{{ $report->waste->bilge_discharged_ows ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Bilge Water Landed to Shore (m3)</td>
            <td style="width: 250px;">{{ $report->waste->bilge_landed_ashore ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Bilge Water Generated (m3)</td>
            <td style="width: 250px;">{{ $report->waste->bilge_generated ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Consumption</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Paper Consumption (reams)</td>
            <td style="width: 250px;">{{ $report->waste->paper_consumption ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Printer Cartridges (units)</td>
            <td style="width: 250px;">{{ $report->waste->printer_cartridges ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Remarks (if target exceeded)</td>
            <td style="width: 250px;">{{ $report->waste->consumption_remarks ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Fresh Water</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Fresh Water Generated (m3)</td>
            <td style="width: 250px;">{{ $report->waste->fresh_water_generated ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Fresh Water Consumed (m3)</td>
            <td style="width: 250px;">{{ $report->waste->fresh_water_consumed ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Ballast Water</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Number of Ballast Water Exchanges Performed</td>
            <td style="width: 250px;">{{ $report->waste->ballast_exchanges ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Number of Ballast Operations</td>
            <td style="width: 250px;">{{ $report->waste->ballast_operations ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Number of De-Ballast Operations</td>
            <td style="width: 250px;">{{ $report->waste->deballast_operations ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Water Intake During Ballasting (m3)</td>
            <td style="width: 250px;">{{ $report->waste->ballast_intake ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Water Out During De-Ballasting (m3)</td>
            <td style="width: 250px;">{{ $report->waste->ballast_out ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Ballast Water Exchange Amount (m3)</td>
            <td style="width: 250px;">{{ $report->waste->ballast_exchange_amount ?? 'N/A' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Ballast Water</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Number of Propeller Cleanings</td>
            <td style="width: 250px;">{{ $report->waste->propeller_cleanings ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Number of Hull Cleanings</td>
            <td style="width: 250px;">{{ $report->waste->hull_cleanings ?? 'N/A' }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="2"><strong>Voyage Report</strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td style="width: 250px;">Total Sailing Days</td>
            <td style="width: 250px;">{{ $report->call_sign ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Eco Speed Sailing Days</td>
            <td style="width: 250px;">{{ $report->flag ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Full Speed Sailing Days</td>
            <td style="width: 250px;">{{ $report->port_of_registry ?? 'N/A' }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="2"><strong>Crew</strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td style="width: 250px;">No. of Fatalities</td>
            <td style="width: 250px;">{{ $report->official_number ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">LTI (Lost Time Injuries)</td>
            <td style="width: 250px;">{{ $report->imo_number ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">No. of Recordable Injuries</td>
            <td style="width: 250px;">{{ $report->class_society ?? 'N/A' }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="2"><strong>MACN</strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td style="width: 250px;">No. of Corruption/Bribery/Entertainment for Port Officials</td>
            <td style="width: 250px;">{{ $report->class_no ?? 'N/A' }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="2"><strong>Inspection</strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td style="width: 250px;">Number of PSC Inspections</td>
            <td style="width: 250px;">{{ $report->pi_club ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">PSC No. of Deficiencies</td>
            <td style="width: 250px;">{{ $report->loa ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">PSC Detentions (if any)</td>
            <td style="width: 250px;">{{ $report->lbp ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Number of Flag State Inspections</td>
            <td style="width: 250px;">{{ $report->breadth_extreme ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Flag No. of Deficiencies</td>
            <td style="width: 250px;">{{ $report->depth_moulded ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Third Party Inspections (Charterers, Owners, RISQ, Others)</td>
            <td style="width: 250px;">{{ $report->height_maximum ?? 'N/A' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Third Party No. of Deficiencies</td>
            <td style="width: 250px;">{{ $report->bridge_front_bow ?? 'N/A' }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="2"><strong>Overall Remarks</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Overall Remarks</td>
            <td style="width: 250px;">{{ $report->remarks->remarks ?? 'N/A' }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="2"><strong>Master Information</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Master's Name</td>
            <td style="width: 250px;">{{ $report->master_info->master_info ?? 'N/A' }}</td>
        </tr>
    </table>
@endforeach
