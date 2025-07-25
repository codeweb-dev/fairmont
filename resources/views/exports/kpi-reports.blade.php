@foreach ($reports as $report)
    <table>
        <tr>
            <td colspan="6" style="font-weight: bold;">KPI Report Details</td>
        </tr>
        <tr>
            <td></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Bunkering Details</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Vessel</td>
            <td style="width: 250px; text-align: left;">{{ $report->vessel->name ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Report Type</td>
            <td style="width: 250px; text-align: left;">{{ $report->report_type ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Reporting Period</td>
            <td style="width: 250px; text-align: left;">
                {{ $report->all_fast_datetime ? \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') : '' }}
            </td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="2"><strong>Waste Management</strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Plastics</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Landed Ashore (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->plastics_landed_ashore ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Incinerated (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->plastics_incinerated ?? '' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Food Waste</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Disposed at Sea (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->food_disposed_sea ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Landed Ashore (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->food_landed_ashore ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Incinerated (In m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->food_total_incinerated ?? '' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Domestic Waste</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Landed Ashore (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->domestic_landed_ashore ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Incinerated (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->domestic_incinerated ?? '' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Cooking Oil</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Landed Ashore (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->cooking_oil_landed_ashore ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Incinerated (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->cooking_oil_incinerated ?? '' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Incinerator Ash</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Landed Ashore (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->incinerator_ash_landed_ashore ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Incinerated (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->incinerator_ash_incinerated ?? '' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Operational Waste</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Landed Ashore (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->operational_landed_ashore ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Incinerated (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->operational_incinerated ?? '' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>E-Waste</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Landed Ashore (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->ewaste_landed_ashore ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Incinerated In (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->ewaste_landed_total_incinerated ?? '' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Cargo Residues</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Landed Ashore (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->cargo_residues_landed_ashore ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Disposed at Sea (In m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->cargo_residues_disposed_at_sea ?? '' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Total Garbage</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Disposed at Sea (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->total_garbage_disposed_sea ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Garbage Landed Ashore (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->total_garbage_landed_ashore ?? '' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Sludge & Bunker</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Landed Ashore (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->sludge_landed_ashore ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Incinerated (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->sludge_incinerated ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Quantity of Sludge Generated (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->sludge_generated ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Fuel Consumed (MT)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->fuel_consumed ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Ratio of Sludge Generated to Bunkers Consumed</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->sludge_bunker_ratio ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Remarks (if target exceeded)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->sludge_remarks ?? '' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Bilge Water</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Bilge Water Discharged Through OWS (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->bilge_discharged_ows ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Bilge Water Landed to Shore (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->bilge_landed_ashore ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Bilge Water Generated (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->bilge_generated ?? '' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Consumption</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Paper Consumption (reams)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->paper_consumption ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Printer Cartridges (units)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->printer_cartridges ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Remarks (if target exceeded)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->consumption_remarks ?? '' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Fresh Water</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Fresh Water Generated (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->fresh_water_generated ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Fresh Water Consumed (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->fresh_water_consumed ?? '' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Ballast Water</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Number of Ballast Water Exchanges Performed</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->ballast_exchanges ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Number of Ballast Operations</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->ballast_operations ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Number of De-Ballast Operations</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->deballast_operations ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Water Intake During Ballasting (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->ballast_intake ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Water Out During De-Ballasting (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->ballast_out ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Ballast Water Exchange Amount (m3)</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->ballast_exchange_amount ?? '' }}</td>
        </tr>

        <tr>
            <td colspan="2"><strong></strong></td>
        </tr>

        <tr>
            <td colspan="2"><strong>Hull Management</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Number of Propeller Cleanings</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->propeller_cleanings ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Total Number of Hull Cleanings</td>
            <td style="width: 250px; text-align: left;">{{ $report->waste->hull_cleanings ?? '' }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="2"><strong>Voyage Report</strong></td>
        </tr>

        <tr>
            <td style="width: 250px;">Total</td>
            <td style="width: 250px; text-align: left;">{{ $report->call_sign ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Eco Speed</td>
            <td style="width: 250px; text-align: left;">{{ $report->flag ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Full Speed</td>
            <td style="width: 250px; text-align: left;">{{ $report->port_of_registry ?? '' }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="2"><strong>Crew Matter</strong></td>
        </tr>

        <tr>
            <td style="width: 250px;">No. of Fatalities</td>
            <td style="width: 250px; text-align: left;">{{ $report->official_number ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">LTI (Lost Time Injuries)</td>
            <td style="width: 250px; text-align: left;">{{ $report->imo_number ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">No. of Recordable Injuries</td>
            <td style="width: 250px; text-align: left;">{{ $report->class_society ?? '' }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="2"><strong>Corruption</strong></td>
        </tr>

        <tr>
            <td style="width: 250px;">No. of Corruption/Bribery/Entertainment for Port Officials</td>
            <td style="width: 250px; text-align: left;">{{ $report->class_no ?? '' }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="2"><strong>Inspection</strong></td>
        </tr>

        <tr>
            <td style="width: 250px;">Number of PSC Inspections</td>
            <td style="width: 250px; text-align: left;">{{ $report->pi_club ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">PSC No. of Deficiencies</td>
            <td style="width: 250px; text-align: left;">{{ $report->loa ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">PSC Detentions (if any)</td>
            <td style="width: 250px; text-align: left;">{{ $report->lbp ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Number of Flag State Inspections</td>
            <td style="width: 250px; text-align: left;">{{ $report->breadth_extreme ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Flag No. of Deficiencies</td>
            <td style="width: 250px; text-align: left;">{{ $report->depth_moulded ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Third Party Inspections (Charterers, Owners, RISQ, Others)</td>
            <td style="width: 250px; text-align: left;">{{ $report->height_maximum ?? '' }}</td>
        </tr>
        <tr>
            <td style="width: 250px;">Third Party No. of Deficiencies</td>
            <td style="width: 250px; text-align: left;">{{ $report->bridge_front_bow ?? '' }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="2"><strong>Overall Remarks</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Overall Remarks</td>
            <td style="width: 250px; text-align: left;">{{ $report->remarks->remarks ?? '' }}</td>
        </tr>
    </table>

    <table>
        <tr>
            <td colspan="2"><strong>Master Information</strong></td>
        </tr>
        <tr>
            <td style="width: 250px;">Master's Name</td>
            <td style="width: 250px; text-align: left;">{{ $report->master_info->master_info ?? '' }}</td>
        </tr>
    </table>
@endforeach
