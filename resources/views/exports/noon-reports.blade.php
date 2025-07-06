<table border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse; width: 100%; text-align: left;">
    <thead>
        <tr>
            <th colspan="13"><strong>Noon Report Summary</strong></th>
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
                <td>{{ $report->vessel->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Vessel User</td>
                <td>{{ $report->unit->name ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="width: 200px;">Voyage No</td>
                <td>{{ $report->voyage_no ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td style="width: 200px;">Report Type</td>
                <td>{{ $report->port_gmt_offset ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Date/Time (LT)</td>
                <td>{{ $report->all_fast_datetime ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>GMT Offset</td>
                <td>{{ $report->gmt_offset ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Latitude</td>
                <td>{{ $report->port ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>Longitude</td>
                <td>{{ $report->bunkering_port ?? 'N/A' }}</td>
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
                    <td>{{ $report->noon_report->cp_ordered_speed ?? 'N/A' }}</td>
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
                    <td>{{ $report->noon_report->condition ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Displacement</td>
                    <td>{{ $report->noon_report->displacement ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Cargo Name</td>
                    <td>{{ $report->noon_report->cargo_name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Cargo Weight</td>
                    <td>{{ $report->noon_report->cargo_weight ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Ballast Weight</td>
                    <td>{{ $report->noon_report->ballast_weight ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Fresh Water</td>
                    <td>{{ $report->noon_report->fresh_water ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Fwd Draft</td>
                    <td>{{ $report->noon_report->fwd_draft ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Aft Draft</td>
                    <td>{{ $report->noon_report->aft_draft ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>GM</td>
                    <td>{{ $report->noon_report->gm ?? 'N/A' }}</td>
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
                    <td>{{ $report->noon_report->wind_force_average_weather ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Swell</td>
                    <td>{{ $report->noon_report->swell ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Sea Current (Kts) (Rel.)</td>
                    <td>{{ $report->noon_report->sea_current ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Sea Temp (Deg. °C)</td>
                    <td>{{ $report->noon_report->sea_temp ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Observed Wind Dir. (T)</td>
                    <td>{{ $report->noon_report->observed_wind ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Wind Sea Height (m)</td>
                    <td>{{ $report->noon_report->wind_sea_height ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Sea Current Direction. (Rel.)</td>
                    <td>{{ $report->noon_report->sea_current_direction ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Swell Height (m)</td>
                    <td>{{ $report->noon_report->swell_height ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Observed Sea Dir. (T)</td>
                    <td>{{ $report->noon_report->observed_sea ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Air Temp (Deg. °C)</td>
                    <td>{{ $report->noon_report->air_temp ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Observed Swell Dir. (T)</td>
                    <td>{{ $report->noon_report->observed_swell ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Sea DS</td>
                    <td>{{ $report->noon_report->sea_ds ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Atm. Pressure (millibar)</td>
                    <td>{{ $report->noon_report->atm_pressure ?? 'N/A' }}</td>
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
                    <td>{{ $report->noon_report->wind_force_previous ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Wind Force (Bft.) (continuous)</td>
                    <td>{{ $report->noon_report->wind_force_current ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Sea State (DS) >0 hrs (since last report)</td>
                    <td>{{ $report->noon_report->sea_state_previous ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td>Sea State (continuous)</td>
                    <td>{{ $report->noon_report->sea_state_current ?? 'N/A' }}</td>
                </tr>
            @endif

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- WEATHER OBSERVATIONS --}}
            @if ($report->weather_observations && $report->weather_observations->count())
                <tr>
                    <td colspan="13"><strong>Wind Force/Dir for every six hours</strong></td>
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
                        <td style="width: 200px; border: 1px solid #000;">{{ $w->time_block ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $w->wind_force ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $w->wind_direction ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $w->swell_height ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $w->swell_direction ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $w->wind_sea_height ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $w->sea_direction }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $w->sea_ds ?? 'N/A' }}</td>
                    </tr>
                @endforeach
            @endif

            <tr>
                <td colspan="13">
                </td>
            </tr>

            <tr>
                <td><strong>ROB Details</strong></td>
            </tr>

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- ROB TANK TABLE --}}
            @if ($report->rob_tanks && $report->rob_tanks->count())
                <tr>
                    <td style="width: 200px; border: 1px solid #000;"><strong>Tank No</strong></td>
                    <td style="width: 200px; border: 1px solid #000;"><strong>Description</strong></td>
                    <td style="width: 200px; border: 1px solid #000;"><strong>Fuel Grade</strong></td>
                    <td style="width: 200px; border: 1px solid #000;"><strong>Capacity</strong></td>
                    <td style="width: 200px; border: 1px solid #000;"><strong>Unit</strong></td>
                    <td style="width: 200px; border: 1px solid #000;"><strong>ROB (MT)</strong></td>
                    <td style="width: 200px; border: 1px solid #000;"><strong>Supply Date (LT)</strong></td>
                </tr>
                @foreach ($report->rob_tanks as $tank)
                    <tr>
                        <td style="width: 200px; border: 1px solid #000;">{{ $tank->tank_no ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $tank->description ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $tank->grade ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $tank->capacity ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $tank->unit ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $tank->rob ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">
                            {{ $tank->supply_date ? \Carbon\Carbon::parse($tank->supply_date)->format('M d, Y h:i A') : '-' }}
                        </td>
                    </tr>
                @endforeach
            @endif

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- ROB CONSUMPTION TABLE --}}
            @if ($report->rob_fuel_reports && $report->rob_fuel_reports->count())
                @foreach ($report->rob_fuel_reports->groupBy('fuel_type') as $fuelType => $groupedFuels)
                    {{-- Header --}}
                    <tr>
                        <th style="border: 1px solid #000; text-align: center;" rowspan="2"><strong>Bunker
                                Type</strong></th>
                        <th style="border: 1px solid #000; text-align: center;" colspan="2"><strong>ROB (in
                                MT)</strong></th>
                        <th style="border: 1px solid #000; text-align: center;" colspan="4">
                            <strong>Consumption</strong></th>
                        <th style="border: 1px solid #000; text-align: center;" colspan="2">
                            <strong>Cons./24hr</strong></th>
                        <th style="border: 1px solid #000; text-align: center;" rowspan="2"><strong>Total
                                Cons.</strong></th>
                    </tr>
                    <tr>
                        <th style="border: 1px solid #000; text-align: center;"><strong>Previous</strong></th>
                        <th style="border: 1px solid #000; text-align: center;"><strong>Current</strong></th>
                        <th style="border: 1px solid #000; text-align: center;"><strong>M/E Propulsion</strong></th>
                        <th style="border: 1px solid #000; text-align: center;"><strong>A/E Cons.</strong></th>
                        <th style="border: 1px solid #000; text-align: center;"><strong>Boiler Cons.</strong></th>
                        <th style="border: 1px solid #000; text-align: center;"><strong>Incinerators</strong></th>
                        <th style="border: 1px solid #000; text-align: center;"><strong>M/E 24</strong></th>
                        <th style="border: 1px solid #000; text-align: center;"><strong>A/E 24</strong></th>
                    </tr>

                    {{-- Fuel Rows --}}
                    @foreach ($groupedFuels as $fuel)
                        <tr>
                            <td style="border: 1px solid #000;">{{ $fuel->fuel_type ?? 'N/A' }}</td>
                            <td style="border: 1px solid #000;">{{ $fuel->previous ?? 'N/A' }}</td>
                            <td style="border: 1px solid #000;">{{ $fuel->current ?? 'N/A' }}</td>
                            <td style="border: 1px solid #000;">{{ $fuel->me_propulsion ?? 'N/A' }}</td>
                            <td style="border: 1px solid #000;">{{ $fuel->ae_cons ?? 'N/A' }}</td>
                            <td style="border: 1px solid #000;">{{ $fuel->boiler_cons ?? 'N/A' }}</td>
                            <td style="border: 1px solid #000;">{{ $fuel->incinerators ?? 'N/A' }}</td>
                            <td style="border: 1px solid #000;">{{ $fuel->me_24 ?? 'N/A' }}</td>
                            <td style="border: 1px solid #000;">{{ $fuel->ae_24 ?? 'N/A' }}</td>
                            <td style="border: 1px solid #000;">{{ $fuel->total_cons ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <td colspan="13">
                            </td>
                        </tr>

                        {{-- Oil Details --}}
                        <tr>
                            <th style="border: 1px solid #000; text-align: center;" colspan="4"><strong>ME CYL</strong></th>
                            <th style="border: 1px solid #000; text-align: center;" colspan="3"><strong>ME CC</strong></th>
                            <th style="border: 1px solid #000; text-align: center;" colspan="3"><strong>AE CC</strong></th>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;">Oil Grade</td>
                            <td style="border: 1px solid #000;">Oil Quantity</td>
                            <td style="border: 1px solid #000;">Total Run Hrs.</td>
                            <td style="border: 1px solid #000;">Oil Cons.</td>
                            <td style="border: 1px solid #000;">Oil Quantity</td>
                            <td style="border: 1px solid #000;">Total Run Hrs.</td>
                            <td style="border: 1px solid #000;">Oil Cons.</td>
                            <td style="border: 1px solid #000;">Oil Quantity</td>
                            <td style="border: 1px solid #000;">Total Run Hrs.</td>
                            <td style="border: 1px solid #000;">Oil Cons.</td>
                        </tr>
                        <tr>
                            <td style="border: 1px solid #000;">{{ $fuel->me_cyl_grade ?? 'N/A' }}</td>
                            <td style="border: 1px solid #000;">{{ $fuel->me_cyl_qty ?? 'N/A' }}</td>
                            <td style="border: 1px solid #000;">{{ $fuel->me_cyl_hrs ?? 'N/A' }}</td>
                            <td style="border: 1px solid #000;">{{ $fuel->me_cyl_cons ?? 'N/A' }}</td>
                            <td style="border: 1px solid #000;">{{ $fuel->me_cc_qty ?? 'N/A' }}</td>
                            <td style="border: 1px solid #000;">{{ $fuel->me_cc_hrs ?? 'N/A' }}</td>
                            <td style="border: 1px solid #000;">{{ $fuel->me_cc_cons ?? 'N/A' }}</td>
                            <td style="border: 1px solid #000;">{{ $fuel->ae_cc_qty ?? 'N/A' }}</td>
                            <td style="border: 1px solid #000;">{{ $fuel->ae_cc_hrs ?? 'N/A' }}</td>
                            <td style="border: 1px solid #000;">{{ $fuel->ae_cc_cons ?? 'N/A' }}</td>
                        </tr>

                        <tr>
                            <td colspan="13">
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            @endif


            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- ROB CONSUMPTION TABLE --}}
            @if ($report->rob_fuel_reports && $report->rob_fuel_reports->count())
                <tr>
                    <td colspan="13"><strong>ROB Consumption</strong></td>
                </tr>
                <tr>
                    <th style="width: 200px; border: 1px solid #000;" rowspan="2">Bunker Type</th>
                    <th style="width: 200px; border: 1px solid #000;" colspan="2">ROB (in MT)</th>
                    <th style="width: 200px; border: 1px solid #000;" colspan="4">Consumption</th>
                    <th style="width: 200px; border: 1px solid #000;" colspan="2">Cons./24hr</th>
                    <th style="width: 200px; border: 1px solid #000;" rowspan="2">Total Cons.</th>
                </tr>
                <tr>
                    <th style="width: 200px; border: 1px solid #000;">Previous</th>
                    <th style="width: 200px; border: 1px solid #000;">Current</th>
                    <th style="width: 200px; border: 1px solid #000;">M/E Propulsion</th>
                    <th style="width: 200px; border: 1px solid #000;">A/E Cons.</th>
                    <th style="width: 200px; border: 1px solid #000;">Boiler Cons.</th>
                    <th style="width: 200px; border: 1px solid #000;">Incinerators</th>
                    <th style="width: 200px; border: 1px solid #000;">M/E 24</th>
                    <th style="width: 200px; border: 1px solid #000;">A/E 24</th>
                </tr>
                @foreach ($report->rob_fuel_reports as $fuel)
                    <tr>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->fuel_type ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->previous ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->current ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_propulsion ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->ae_cons ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->boiler_cons ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->incinerators ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_24 ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->ae_24 ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->total_cons ?? 'N/A' }}</td>
                    </tr>

                    {{-- Oil Grade Section --}}
                    {{-- <tr>
                        <td colspan="13" class="p-2 border text-center font-semibold">Oil Details</td>
                    </tr> --}}
                    <tr>
                        <th style="width: 200px; border: 1px solid #000;">ME CYL</th>
                        <th style="width: 200px; border: 1px solid #000;">ME CC</th>
                        <th style="width: 200px; border: 1px solid #000;">AE CC</th>
                    </tr>
                    <tr>
                        <td style="width: 200px; border: 1px solid #000;">Oil Grade</td>
                        <td style="width: 200px; border: 1px solid #000;">Oil Quantity</td>
                        <td style="width: 200px; border: 1px solid #000;">Total Run Hrs.</td>
                        <td style="width: 200px; border: 1px solid #000;">Oil Cons.</td>
                        <td style="width: 200px; border: 1px solid #000;">Oil Quantity</td>
                        <td style="width: 200px; border: 1px solid #000;">Total Run Hrs.</td>
                        <td style="width: 200px; border: 1px solid #000;">Oil Cons.</td>
                        <td style="width: 200px; border: 1px solid #000;">Oil Quantity</td>
                        <td style="width: 200px; border: 1px solid #000;">Total Run Hrs.</td>
                        <td style="width: 200px; border: 1px solid #000;">Oil Cons.</td>
                    </tr>
                    <tr>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cyl_grade ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cyl_qty ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cyl_hrs ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cyl_cons ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cc_qty ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cc_hrs ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cc_cons ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->ae_cc_qty ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->ae_cc_hrs ?? 'N/A' }}</td>
                        <td style="width: 200px; border: 1px solid #000;">{{ $fuel->ae_cc_cons ?? 'N/A' }}</td>
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
                <td>{{ $report->noon_report->dg1_run_hours ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>DG2 Run Hours</td>
                <td>{{ $report->noon_report->dg2_run_hours ?? 'N/A' }}</td>
            </tr>
            <tr>
                <td>DG3 Run Hours</td>
                <td>{{ $report->noon_report->dg3_run_hours ?? 'N/A' }}</td>
            </tr>

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- REMARKS / MASTER INFO --}}
            <tr>
                <td><strong>Remarks</strong></td>
                <td colspan="12">{{ optional($report->remarks)->remarks ?? 'N/A' }}</td>
            </tr>

            <tr>
                <td colspan="13">
                </td>
            </tr>

            <tr>
                <td><strong>Master Information</strong></td>
                <td colspan="12">{{ optional($report->master_info)->master_info ?? 'N/A' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
