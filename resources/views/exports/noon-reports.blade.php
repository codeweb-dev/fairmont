<table border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse; width: 100%; text-align: left;">
    <thead>
        <tr>
            <th colspan="13">Noon Report Summary</th>
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
                <td>{{ $report->vessel->name }}</td>
            </tr>
            <tr>
                <td>Unit</td>
                <td>{{ $report->unit->name }}</td>
            </tr>
            <tr>
                <td>Date/Time (LT)</td>
                <td>{{ $report->all_fast_datetime }}</td>
            </tr>
            <tr>
                <td>GMT Offset</td>
                <td>{{ $report->gmt_offset }}</td>
            </tr>
            <tr>
                <td>Latitude</td>
                <td>{{ $report->port }}</td>
            </tr>
            <tr>
                <td>Longitude</td>
                <td>{{ $report->bunkering_port }}</td>
            </tr>
            <tr>
                <td>Port of Departure</td>
                <td>{{ $report->supplier ?? 'N/A' }}</td>
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
                    <td>{{ $report->noon_report->cp_ordered_speed }}</td>
                </tr>
                <tr>
                    <td>Allowed M/E Cons. at C/P Speed</td>
                    <td>{{ $report->noon_report->me_cons_cp_speed ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Observed Distance</td>
                    <td>{{ $report->noon_report->obs_distance ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Steaming Time</td>
                    <td>{{ $report->noon_report->steaming_time ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Avg Speed</td>
                    <td>{{ $report->noon_report->avg_speed ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Distance to Go</td>
                    <td>{{ $report->noon_report->distance_to_go ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Course</td>
                    <td>{{ $report->noon_report->course ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Breakdown</td>
                    <td>{{ $report->noon_report->breakdown ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Avg RPM</td>
                    <td>{{ $report->noon_report->avg_rpm ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Engine Distance</td>
                    <td>{{ $report->noon_report->engine_distance ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Slip</td>
                    <td>{{ $report->noon_report->slip ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>M/E Output %MCR</td>
                    <td>{{ $report->noon_report->me_output_mcr ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Avg Power (kW)</td>
                    <td>{{ $report->noon_report->avg_power ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Logged Distance</td>
                    <td>{{ $report->noon_report->logged_distance ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Speed Through Water</td>
                    <td>{{ $report->noon_report->speed_through_water ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Next Port</td>
                    <td>{{ $report->noon_report->next_port ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>ETA Next Port</td>
                    <td>{{ $report->noon_report->eta_next_port ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>ETA GMT Offset</td>
                    <td>{{ $report->noon_report->eta_gmt_offset ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Anchored Hours</td>
                    <td>{{ $report->noon_report->anchored_hours ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Drifting Hours</td>
                    <td>{{ $report->noon_report->drifting_hours ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Maneuvering Hours</td>
                    <td>{{ $report->noon_report->maneuvering_hours ?? 'N/A' }}</td>
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
                    <td>{{ $report->noon_report->condition }}</td>
                </tr>
                <tr>
                    <td>Displacement</td>
                    <td>{{ $report->noon_report->displacement }}</td>
                </tr>
                <tr>
                    <td>Cargo Name</td>
                    <td>{{ $report->noon_report->cargo_name }}</td>
                </tr>
                <tr>
                    <td>Cargo Weight</td>
                    <td>{{ $report->noon_report->cargo_weight }}</td>
                </tr>
                <tr>
                    <td>Ballast Weight</td>
                    <td>{{ $report->noon_report->ballast_weight }}</td>
                </tr>
                <tr>
                    <td>Fresh Water</td>
                    <td>{{ $report->noon_report->fresh_water }}</td>
                </tr>
                <tr>
                    <td>Fwd Draft</td>
                    <td>{{ $report->noon_report->fwd_draft }}</td>
                </tr>
                <tr>
                    <td>Aft Draft</td>
                    <td>{{ $report->noon_report->aft_draft }}</td>
                </tr>
                <tr>
                    <td>GM</td>
                    <td>{{ $report->noon_report->gm }}</td>
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
                    <td>{{ $report->noon_report->wind_force_average_weather }}</td>
                </tr>
                <tr>
                    <td>Swell</td>
                    <td>{{ $report->noon_report->swell }}</td>
                </tr>
                <tr>
                    <td>Sea Current (Kts) (Rel.)</td>
                    <td>{{ $report->noon_report->sea_current }}</td>
                </tr>
                <tr>
                    <td>Sea Temp (Deg. °C)</td>
                    <td>{{ $report->noon_report->sea_temp }}</td>
                </tr>
                <tr>
                    <td>Observed Wind Dir. (T)</td>
                    <td>{{ $report->noon_report->observed_wind }}</td>
                </tr>
                <tr>
                    <td>Wind Sea Height (m)</td>
                    <td>{{ $report->noon_report->wind_sea_height }}</td>
                </tr>
                <tr>
                    <td>Sea Current Direction. (Rel.)</td>
                    <td>{{ $report->noon_report->sea_current_direction }}</td>
                </tr>
                <tr>
                    <td>Swell Height (m)</td>
                    <td>{{ $report->noon_report->swell_height }}</td>
                </tr>
                <tr>
                    <td>Observed Sea Dir. (T)</td>
                    <td>{{ $report->noon_report->observed_sea }}</td>
                </tr>
                <tr>
                    <td>Air Temp (Deg. °C)</td>
                    <td>{{ $report->noon_report->air_temp }}</td>
                </tr>
                <tr>
                    <td>Observed Swell Dir. (T)</td>
                    <td>{{ $report->noon_report->observed_swell }}</td>
                </tr>
                <tr>
                    <td>Sea DS</td>
                    <td>{{ $report->noon_report->sea_ds }}</td>
                </tr>
                <tr>
                    <td>Atm. Pressure (millibar)</td>
                    <td>{{ $report->noon_report->atm_pressure }}</td>
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
                    <td>{{ $report->noon_report->wind_force_previous }}</td>
                </tr>
                <tr>
                    <td>Wind Force (Bft.) (continuous)</td>
                    <td>{{ $report->noon_report->wind_force_current }}</td>
                </tr>
                <tr>
                    <td>Sea State (DS) >0 hrs (since last report)</td>
                    <td>{{ $report->noon_report->sea_state_previous }}</td>
                </tr>
                <tr>
                    <td>Sea State (continuous)</td>
                    <td>{{ $report->noon_report->sea_state_current }}</td>
                </tr>
            @endif

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- WEATHER OBSERVATIONS --}}
            @if ($report->weather_observations && $report->weather_observations->count())
                <tr>
                    <td colspan="13"><strong>Weather (Every 6 Hours)</strong></td>
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
                    <td colspan="5" style="border: 1px solid #000;"></td> {{-- filler cols to make 13 --}}
                </tr>
                @foreach ($report->weather_observations as $w)
                    <tr>
                        <td style="width: 200px; border: 1px solid #000;">{{ $w->time_block }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $w->wind_force }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $w->wind_direction }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $w->swell_height }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $w->swell_direction }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $w->wind_sea_height }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $w->sea_direction }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $w->sea_ds }}</td>
                        <td colspan="5" style="border: 1px solid #000;"></td>
                    </tr>
                @endforeach
            @endif

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- ROB FUEL SUMMARY --}}
            @if ($report->rob_fuel_reports && $report->rob_fuel_reports->count())
                <tr>
                    <td colspan="13"><strong>ROB Fuel Summary</strong></td>
                </tr>
                <tr>
                    <td rowspan="2" style="width: 200px; border: 1px solid #000;"><strong>Fuel Type</strong></td>
                    <td colspan="2" style="width: 200px; border: 1px solid #000;"><strong>ROB (MT)</strong></td>
                    <td colspan="4" style="width: 200px; border: 1px solid #000;"><strong>Consumption</strong></td>
                    <td colspan="2" style="width: 200px; border: 1px solid #000;"><strong>Cons./24 hr</strong></td>
                    <td rowspan="2" style="width: 200px; border: 1px solid #000;"><strong>Total Cons.</strong></td>
                </tr>
                <tr>
                    <td style="width: 200px; border: 1px solid #000;">Previous</td>
                    <td style="width: 200px; border: 1px solid #000;">Current</td>
                    <td style="width: 200px; border: 1px solid #000;">M/E</td>
                    <td style="width: 200px; border: 1px solid #000;">A/E</td>
                    <td style="width: 200px; border: 1px solid #000;">Boiler</td>
                    <td style="width: 200px; border: 1px solid #000;">Incinerators</td>
                    <td style="width: 200px; border: 1px solid #000;">M/E 24</td>
                    <td style="width: 200px; border: 1px solid #000;">A/E 24</td>
                </tr>
                @foreach ($report->rob_fuel_reports as $fuel)
                    <tr>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->fuel_type }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->previous }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->current }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_propulsion }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->ae_cons }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->boiler_cons }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->incinerators }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_24 }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->ae_24 }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->total_cons }}</td>
                    </tr>

                    <tr>
                        <td colspan="13">
                        </td>
                    </tr>

                    <tr>
                        <td rowspan="2" style="width: 200px; border: 1px solid #000;"><strong>Oil Grade</strong></td>
                        <td colspan="3" style="width: 200px; border: 1px solid #000;"><strong>ME CYL</strong></td>
                        <td colspan="3" style="width: 200px; border: 1px solid #000;"><strong>ME CC</strong></td>
                        <td colspan="3" style="width: 200px; border: 1px solid #000;"><strong>AE CC</strong></td>
                    </tr>
                    <tr>
                        <td style="width: 200px; border: 1px solid #000;">Qty</td>
                        <td style="width: 200px; border: 1px solid #000;">Hrs</td>
                        <td style="width: 200px; border: 1px solid #000;">Cons</td>
                        <td style="width: 200px; border: 1px solid #000;">Qty</td>
                        <td style="width: 200px; border: 1px solid #000;">Hrs</td>
                        <td style="width: 200px; border: 1px solid #000;">Cons</td>
                        <td style="width: 200px; border: 1px solid #000;">Qty</td>
                        <td style="width: 200px; border: 1px solid #000;">Hrs</td>
                        <td style="width: 200px; border: 1px solid #000;">Cons</td>
                    </tr>
                    <tr>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cyl_grade }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cyl_qty }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cyl_hrs }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cyl_cons }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cc_qty }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cc_hrs }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cc_cons }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->ae_cc_qty }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->ae_cc_hrs }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->ae_cc_cons }}</td>
                    </tr>
                @endforeach
            @endif

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- ROB TANKS --}}
            @if ($report->rob_tanks && $report->rob_tanks->count())
                <tr>
                    <td colspan="13"><strong>ROB Tanks</strong></td>
                </tr>
                <tr>
                    <td style="width: 200px; border: 1px solid #000;"><strong>Tank No</strong></td>
                    <td style="width: 200px; border: 1px solid #000;"><strong>Description</strong></td>
                    <td style="width: 200px; border: 1px solid #000;"><strong>Grade</strong></td>
                    <td style="width: 200px; border: 1px solid #000;"><strong>Capacity</strong></td>
                    <td style="width: 200px; border: 1px solid #000;"><strong>Unit</strong></td>
                    <td style="width: 200px; border: 1px solid #000;"><strong>ROB</strong></td>
                    <td style="width: 200px; border: 1px solid #000;"><strong>Supply Date</strong></td>
                </tr>
                @foreach ($report->rob_tanks as $tank)
                    <tr>
                        <td style="width: 200px; border: 1px solid #000;">{{ $tank->tank_no }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $tank->description }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $tank->grade }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $tank->capacity }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $tank->unit }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $tank->rob }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $tank->supply_date }}</td>
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
                <td>{{ $report->noon_report->dg1_run_hours }}</td>
            </tr>
            <tr>
                <td>DG2 Run Hours</td>
                <td>{{ $report->noon_report->dg2_run_hours }}</td>
            </tr>
            <tr>
                <td>DG3 Run Hours</td>
                <td>{{ $report->noon_report->dg3_run_hours }}</td>
            </tr>

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- REMARKS / MASTER INFO --}}
            <tr>
                <td><strong>Remarks</strong></td>
                <td colspan="12">{{ optional($report->remarks)->remarks }}</td>
            </tr>

            <tr>
                <td colspan="13">
                </td>
            </tr>

            <tr>
                <td><strong>Master's Info</strong></td>
                <td colspan="12">{{ optional($report->master_info)->master_info }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
