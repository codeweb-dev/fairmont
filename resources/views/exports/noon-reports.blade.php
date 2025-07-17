<table border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse; width: 100%; text-align: left;">
    <thead>
        <tr>
            <th colspan="13"><strong>Noon Report Details</strong></th>
        </tr>

        <tr>
            <td colspan="13">
            </td>
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $report)
            {{-- VOYAGE DETAILS --}}
            <tr>
                <td colspan="13"><strong>Voyage Details</strong></td>
            </tr>
            <tr>
                <td style="width: 200px;">Vessel</td>
                <td style="text-align: left;">{{ $report->vessel->name ?? '' }}</td>
            </tr>
            <tr>
                <td>Vessel User</td>
                <td style="text-align: left;">{{ $report->unit->name ?? '' }}</td>
            </tr>
            <tr>
                <td style="width: 200px;">Voyage No</td>
                <td style="text-align: left;">{{ $report->voyage_no ?? '' }}</td>
            </tr>
            <tr>
                <td style="width: 200px;">Report Type</td>
                <td style="text-align: left;">{{ $report->port_gmt_offset ?? '' }}</td>
            </tr>
            <tr>
                <td>Date/Time (LT)</td>
                <td style="text-align: left;">{{ $report->all_fast_datetime ?? '' }}</td>
            </tr>
            <tr>
                <td>GMT Offset</td>
                <td style="text-align: left;">{{ $report->gmt_offset ?? '' }}</td>
            </tr>
            <tr>
                <td>Latitude</td>
                <td style="text-align: left;">{{ $report->port ?? '' }}</td>
            </tr>
            <tr>
                <td>Longitude</td>
                <td style="text-align: left;">{{ $report->bunkering_port ?? '' }}</td>
            </tr>
            <tr>
                <td>Port of Departure</td>
                <td style="text-align: left;">{{ $report->supplier ?? 'N/A' }}</td>
            </tr>

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- NOON REPORT --}}
            @if ($report->noon_report)
                <tr>
                    <td colspan="13"><strong>Details Since Last Report</strong></td>
                </tr>
                <tr>
                    <td>CP/Ordered Speed (Kts)</td>
                    <td style="text-align: left;">{{ $report->noon_report->cp_ordered_speed ?? '' }}</td>
                </tr>
                <tr>
                    <td>Allowed M/E Cons. at C/P Speed</td>
                    <td style="text-align: left;">{{ $report->noon_report->me_cons_cp_speed ?? '' }}</td>
                </tr>
                <tr>
                    <td>Observed Distance (NM)</td>
                    <td style="text-align: left;">{{ $report->noon_report->obs_distance ?? '' }}</td>
                </tr>
                <tr>
                    <td>Steaming Time (Hrs)</td>
                    <td style="text-align: left;">{{ $report->noon_report->steaming_time ?? '' }}</td>
                </tr>
                <tr>
                    <td>Avg Speed (Kts)</td>
                    <td style="text-align: left;">{{ $report->noon_report->avg_speed ?? '' }}</td>
                </tr>
                <tr>
                    <td>Distance to go (Nm)</td>
                    <td style="text-align: left;">{{ $report->noon_report->distance_to_go ?? '' }}</td>
                </tr>
                <tr>
                    <td>Course (Deg)</td>
                    <td style="text-align: left;">{{ $report->noon_report->course ?? '' }}</td>
                </tr>
                <tr>
                    <td>Breakdown (Hrs)</td>
                    <td style="text-align: left;">{{ $report->noon_report->breakdown ?? '' }}</td>
                </tr>
                <tr>
                    <td>Avg RPM</td>
                    <td style="text-align: left;">{{ $report->noon_report->avg_rpm ?? '' }}</td>
                </tr>
                <tr>
                    <td>Engine Distance (NM)</td>
                    <td style="text-align: left;">{{ $report->noon_report->engine_distance ?? '' }}</td>
                </tr>
                <tr>
                    <td>Slip (%)</td>
                    <td style="text-align: left;">{{ $report->noon_report->slip ?? '' }}</td>
                </tr>
                <tr>
                    <td>M/E Output (%MCR)</td>
                    <td style="text-align: left;">{{ $report->noon_report->me_output_mcr ?? '' }}</td>
                </tr>
                <tr>
                    <td>Avg Power (kW)</td>
                    <td style="text-align: left;">{{ $report->noon_report->avg_power ?? '' }}</td>
                </tr>
                <tr>
                    <td>Logged Distance (NM)</td>
                    <td style="text-align: left;">{{ $report->noon_report->logged_distance ?? '' }}</td>
                </tr>
                <tr>
                    <td>Speed Through Water (Kts)</td>
                    <td style="text-align: left;">{{ $report->noon_report->speed_through_water ?? '' }}</td>
                </tr>
                <tr>
                    <td>Next Port</td>
                    <td style="text-align: left;">{{ $report->noon_report->next_port ?? '' }}</td>
                </tr>
                <tr>
                    <td>ETA Next Port</td>
                    <td style="text-align: left;">{{ $report->noon_report->eta_next_port ?? '' }}</td>
                </tr>
                <tr>
                    <td>ETA GMT Offset</td>
                    <td style="text-align: left;">{{ $report->noon_report->eta_gmt_offset ?? '' }}</td>
                </tr>
                <tr>
                    <td>Anchored Hours</td>
                    <td style="text-align: left;">{{ $report->noon_report->anchored_hours ?? '' }}</td>
                </tr>
                <tr>
                    <td>Drifting Hours</td>
                    <td style="text-align: left;">{{ $report->noon_report->drifting_hours ?? '' }}</td>
                </tr>
                <tr>
                    <td>Maneuvering Hours</td>
                    <td style="text-align: left;">{{ $report->noon_report->maneuvering_hours ?? '' }}</td>
                </tr>

                <tr>
                    <td colspan="13">
                    </td>
                </tr>

                {{-- NOON CONDITIONS --}}
                <tr>
                    <td colspan="13"><strong>Noon Conditions</strong></td>
                </tr>
                <tr>
                    <td>Condition</td>
                    <td style="text-align: left;">{{ $report->noon_report->condition ?? '' }}</td>
                </tr>
                <tr>
                    <td>Displacement (MT)</td>
                    <td style="text-align: left;">{{ $report->noon_report->displacement ?? '' }}</td>
                </tr>
                <tr>
                    <td>Cargo Name</td>
                    <td style="text-align: left;">{{ $report->noon_report->cargo_name ?? '' }}</td>
                </tr>
                <tr>
                    <td>Cargo Weight (MT)</td>
                    <td style="text-align: left;">{{ $report->noon_report->cargo_weight ?? '' }}</td>
                </tr>
                <tr>
                    <td>Ballast Weight (MT)</td>
                    <td style="text-align: left;">{{ $report->noon_report->ballast_weight ?? '' }}</td>
                </tr>
                <tr>
                    <td>Fresh Water (MT)</td>
                    <td style="text-align: left;">{{ $report->noon_report->fresh_water ?? '' }}</td>
                </tr>
                <tr>
                    <td>Fwd Draft (m)</td>
                    <td style="text-align: left;">{{ $report->noon_report->fwd_draft ?? '' }}</td>
                </tr>
                <tr>
                    <td>Aft Draft (m)</td>
                    <td style="text-align: left;">{{ $report->noon_report->aft_draft ?? '' }}</td>
                </tr>
                <tr>
                    <td>GM</td>
                    <td style="text-align: left;">{{ $report->noon_report->gm ?? '' }}</td>
                </tr>

                <tr>
                    <td colspan="13">
                    </td>
                </tr>

                {{-- VOYAGE ITINERARY --}}
                <tr>
                    <td colspan="13"><strong>Voyage Itinerary</strong></td>
                </tr>
                <tr>
                    <td>Next Port</td>
                    <td style="text-align: left;">{{ $report->noon_report->next_port_voyage ?? '' }}</td>
                </tr>
                <tr>
                    <td>Via</td>
                    <td style="text-align: left;">{{ $report->noon_report->via ?? '' }}</td>
                </tr>
                <tr>
                    <td>ETA (LT)</td>
                    <td style="text-align: left;">{{ $report->noon_report->eta_lt ?? '' }}</td>
                </tr>
                <tr>
                    <td>GMT Offset</td>
                    <td style="text-align: left;">{{ $report->noon_report->gmt_offset_voyage ?? '' }}</td>
                </tr>
                <tr>
                    <td>Distance to go</td>
                    <td style="text-align: left;">{{ $report->noon_report->distance_to_go_voyage ?? '' }}</td>
                </tr>
                <tr>
                    <td>Projected Speed (kts)</td>
                    <td style="text-align: left;">{{ $report->noon_report->projected_speed ?? '' }}</td>
                </tr>

                <tr>
                    <td colspan="13">
                    </td>
                </tr>

                <tr>
                    <td colspan="13"><strong>Average Weather</strong></td>
                </tr>
                <tr>
                    <td>Wind Force (Bft.) (T)</td>
                    <td style="text-align: left;">{{ $report->noon_report->wind_force_average_weather ?? '' }}</td>
                </tr>
                <tr>
                    <td>Swell</td>
                    <td style="text-align: left;">{{ $report->noon_report->swell ?? '' }}</td>
                </tr>
                <tr>
                    <td>Sea Current (Kts) (Rel.)</td>
                    <td style="text-align: left;">{{ $report->noon_report->sea_current ?? '' }}</td>
                </tr>
                <tr>
                    <td>Sea Temp (Deg. °C)</td>
                    <td style="text-align: left;">{{ $report->noon_report->sea_temp ?? '' }}</td>
                </tr>
                <tr>
                    <td>Observed Wind Dir. (T)</td>
                    <td style="text-align: left;">{{ $report->noon_report->observed_wind ?? '' }}</td>
                </tr>
                <tr>
                    <td>Wind Sea Height (m)</td>
                    <td style="text-align: left;">{{ $report->noon_report->wind_sea_height ?? '' }}</td>
                </tr>
                <tr>
                    <td>Sea Current Direction. (Rel.)</td>
                    <td style="text-align: left;">{{ $report->noon_report->sea_current_direction ?? '' }}</td>
                </tr>
                <tr>
                    <td>Swell Height (m)</td>
                    <td style="text-align: left;">{{ $report->noon_report->swell_height ?? '' }}</td>
                </tr>
                <tr>
                    <td>Observed Sea Dir. (T)</td>
                    <td style="text-align: left;">{{ $report->noon_report->observed_sea ?? '' }}</td>
                </tr>
                <tr>
                    <td>Air Temp (Deg. °C)</td>
                    <td style="text-align: left;">{{ $report->noon_report->air_temp ?? '' }}</td>
                </tr>
                <tr>
                    <td>Observed Swell Dir. (T)</td>
                    <td style="text-align: left;">{{ $report->noon_report->observed_swell ?? '' }}</td>
                </tr>
                <tr>
                    <td>Sea DS</td>
                    <td style="text-align: left;">{{ $report->noon_report->sea_ds ?? '' }}</td>
                </tr>
                <tr>
                    <td>Atm. Pressure (millibar)</td>
                    <td style="text-align: left;">{{ $report->noon_report->atm_pressure ?? '' }}</td>
                </tr>

                <tr>
                    <td colspan="13">
                    </td>
                </tr>
                <tr>
                    <td colspan="13"><strong>Bad Weather Details</strong></td>
                </tr>
                <tr>
                    <td>Wind force (Bft.) >0 hrs (since last report)</td>
                    <td style="text-align: left;">{{ $report->noon_report->wind_force_previous ?? '' }}</td>
                </tr>
                <tr>
                    <td>Wind Force (Bft.) (continuous)</td>
                    <td style="text-align: left;">{{ $report->noon_report->wind_force_current ?? '' }}</td>
                </tr>
                <tr>
                    <td>Sea State (DS) >0 hrs (since last report)</td>
                    <td style="text-align: left;">{{ $report->noon_report->sea_state_previous ?? '' }}</td>
                </tr>
                <tr>
                    <td>Sea State (continuous)</td>
                    <td style="text-align: left;">{{ $report->noon_report->sea_state_current ?? '' }}</td>
                </tr>
            @endif

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- WEATHER OBSERVATIONS --}}
            @if ($report->weather_observations && $report->weather_observations->count())
                <tr>
                    <td colspan="13"><strong>Wind & Sea (Every 6 Hours)</strong></td>
                </tr>
                <tr>
                    <td style="width: 200px; border: 1px solid #000;"><strong>Time Block</strong></td>
                    <td style="width: 200px; border: 1px solid #000;"><strong>Wind Force</strong></td>
                    <td style="width: 200px; border: 1px solid #000;"><strong>Wind Dir</strong></td>
                    <td style="width: 200px; border: 1px solid #000;"><strong>Swell Height</strong></td>
                    <td style="width: 200px; border: 1px solid #000;"><strong>Swell Dir</strong></td>
                    <td style="width: 200px; border: 1px solid #000;"><strong>Wind Sea Height</strong></td>
                    <td style="width: 200px; border: 1px solid #000;"><strong>Sea Dir</strong></td>
                    <td style="width: 200px; border: 1px solid #000;"><strong>Sea DS</strong></td>
                </tr>
                @foreach ($report->weather_observations as $w)
                    <tr>
                        <td style="width: 200px; border: 1px solid #000; text-align: left;">{{ $w->time_block ?? '' }}</td>
                        <td style="width: 200px; border: 1px solid #000; text-align: left;">{{ $w->wind_force ?? '' }}</td>
                        <td style="width: 200px; border: 1px solid #000; text-align: left;">{{ $w->wind_direction ?? '' }}</td>
                        <td style="width: 200px; border: 1px solid #000; text-align: left;">{{ $w->swell_height ?? '' }}</td>
                        <td style="width: 200px; border: 1px solid #000; text-align: left;">{{ $w->swell_direction ?? '' }}</td>
                        <td style="width: 200px; border: 1px solid #000; text-align: left;">{{ $w->wind_sea_height ?? '' }}</td>
                        <td style="width: 200px; border: 1px solid #000; text-align: left;">{{ $w->sea_direction }}</td>
                        <td style="width: 200px; border: 1px solid #000; text-align: left;">{{ $w->sea_ds ?? '' }}</td>
                    </tr>
                @endforeach
            @endif

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- ROB DETAILS --}}
            <tr>
                <td colspan="13"><strong>ROB Summary</strong></td>
            </tr>

            @php
                $groupedTanks = $report->rob_tanks->groupBy('grade');
            @endphp

            @foreach ($groupedTanks as $grade => $tanks)
                {{-- Fuel Grade Header --}}
                <tr>
                    <td colspan="13" style="font-weight: bold; padding-top: 10px;">{{ strtoupper($grade) }}</td>
                </tr>
                {{-- Table Headers --}}
                <tr>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Tank No</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Description</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Fuel Grade</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Capacity</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Unit</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>ROB (MT)</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Supply Date (LT)</strong></td>
                </tr>
                @foreach ($tanks as $tank)
                    <tr>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $tank->tank_no }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $tank->description }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $tank->grade }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $tank->capacity }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $tank->unit }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $tank->rob }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">
                            {{ $tank->supply_date ? \Carbon\Carbon::parse($tank->supply_date)->format('M d, Y h:i A') : '-' }}
                        </td>
                    </tr>
                @endforeach
            @endforeach

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- ROB CONSUMPTION TABLE --}}
            @if ($report->rob_fuel_reports && $report->rob_fuel_reports->count())
                {{-- Table Headers --}}
                <tr>
                    <td rowspan="2" style="border: 1px solid #000; padding: 5px; text-align: center;"><strong>Bunker
                            Type</strong></td>
                    <td colspan="2" style="border: 1px solid #000; padding: 5px; text-align: center;"><strong>ROB (in
                            MT)</strong></td>
                    <td colspan="4" style="border: 1px solid #000; padding: 5px; text-align: center;">
                        <strong>Consumption</strong>
                    </td>
                    <td colspan="2" style="border: 1px solid #000; padding: 5px; text-align: center;">
                        <strong>Cons./24hr</strong>
                    </td>
                    <td rowspan="2" style="border: 1px solid #000; padding: 5px; text-align: center;"><strong>Total
                            Cons.</strong></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000; padding: 5px;"><strong>Previous</strong></td>
                    <td style="border: 1px solid #000; padding: 5px;"><strong>Current</strong></td>
                    <td style="border: 1px solid #000; padding: 5px;"><strong>M/E Propulsion</strong></td>
                    <td style="border: 1px solid #000; padding: 5px;"><strong>A/E Cons.</strong></td>
                    <td style="border: 1px solid #000; padding: 5px;"><strong>Boiler Cons.</strong></td>
                    <td style="border: 1px solid #000; padding: 5px;"><strong>Incinerators</strong></td>
                    <td style="border: 1px solid #000; padding: 5px;"><strong>M/E 24hr</strong></td>
                    <td style="border: 1px solid #000; padding: 5px;"><strong>A/E 24hr</strong></td>
                </tr>

                @foreach ($report->rob_fuel_reports as $fuel)
                    <tr>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->fuel_type }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->previous }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->current }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->me_propulsion }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->ae_cons }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->boiler_cons }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->incinerators }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->me_24 }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->ae_24 }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->total_cons }}</td>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="13">
                    </td>
                </tr>

                {{-- Lube Oil Subtable --}}
                <tr>
                    <td colspan="4" style="border: 1px solid #000; padding: 5px; text-align: center;"><strong>ME
                            CYL</strong></td>
                    <td colspan="3" style="border: 1px solid #000; padding: 5px; text-align: center;"><strong>ME
                            CC</strong></td>
                    <td colspan="3" style="border: 1px solid #000; padding: 5px; text-align: center;"><strong>AE
                            CC</strong></td>
                </tr>
                <tr>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Oil Grade</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Oil Qty</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Total Run Hrs.</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Oil Cons.</strong></td>

                    <td style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Total Run Hrs.</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Oil Cons.</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Oil Qty</strong></td>

                    <td style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Total Run Hrs.</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Oil Cons.</strong></td>
                    <td style="border: 1px solid #000; padding: 5px; text-align: left;"><strong>Oil Qty</strong></td>
                </tr>
                @foreach ($report->rob_fuel_reports as $fuel)
                    <tr>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->me_cyl_grade }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->me_cyl_qty }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->me_cyl_hrs }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->me_cyl_cons }}</td>

                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->me_cc_cons }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->me_cc_qty }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->me_cc_hrs }}</td>

                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->ae_cc_cons }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->ae_cc_qty }}</td>
                        <td style="border: 1px solid #000; padding: 5px; text-align: left;">{{ $fuel->ae_cc_hrs }}</td>
                    </tr>
                @endforeach
            @endif

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- DIESEL ENGINE HOURS --}}
            <tr>
                <td colspan="13"><strong>Diesel Engine Hours</strong></td>
            </tr>
            <tr>
                <td>DG1 Run Hours</td>
                <td style="text-align: left;">{{ $report->noon_report->dg1_run_hours ?? '' }}</td>
            </tr>
            <tr>
                <td>DG2 Run Hours</td>
                <td style="text-align: left;">{{ $report->noon_report->dg2_run_hours ?? '' }}</td>
            </tr>
            <tr>
                <td>DG3 Run Hours</td>
                <td style="text-align: left;">{{ $report->noon_report->dg3_run_hours ?? '' }}</td>
            </tr>

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- REMARKS / MASTER INFO --}}
            <tr>
                <td><strong>Remarks</strong></td>
                <td style="text-align: left;">{{ optional($report->remarks)->remarks ?? '' }}</td>
            </tr>

            <tr>
                <td colspan="13">
                </td>
            </tr>

            <tr>
                <td><strong>Master Information</strong></td>
                <td style="text-align: left;">{{ optional($report->master_info)->master_info ?? '' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
