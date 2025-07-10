<table border="1" cellspacing="0" cellpadding="5" style="border-collapse: collapse; width: 100%;">
    <thead>
        <tr>
            <th colspan="13"><strong>Departure Report Details</strong></th>
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
                <td style="width: 200px;">Vessel Name:</td>
                <td colspan="12">{{ $report->vessel->name ?? '' }}</td>
            </tr>
            <tr>
                <td>Voyage No:</td>
                <td colspan="12">{{ $report->voyage_no ?? '' }}</td>
            </tr>
            <tr>
                <td>Date/Time (LT):</td>
                <td colspan="12">{{ \Carbon\Carbon::parse($report->all_fast_datetime)->format('M d, Y h:i A') }}</td>
            </tr>
            <tr>
                <td>GMT Offset:</td>
                <td colspan="12">{{ $report->gmt_offset ?? '' }}</td>
            </tr>
            <tr>
                <td>Latitude:</td>
                <td colspan="12">{{ $report->port ?? '' }}</td>
            </tr>
            <tr>
                <td>Longitude:</td>
                <td colspan="12">{{ $report->bunkering_port ?? '' }}</td>
            </tr>
            <tr>
                <td>Departure Type:</td>
                <td colspan="12">{{ $report->port_gmt_offset ?? '' }}</td>
            </tr>
            <tr>
                <td>Departure Port:</td>
                <td colspan="12">{{ $report->supplier ?? '' }}</td>
            </tr>

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- DETAILS SINCE LAST REPORT --}}
            <tr>
                <td colspan="13"><strong>Details Since Last Report</strong></td>
            </tr>
            <tr>
                <td>CP/Ordered Speed (Kts):</td>
                <td colspan="12">{{ $report->noon_report->cp_ordered_speed ?? '' }}</td>
            </tr>
            <tr>
                <td>Obs. Distance (NM):</td>
                <td colspan="12">{{ $report->noon_report->obs_distance ?? '' }}</td>
            </tr>
            <tr>
                <td>Steaming Time (Hrs):</td>
                <td colspan="12">{{ $report->noon_report->steaming_time ?? '' }}</td>
            </tr>
            <tr>
                <td>Avg Speed (Kts):</td>
                <td colspan="12">{{ $report->noon_report->avg_speed ?? '' }}</td>
            </tr>
            <tr>
                <td>Distance to go (NM):</td>
                <td colspan="12">{{ $report->noon_report->distance_to_go ?? '' }}</td>
            </tr>
            <tr>
                <td>Avg RPM:</td>
                <td colspan="12">{{ $report->noon_report->avg_rpm ?? '' }}</td>
            </tr>
            <tr>
                <td>Engine Distance (NM):</td>
                <td colspan="12">{{ $report->noon_report->engine_distance ?? '' }}</td>
            </tr>
            <tr>
                <td>Slip (%):</td>
                <td colspan="12">{{ $report->noon_report->maneuvering_hours ?? '' }}</td>
            </tr>
            <tr>
                <td>Avg Power (KW):</td>
                <td colspan="12">{{ $report->noon_report->avg_power ?? '' }}</td>
            </tr>
            <tr>
                <td>Course (Deg):</td>
                <td colspan="12">{{ $report->noon_report->course ?? '' }}</td>
            </tr>
            <tr>
                <td>Logged Distance (NM):</td>
                <td colspan="12">{{ $report->noon_report->logged_distance ?? '' }}</td>
            </tr>
            <tr>
                <td>Speed Through Water (Kts):</td>
                <td colspan="12">{{ $report->noon_report->speed_through_water ?? '' }}</td>
            </tr>
            <tr>
                <td>Next Port:</td>
                <td colspan="12">{{ $report->noon_report->next_port ?? '' }}</td>
            </tr>
            <tr>
                <td>ETA Next Port (LT):</td>
                <td colspan="12">
                    {{ $report->noon_report->eta_next_port ? \Carbon\Carbon::parse($report->noon_report->eta_next_port)->format('M d, Y h:i A') : '' }}</td>
            </tr>
            <tr>
                <td>ETA GMT Offset:</td>
                <td colspan="12">{{ $report->noon_report->eta_gmt_offset ?? '' }}</td>
            </tr>

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- DEPARTURE CONDITIONS --}}
            <tr>
                <td colspan="13"><strong>Departure Conditions</strong></td>
            </tr>
            <tr>
                <td>Departure Condition:</td>
                <td colspan="12">{{ $report->noon_report->condition ?? '' }}</td>
            </tr>
            <tr>
                <td>Displacement (MT):</td>
                <td colspan="12">{{ $report->noon_report->displacement ?? '' }}</td>
            </tr>
            <tr>
                <td>Cargo Name:</td>
                <td colspan="12">{{ $report->noon_report->cargo_name ?? '' }}</td>
            </tr>
            <tr>
                <td>Cargo Weight (MT):</td>
                <td colspan="12">{{ $report->noon_report->cargo_weight ?? '' }}</td>
            </tr>
            <tr>
                <td>Ballast Weight (MT):</td>
                <td colspan="12">{{ $report->noon_report->ballast_weight ?? '' }}</td>
            </tr>
            <tr>
                <td>Fresh Water (MT):</td>
                <td colspan="12">{{ $report->noon_report->fresh_water ?? '' }}</td>
            </tr>
            <tr>
                <td>Fwd Draft (m):</td>
                <td colspan="12">{{ $report->noon_report->fwd_draft ?? '' }}</td>
            </tr>
            <tr>
                <td>Aft Draft (m):</td>
                <td colspan="12">{{ $report->noon_report->aft_draft ?? '' }}</td>
            </tr>
            <tr>
                <td>GM:</td>
                <td colspan="12">{{ $report->noon_report->gm ?? '' }}</td>
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
                <td>Next Port:</td>
                <td colspan="12">{{ $report->noon_report->next_port_voyage ?? '' }}</td>
            </tr>
            <tr>
                <td>Via:</td>
                <td colspan="12">{{ $report->noon_report->via ?? '' }}</td>
            </tr>
            <tr>
                <td>ETA (LT):</td>
                <td colspan="12">{{ $report->noon_report->eta_lt ? \Carbon\Carbon::parse($report->noon_report->eta_lt)->format('M d, Y h:i A') : '' }}
                </td>
            </tr>
            <tr>
                <td>GMT Offset:</td>
                <td colspan="12">{{ $report->noon_report->gmt_offset_voyage ?? '' }}</td>
            </tr>
            <tr>
                <td>Distance to go:</td>
                <td colspan="12">{{ $report->noon_report->distance_to_go_voyage ?? '' }}</td>
            </tr>
            <tr>
                <td>Projected Speed (kts):</td>
                <td colspan="12">{{ $report->noon_report->projected_speed ?? '' }}</td>
            </tr>

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- ROB DETAILS --}}
            {{-- ROB CONSUMPTION TABLE --}}
            @if ($report->rob_fuel_reports && $report->rob_fuel_reports->count())
                @foreach ($report->rob_fuel_reports->groupBy('fuel_type') as $fuelType => $groupedFuels)
                    {{-- Header --}}
                    <tr>
                        <th style="width: 200px; border: 1px solid #000; text-align: center;" rowspan="2">
                            <strong>Bunker Type</strong></th>
                        <th style="width: 200px; border: 1px solid #000; text-align: center;" colspan="2"><strong>ROB
                                (in MT)</strong></th>
                        <th style="width: 200px; border: 1px solid #000; text-align: center;" colspan="4">
                            <strong>Consumption</strong></th>
                        <th style="width: 200px; border: 1px solid #000; text-align: center;" colspan="2">
                            <strong>Cons./24hr</strong></th>
                        <th style="width: 200px; border: 1px solid #000; text-align: center;" rowspan="2">
                            <strong>Total Cons.</strong></th>
                    </tr>
                    <tr>
                        <th style="width: 200px; border: 1px solid #000; text-align: center;"><strong>Previous</strong>
                        </th>
                        <th style="width: 200px; border: 1px solid #000; text-align: center;"><strong>Current</strong>
                        </th>
                        <th style="width: 200px; border: 1px solid #000; text-align: center;"><strong>M/E
                                Propulsion</strong></th>
                        <th style="width: 200px; border: 1px solid #000; text-align: center;"><strong>A/E Cons.</strong>
                        </th>
                        <th style="width: 200px; border: 1px solid #000; text-align: center;"><strong>Boiler
                                Cons.</strong></th>
                        <th style="width: 200px; border: 1px solid #000; text-align: center;">
                            <strong>Incinerators</strong></th>
                        <th style="width: 200px; border: 1px solid #000; text-align: center;"><strong>M/E 24</strong>
                        </th>
                        <th style="width: 200px; border: 1px solid #000; text-align: center;"><strong>A/E 24</strong>
                        </th>
                    </tr>

                    {{-- Fuel Rows --}}
                    @foreach ($groupedFuels as $fuel)
                        <tr>
                            <td style="width: 200px; border: 1px solid #000;">{{ $fuel->fuel_type ?? '' }}</td>
                            <td style="width: 200px; border: 1px solid #000;">{{ $fuel->previous ?? '' }}</td>
                            <td style="width: 200px; border: 1px solid #000;">{{ $fuel->current ?? '' }}</td>
                            <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_propulsion ?? '' }}</td>
                            <td style="width: 200px; border: 1px solid #000;">{{ $fuel->ae_cons ?? '' }}</td>
                            <td style="width: 200px; border: 1px solid #000;">{{ $fuel->boiler_cons ?? '' }}</td>
                            <td style="width: 200px; border: 1px solid #000;">{{ $fuel->incinerators ?? '' }}</td>
                            <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_24 ?? '' }}</td>
                            <td style="width: 200px; border: 1px solid #000;">{{ $fuel->ae_24 ?? '' }}</td>
                            <td style="width: 200px; border: 1px solid #000;">{{ $fuel->total_cons ?? '' }}</td>
                        </tr>

                        {{-- Condensed Oil Details --}}
                        <tr class="bg-zinc-100 dark:bg-zinc-800 text-center font-semibold">
                            <td style="width: 200px; border: 1px solid #000; text-align: center;" colspan="4"><strong>ME CYL</strong></td>
                            <td style="width: 200px; border: 1px solid #000; text-align: center;" colspan="3"><strong>ME CC</strong></td>
                            <td style="width: 200px; border: 1px solid #000; text-align: center;" colspan="3"><strong>AE CC</strong></td>
                        </tr>
                        <tr>
                            <th style="width: 200px; border: 1px solid #000;">Oil Grade</th>
                            <th style="width: 200px; border: 1px solid #000;">Oil Quantity</th>
                            <th style="width: 200px; border: 1px solid #000;">Total Run Hrs.</th>
                            <th style="width: 200px; border: 1px solid #000;">Oil Cons.</th>

                            <th style="width: 200px; border: 1px solid #000;">Oil Quantity</th>
                            <th style="width: 200px; border: 1px solid #000;">Total Run Hrs.</th>
                            <th style="width: 200px; border: 1px solid #000;">Oil Cons.</th>

                            <th style="width: 200px; border: 1px solid #000;">Oil Quantity</th>
                            <th style="width: 200px; border: 1px solid #000;">Total Run Hrs.</th>
                            <th style="width: 200px; border: 1px solid #000;">Oil Cons.</th>
                        </tr>
                        <tr>
                            <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cyl_grade ?? '' }}</td>
                            <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cyl_qty ?? '' }}</td>
                            <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cyl_hrs ?? '' }}</td>
                            <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cyl_cons ?? '' }}</td>

                            <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cc_qty ?? '' }}</td>
                            <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cc_hrs ?? '' }}</td>
                            <td style="width: 200px; border: 1px solid #000;">{{ $fuel->me_cc_cons ?? '' }}</td>

                            <td style="width: 200px; border: 1px solid #000;">{{ $fuel->ae_cc_qty ?? '' }}</td>
                            <td style="width: 200px; border: 1px solid #000;">{{ $fuel->ae_cc_hrs ?? '' }}</td>
                            <td style="width: 200px; border: 1px solid #000;">{{ $fuel->ae_cc_cons ?? '' }}</td>
                        </tr>

                        <tr>
                            <td colspan="13"></td>
                        </tr>
                    @endforeach
                @endforeach
            @endif

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- REMARKS --}}
            @if ($report->remarks)
                <tr>
                    <td><strong>Remarks</strong></td>
                    <td colspan="12">{{ $report->remarks->remarks ?? '' }}</td>
                </tr>
            @endif

            <tr>
                <td colspan="13">
                </td>
            </tr>

            {{-- Master Information --}}
            @if ($report->master_info)
                <tr>
                    <td><strong>Master's Name</strong></td>
                    <td colspan="12">{{ $report->master_info->master_info ?? '' }}</td>
                </tr>
            @endif
        @endforeach
    </tbody>
</table>
