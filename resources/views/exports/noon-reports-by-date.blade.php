<table border="1" cellspacing="0" cellpadding="4" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            @php
                $headers = [
                    // Voyage Info
                    'Vessel', 'Vessel User', 'Voyage No', 'Report Type', 'Date/Time (LT)', 'GMT Offset',
                    'Latitude', 'Longitude', 'Port of Departure',

                    // Noon Report Details
                    'CP/Ordered Speed', 'Allowed M/E Cons. at C/P Speed', 'Observed Distance', 'Steaming Time', 'Avg Speed',
                    'Distance to Go', 'Course', 'Breakdown', 'Avg RPM', 'Engine Distance', 'Slip',
                    'M/E Output %MCR', 'Avg Power (kW)', 'Logged Distance', 'Speed Through Water', 'Next Port',
                    'ETA Next Port', 'ETA GMT Offset', 'Anchored Hours', 'Drifting Hours', 'Maneuvering Hours',
                    'Condition', 'Displacement', 'Cargo Name', 'Cargo Weight', 'Ballast Weight',
                    'Fresh Water', 'Fwd Draft', 'Aft Draft', 'GM',

                    // Average & Bad Weather
                    'Wind Force (Bft.) (T)', 'Swell', 'Sea Current (Kts) (Rel.)', 'Sea Temp (Deg. °C)', 'Observed Wind Dir. (T)',
                    'Wind Sea Height (m)', 'Sea Current Direction. (Rel.)', 'Swell Height (m)', 'Observed Sea Dir. (T)', 'Air Temp (Deg. °C)',
                    'Observed Swell Dir. (T)', 'Sea DS', 'Atm. Pressure (millibar)',
                    'Wind force (Bft.) >0 hrs (since last report)', 'Wind Force (Bft.) (continuous)', 'Sea State (DS) >0 hrs (since last report)', 'Sea State (continuous)',

                    // Weather Observations (All)
                    'Time Block', 'Wind Force', 'Wind Dir', 'Swell Height', 'Swell Dir',
                    'Wind Sea Height', 'Sea Dir', 'Sea DS',

                    // ROB Tank (All)
                    'Tank No', 'Description', 'Fuel Grade', 'Capacity', 'Unit', 'ROB (MT)', 'Supply Date (LT)',

                    // ROB Fuel (All)
                    'Fuel Type', 'Previous', 'Current', 'M/E Propulsion.', 'A/E Cons.', 'Boiler Cons.',
                    'Incinerators', 'M/E 24', 'A/E 24', 'Total Cons.',

                    // Condensed Oil Grades
                    'ME CYL Grade', 'ME CYL Qty', 'ME CYL Hrs', 'ME CYL Cons.',
                    'ME CC Qty', 'ME CC Hrs', 'ME CC Cons.',
                    'AE CC Qty', 'AE CC Hrs', 'AE CC Cons.',

                    // Diesel Engine Hours
                    'DG1 Run Hours', 'DG2 Run Hours', 'DG3 Run Hours',

                    // Master & Remarks
                    'Remarks', 'Master Information'
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
                <tr>
                    {{-- Voyage Info --}}
                    <td>{{ $report->vessel->name ?? '' }}</td>
                    <td>{{ $report->unit->name ?? '' }}</td>
                    <td>{{ $report->voyage_no ?? '' }}</td>
                    <td>{{ $report->report_type ?? '' }}</td>
                    <td>{{ $report->all_fast_datetime ?? '' }}</td>
                    <td>{{ $report->gmt_offset ?? '' }}</td>
                    <td>{{ $report->port ?? '' }}</td>
                    <td>{{ $report->bunkering_port ?? '' }}</td>
                    <td>{{ $report->supplier ?? '' }}</td>

                    {{-- Noon Report --}}
                    <td>{{ $noon->cp_ordered_speed ?? 'N/A' }}</td>
                    <td>{{ $noon->me_cons_cp_speed ?? 'N/A' }}</td>
                    <td>{{ $noon->obs_distance ?? 'N/A' }}</td>
                    <td>{{ $noon->steaming_time ?? 'N/A' }}</td>
                    <td>{{ $noon->avg_speed ?? 'N/A' }}</td>
                    <td>{{ $noon->distance_to_go ?? 'N/A' }}</td>
                    <td>{{ $noon->course ?? 'N/A' }}</td>
                    <td>{{ $noon->breakdown ?? 'N/A' }}</td>
                    <td>{{ $noon->avg_rpm ?? 'N/A' }}</td>
                    <td>{{ $noon->engine_distance ?? 'N/A' }}</td>
                    <td>{{ $noon->slip ?? 'N/A' }}</td>
                    <td>{{ $noon->me_output_mcr ?? 'N/A' }}</td>
                    <td>{{ $noon->avg_power ?? 'N/A' }}</td>
                    <td>{{ $noon->logged_distance ?? 'N/A' }}</td>
                    <td>{{ $noon->speed_through_water ?? 'N/A' }}</td>
                    <td>{{ $noon->next_port ?? 'N/A' }}</td>
                    <td>{{ $noon->eta_next_port ?? 'N/A' }}</td>
                    <td>{{ $noon->eta_gmt_offset ?? 'N/A' }}</td>
                    <td>{{ $noon->anchored_hours ?? 'N/A' }}</td>
                    <td>{{ $noon->drifting_hours ?? 'N/A' }}</td>
                    <td>{{ $noon->maneuvering_hours ?? 'N/A' }}</td>
                    <td>{{ $noon->condition ?? 'N/A' }}</td>
                    <td>{{ $noon->displacement ?? 'N/A' }}</td>
                    <td>{{ $noon->cargo_name ?? 'N/A' }}</td>
                    <td>{{ $noon->cargo_weight ?? 'N/A' }}</td>
                    <td>{{ $noon->ballast_weight ?? 'N/A' }}</td>
                    <td>{{ $noon->fresh_water ?? 'N/A' }}</td>
                    <td>{{ $noon->fwd_draft ?? 'N/A' }}</td>
                    <td>{{ $noon->aft_draft ?? 'N/A' }}</td>
                    <td>{{ $noon->gm ?? 'N/A' }}</td>

                    {{-- Avg & Bad Weather --}}
                    <td>{{ $noon->wind_force_average_weather ?? '' }}</td>
                    <td>{{ $noon->swell ?? '' }}</td>
                    <td>{{ $noon->sea_current ?? '' }}</td>
                    <td>{{ $noon->sea_temp ?? '' }}</td>
                    <td>{{ $noon->observed_wind ?? '' }}</td>
                    <td>{{ $noon->wind_sea_height ?? '' }}</td>
                    <td>{{ $noon->sea_current_direction ?? '' }}</td>
                    <td>{{ $noon->swell_height ?? '' }}</td>
                    <td>{{ $noon->observed_sea ?? '' }}</td>
                    <td>{{ $noon->air_temp ?? '' }}</td>
                    <td>{{ $noon->observed_swell ?? '' }}</td>
                    <td>{{ $noon->sea_ds ?? '' }}</td>
                    <td>{{ $noon->atm_pressure ?? '' }}</td>
                    <td>{{ $noon->wind_force_previous ?? '' }}</td>
                    <td>{{ $noon->wind_force_current ?? '' }}</td>
                    <td>{{ $noon->sea_state_previous ?? '' }}</td>
                    <td>{{ $noon->sea_state_current ?? '' }}</td>

                    {{-- Weather Observation (i-th) --}}
                    @php $weather = $weatherList[$i] ?? null; @endphp
                    <td>{{ $weather->time_block ?? '' }}</td>
                    <td>{{ $weather->wind_force ?? '' }}</td>
                    <td>{{ $weather->wind_direction ?? '' }}</td>
                    <td>{{ $weather->swell_height ?? '' }}</td>
                    <td>{{ $weather->swell_direction ?? '' }}</td>
                    <td>{{ $weather->wind_sea_height ?? '' }}</td>
                    <td>{{ $weather->sea_direction ?? '' }}</td>
                    <td>{{ $weather->sea_ds ?? '' }}</td>

                    {{-- ROB Tank (i-th) --}}
                    @php $robTank = $robTanks[$i] ?? null; @endphp
                    <td>{{ $robTank->tank_no ?? '' }}</td>
                    <td>{{ $robTank->description ?? '' }}</td>
                    <td>{{ $robTank->grade ?? '' }}</td>
                    <td>{{ $robTank->capacity ?? '' }}</td>
                    <td>{{ $robTank->unit ?? '' }}</td>
                    <td>{{ $robTank->rob ?? '' }}</td>
                    <td>{{ $robTank && $robTank->supply_date ? \Carbon\Carbon::parse($robTank->supply_date)->format('M d, Y h:i A') : '' }}</td>

                    {{-- ROB Fuel (i-th) --}}
                    @php $robFuel = $robFuels[$i] ?? null; @endphp
                    <td>{{ $robFuel->fuel_type ?? '' }}</td>
                    <td>{{ $robFuel->previous ?? '' }}</td>
                    <td>{{ $robFuel->current ?? '' }}</td>
                    <td>{{ $robFuel->me_propulsion ?? '' }}</td>
                    <td>{{ $robFuel->ae_cons ?? '' }}</td>
                    <td>{{ $robFuel->boiler_cons ?? '' }}</td>
                    <td>{{ $robFuel->incinerators ?? '' }}</td>
                    <td>{{ $robFuel->me_24 ?? '' }}</td>
                    <td>{{ $robFuel->ae_24 ?? '' }}</td>
                    <td>{{ $robFuel->total_cons ?? '' }}</td>

                    {{-- Oil Grades --}}
                    <td>{{ $robFuel->me_cyl_grade ?? '' }}</td>
                    <td>{{ $robFuel->me_cyl_qty ?? '' }}</td>
                    <td>{{ $robFuel->me_cyl_hrs ?? '' }}</td>
                    <td>{{ $robFuel->me_cyl_cons ?? '' }}</td>
                    <td>{{ $robFuel->me_cc_qty ?? '' }}</td>
                    <td>{{ $robFuel->me_cc_hrs ?? '' }}</td>
                    <td>{{ $robFuel->me_cc_cons ?? '' }}</td>
                    <td>{{ $robFuel->ae_cc_qty ?? '' }}</td>
                    <td>{{ $robFuel->ae_cc_hrs ?? '' }}</td>
                    <td>{{ $robFuel->ae_cc_cons ?? '' }}</td>

                    {{-- Diesel Engine Hours --}}
                    <td>{{ $noon->dg1_run_hours ?? '' }}</td>
                    <td>{{ $noon->dg2_run_hours ?? '' }}</td>
                    <td>{{ $noon->dg3_run_hours ?? '' }}</td>

                    {{-- Remarks & Master --}}
                    <td>{{ $report->remarks->remarks ?? '' }}</td>
                    <td>{{ $report->master_info->master_info ?? '' }}</td>
                </tr>
            @endfor
        @endforeach
    </tbody>
</table>
