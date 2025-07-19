<table border="1" cellspacing="0" cellpadding="4" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            @php
                $headers = [
                    // Voyage Info
                    'Vessel',
                    'Vessel User',
                    'Voyage No',
                    'Report Type',
                    'Date/Time (LT)',
                    'GMT Offset',
                    'Latitude',
                    'Longitude',
                    'Port of Departure',

                    // Noon Report Details
                    'CP/Ordered Speed',
                    'Allowed M/E Cons. at C/P Speed',
                    'Observed Distance',
                    'Steaming Time',
                    'Avg Speed',
                    'Distance to Go',
                    'Course',
                    'Breakdown',
                    'Avg RPM',
                    'Engine Distance',
                    'Slip',
                    'M/E Output %MCR',
                    'Avg Power (kW)',
                    'Logged Distance',
                    'Speed Through Water',
                    'Next Port',
                    'ETA Next Port',
                    'ETA GMT Offset',
                    'Anchored Hours',
                    'Drifting Hours',
                    'Maneuvering Hours',
                    'Condition',
                    'Displacement',
                    'Cargo Name',
                    'Cargo Weight',
                    'Ballast Weight',
                    'Fresh Water',
                    'Fwd Draft',
                    'Aft Draft',
                    'GM',

                    // Voyage Itinerary
                    'Next Port',
                    'Via',
                    'ETA (LT)',
                    'GMT Offset',
                    'Distance to go',
                    'Projected Speed (kts)',

                    // Average & Bad Weather
                    'Wind Force (Bft.) (T)',
                    'Swell',
                    'Sea Current (Kts) (Rel.)',
                    'Sea Temp (Deg. °C)',
                    'Observed Wind Dir. (T)',
                    'Wind Sea Height (m)',
                    'Sea Current Direction. (Rel.)',
                    'Swell Height (m)',
                    'Observed Sea Dir. (T)',
                    'Air Temp (Deg. °C)',
                    'Observed Swell Dir. (T)',
                    'Sea DS',
                    'Atm. Pressure (millibar)',
                    'Wind force (Bft.) >0 hrs (since last report)',
                    'Wind Force (Bft.) (continuous)',
                    'Sea State (DS) >0 hrs (since last report)',
                    'Sea State (continuous)',

                    // Weather Observations (All)
                    'Time Block',
                    'Wind Force',
                    'Wind Dir',
                    'Swell Height',
                    'Swell Dir',
                    'Wind Sea Height',
                    'Sea Dir',
                    'Sea DS',

                    // ROB Tank (All)
                    'Tank No',
                    'Description',
                    'Fuel Grade',
                    'Capacity',
                    'Unit',
                    'ROB (MT)',
                    'Supply Date (LT)',

                    // ROB Fuel (All)
                    'Fuel Type',
                    'Previous',
                    'Current',
                    'M/E Propulsion.',
                    'A/E Consumption',
                    'Boiler Consumption',
                    'Incinerators',
                    'M/E 24',
                    'A/E 24',
                    'Total Consumption',

                    // Condensed Oil Grades
                    'ME CYL Grade',
                    'ME CYL Quantity',
                    'ME CYL Hours',
                    'ME CYL Consumption',
                    'ME CC Quantity',
                    'ME CC Hours',
                    'ME CC Consumption',
                    'AE CC Quantity',
                    'AE CC Hours',
                    'AE CC Consumption',

                    // Diesel Engine Hours
                    'DG1 Run Hours',
                    'DG2 Run Hours',
                    'DG3 Run Hours',

                    // Master & Remarks
                    'Remarks',
                    'Master Information',
                ];
            @endphp

            @foreach ($headers as $header)
                <th style="width: 250px;"><strong>{{ $header }}</strong></th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @foreach ($reports as $report)
            @php
                $noon = $report->noon_report;
            @endphp

            {{-- Loop for each combination of weather, ROB tank, and ROB fuel --}}
            @php
                $weatherList = $report->weather_observations;
                $robTanks = $report->rob_tanks;
                $robFuels = $report->rob_fuel_reports;

                $max = max($weatherList->count(), $robTanks->count(), $robFuels->count());
                $max = $max > 0 ? $max : 1;
            @endphp

            @if (!$loop->first)
                <tr>
                    <td colspan="11" style="height: 15px;"></td> {{-- Spacer row --}}
                </tr>
            @endif

            @for ($i = 0; $i < $max; $i++)
                @php
                    $firstRow = $i === 0;
                    $weather = $weatherList[$i] ?? null;
                    $robTank = $robTanks[$i] ?? null;
                    $robFuel = $robFuels[$i] ?? null;
                @endphp
                <tr>
                    {{-- Voyage Info --}}
                    <td style="text-align: left;">{{ $firstRow ? $report->vessel->name ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $report->unit->name ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $report->voyage_no ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $report->report_type ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $report->all_fast_datetime ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $report->gmt_offset ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $report->port ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $report->bunkering_port ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $report->supplier ?? '' : '' }}</td>

                    {{-- Noon Report --}}
                    <td style="text-align: left;">{{ $firstRow ? $noon->cp_ordered_speed ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->me_cons_cp_speed ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->obs_distance ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->steaming_time ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->avg_speed ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->distance_to_go ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->course ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->breakdown ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->avg_rpm ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->engine_distance ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->slip ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->me_output_mcr ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->avg_power ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->logged_distance ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->speed_through_water ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->next_port ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->eta_next_port ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->eta_gmt_offset ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->anchored_hours ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->drifting_hours ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->maneuvering_hours ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->condition ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->displacement ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->cargo_name ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->cargo_weight ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->ballast_weight ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->fresh_water ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->fwd_draft ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->aft_draft ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->gm ?? '' : '' }}</td>

                    {{-- Voyage Itinerary --}}
                    <td style="text-align: left;">{{ $firstRow ? $noon->next_port_voyage ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->via ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->eta_lt ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->gmt_offset_voyage ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->distance_to_go_voyage ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->projected_speed ?? '' : '' }}</td>

                    {{-- Avg & Bad Weather --}}
                    <td style="text-align: left;">{{ $firstRow ? $noon->wind_force_average_weather ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->swell ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->sea_current ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->sea_temp ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->observed_wind ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->wind_sea_height ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->sea_current_direction ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->swell_height ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->observed_sea ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->air_temp ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->observed_swell ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->sea_ds ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->atm_pressure ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->wind_force_previous ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->wind_force_current ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->sea_state_previous ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->sea_state_current ?? '' : '' }}</td>

                    {{-- Weather Observation (i-th) --}}
                    <td style="text-align: left;">{{ $weather->time_block ?? '' }}</td>
                    <td style="text-align: left;">{{ $weather->wind_force ?? '' }}</td>
                    <td style="text-align: left;">{{ $weather->wind_direction ?? '' }}</td>
                    <td style="text-align: left;">{{ $weather->swell_height ?? '' }}</td>
                    <td style="text-align: left;">{{ $weather->swell_direction ?? '' }}</td>
                    <td style="text-align: left;">{{ $weather->wind_sea_height ?? '' }}</td>
                    <td style="text-align: left;">{{ $weather->sea_direction ?? '' }}</td>
                    <td style="text-align: left;">{{ $weather->sea_ds ?? '' }}</td>

                    {{-- ROB Tank (i-th) --}}
                    <td style="text-align: left;">{{ $robTank->tank_no ?? '' }}</td>
                    <td style="text-align: left;">{{ $robTank->description ?? '' }}</td>
                    <td style="text-align: left;">{{ $robTank->grade ?? '' }}</td>
                    <td style="text-align: left;">{{ $robTank->capacity ?? '' }}</td>
                    <td style="text-align: left;">{{ $robTank->unit ?? '' }}</td>
                    <td style="text-align: left;">{{ $robTank->rob ?? '' }}</td>
                    <td style="text-align: left;">{{ $robTank && $robTank->supply_date ? \Carbon\Carbon::parse($robTank->supply_date)->format('M d, Y h:i A') : '' }}
                    </td>

                    {{-- ROB Fuel (i-th) --}}
                    <td style="text-align: left;">{{ $robFuel->fuel_type ?? '' }}</td>
                    <td style="text-align: left;">{{ $robFuel->previous ?? '' }}</td>
                    <td style="text-align: left;">{{ $robFuel->current ?? '' }}</td>
                    <td style="text-align: left;">{{ $robFuel->me_propulsion ?? '' }}</td>
                    <td style="text-align: left;">{{ $robFuel->ae_cons ?? '' }}</td>
                    <td style="text-align: left;">{{ $robFuel->boiler_cons ?? '' }}</td>
                    <td style="text-align: left;">{{ $robFuel->incinerators ?? '' }}</td>
                    <td style="text-align: left;">{{ $robFuel->me_24 ?? '' }}</td>
                    <td style="text-align: left;">{{ $robFuel->ae_24 ?? '' }}</td>
                    <td style="text-align: left;">{{ $robFuel->total_cons ?? '' }}</td>

                    {{-- Oil Grades --}}
                    <td style="text-align: left;">{{ $robFuel->me_cyl_grade ?? '' }}</td>
                    <td style="text-align: left;">{{ $robFuel->me_cyl_qty ?? '' }}</td>
                    <td style="text-align: left;">{{ $robFuel->me_cyl_hrs ?? '' }}</td>
                    <td style="text-align: left;">{{ $robFuel->me_cyl_cons ?? '' }}</td>
                    <td style="text-align: left;">{{ $robFuel->me_cc_qty ?? '' }}</td>
                    <td style="text-align: left;">{{ $robFuel->me_cc_hrs ?? '' }}</td>
                    <td style="text-align: left;">{{ $robFuel->me_cc_cons ?? '' }}</td>
                    <td style="text-align: left;">{{ $robFuel->ae_cc_qty ?? '' }}</td>
                    <td style="text-align: left;">{{ $robFuel->ae_cc_hrs ?? '' }}</td>
                    <td style="text-align: left;">{{ $robFuel->ae_cc_cons ?? '' }}</td>

                    {{-- Diesel Engine Hours --}}
                    <td style="text-align: left;">{{ $firstRow ? $noon->dg1_run_hours ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->dg2_run_hours ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $noon->dg3_run_hours ?? '' : '' }}</td>

                    {{-- Remarks & Master --}}
                    <td style="text-align: left;">{{ $firstRow ? $report->remarks->remarks ?? '' : '' }}</td>
                    <td style="text-align: left;">{{ $firstRow ? $report->master_info->master_info ?? '' : '' }}</td>
                </tr>
            @endfor
        @endforeach
    </tbody>
</table>
