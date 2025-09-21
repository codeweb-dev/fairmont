<?php

namespace App\Livewire\Unit;

use App\Models\Audit;
use App\Models\Notification;
use App\Models\Voyage;
use App\Models\Vessel as ModelsVessel;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;

class EditNoonReport extends Component
{
    public $voyageId;
    public $voyage;
    public $vessel_id;
    public $master_info;
    public $remarks;
    public $vesselName;

    // Voyage Details
    public $voyage_no;
    public $port_gmt_offset = ''; // as Report Type
    public $all_fast_datetime; // as Date/Time (LT)
    public $gmt_offset;
    public $port = "0° 0' 0'' N/S"; // as Latitude
    public $bunkering_port = "0° 0' 0'' E/W"; // as Longtitude
    public $supplier; // as Port of Departure

    // Report Details
    public $cp_ordered_speed;
    public $me_cons_cp_speed;
    public $obs_distance;
    public $steaming_time;
    public $avg_speed;
    public $distance_to_go;
    public $course;
    public $breakdown;
    public $avg_rpm;
    public $engine_distance;
    public $slip;
    public $me_output_mcr;
    public $avg_power;
    public $logged_distance;
    public $speed_through_water;
    public $next_port;
    public $eta_next_port;
    public $eta_gmt_offset;
    public $anchored_hours;
    public $drifting_hours;
    public $maneuvering_hours;

    // Voyage Itinerary
    public $next_port_voyage;
    public $via;
    public $eta_lt;
    public $gmt_offset_voyage;
    public $distance_to_go_voyage;
    public $projected_speed;

    // Noon Conditions
    public $condition;
    public $displacement;
    public $cargo_name;
    public $cargo_weight;
    public $ballast_weight;
    public $fresh_water;
    public $fwd_draft;
    public $aft_draft;
    public $gm;

    // Average Weather
    public $wind_force_average_weather;
    public $swell;
    public $sea_current;
    public $sea_temp;
    public $observed_wind;
    public $wind_sea_height;
    public $sea_current_direction;
    public $swell_height;
    public $observed_sea;
    public $air_temp;
    public $observed_swell;
    public $sea_ds;
    public $atm_pressure;

    // Bad Weather
    public $wind_force_previous;
    public $wind_force_current;
    public $sea_state_previous;
    public $sea_state_current;

    // Diesel Engine
    public $dg1_run_hours;
    public $dg2_run_hours;
    public $dg3_run_hours;

    public array $gmtOffsets = [
        "GMT-12:00",
        "GMT-11:00",
        "GMT-10:00",
        "GMT-09:30",
        "GMT-09:00",
        "GMT-08:00",
        "GMT-07:00",
        "GMT-06:00",
        "GMT-05:00",
        "GMT-04:30",
        "GMT-04:00",
        "GMT-03:30",
        "GMT-03:00",
        "GMT-02:30",
        "GMT-02:00",
        "GMT-01:00",
        "GMT",
        "GMT+01:00",
        "GMT+02:00",
        "GMT+02:30",
        "GMT+03:00",
        "GMT+03:30",
        "GMT+04:00",
        "GMT+04:30",
        "GMT+05:00",
        "GMT+05:30",
        "GMT+06:00",
        "GMT+06:30",
        "GMT+07:00",
        "GMT+08:00",
        "GMT+09:00",
        "GMT+09:30",
        "GMT+10:00",
        "GMT+10:30",
        "GMT+11:00",
        "GMT+11:30",
        "GMT+12:00",
        "GMT+12:45",
        "GMT+13:00",
        "GMT+13:45",
        "GMT+14:00"
    ];

    public array $directions = [
        "0 - N",
        "22.5 - NNE",
        "45 - NE",
        "67.5 - ENE",
        "90 - E",
        "112.5 - ESE",
        "135 - SE",
        "157.5 - SSE",
        "180 - S",
        "202.5 - SSW",
        "225 - SW",
        "247.5 - WSW",
        "270 - W",
        "292.5 - WNW",
        "315 - NW",
        "337.5 - NNW"
    ];

    public array $winds = [
        "0 - Calm",
        "1 - Light Air",
        "2 - Light Air Breeze",
        "3 - Gentle Breeze",
        "4 - Moderate Breeze",
        "5 - Fresh Breeze",
        "6 - Strong Breeze",
        "7 - Near Gale",
        "8 - Gale",
        "9 - Strong Gale",
        "10 - Storm",
        "11 - Violent Storm",
        "12 - Hurricane"
    ];

    public array $seas = [
        "0 - (No Wave)",
        "1 - (0-0.1m)",
        "2 - (0.1-0.5m)",
        "3 - (0.5-1.25m)",
        "4 - (1.25-2.5m)",
        "5 - (2.5-4.0m)",
        "6 - (4.0-6.0m)",
        "7 - (6.0-9.0m)",
        "8 - (9.0-14.0m)",
        "9 - (14+m)"
    ];

    public array $rob_data = [
        'HSFO' => ['tanks' => [], 'summary' => []],
        'BIOFUEL' => ['tanks' => [], 'summary' => []],
        'VLSFO' => ['tanks' => [], 'summary' => []],
        'LSFO' => ['tanks' => [], 'summary' => []],
        'ULSFO' => ['tanks' => [], 'summary' => []],
        'VLSMGO' => ['tanks' => [], 'summary' => []],
        'LSMGO' => ['tanks' => [], 'summary' => []],
        'ULSMGO' => ['tanks' => [], 'summary' => []]
    ];

    public array $weather_blocks = [];

    public function mount($id)
    {
        $this->voyageId = $id;
        $this->loadVoyageData();
    }

    private function loadVoyageData()
    {
        $this->voyage = Voyage::with([
            'vessel',
            'noon_report',
            'remarks',
            'master_info',
            'rob_tanks',
            'rob_fuel_reports',
            'weather_observations'
        ])->findOrFail($this->voyageId);

        // Check if user has permission to edit this voyage
        if ($this->voyage->unit_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this voyage.');
        }

        // Load vessel data
        $this->vessel_id = $this->voyage->vessel_id;
        $this->vesselName = $this->voyage->vessel->name;

        // Load voyage details
        $this->voyage_no = $this->voyage->voyage_no;
        $this->port_gmt_offset = $this->voyage->port_gmt_offset;
        $this->all_fast_datetime = $this->voyage->all_fast_datetime;
        $this->gmt_offset = $this->voyage->gmt_offset;
        $this->port = $this->voyage->port;
        $this->bunkering_port = $this->voyage->bunkering_port;
        $this->supplier = $this->voyage->supplier;

        // Load noon report data if exists
        if ($this->voyage->noon_report) {
            $noonReport = $this->voyage->noon_report;

            $this->cp_ordered_speed = $noonReport->cp_ordered_speed;
            $this->me_cons_cp_speed = $noonReport->me_cons_cp_speed;
            $this->obs_distance = $noonReport->obs_distance;
            $this->steaming_time = $noonReport->steaming_time;
            $this->avg_speed = $noonReport->avg_speed;
            $this->distance_to_go = $noonReport->distance_to_go;
            $this->course = $noonReport->course;
            $this->breakdown = $noonReport->breakdown;
            $this->avg_rpm = $noonReport->avg_rpm;
            $this->engine_distance = $noonReport->engine_distance;
            $this->slip = $noonReport->slip;
            $this->me_output_mcr = $noonReport->me_output_mcr;
            $this->avg_power = $noonReport->avg_power;
            $this->logged_distance = $noonReport->logged_distance;
            $this->speed_through_water = $noonReport->speed_through_water;
            $this->next_port = $noonReport->next_port;
            $this->eta_next_port = $noonReport->eta_next_port;
            $this->eta_gmt_offset = $noonReport->eta_gmt_offset;
            $this->anchored_hours = $noonReport->anchored_hours;
            $this->drifting_hours = $noonReport->drifting_hours;
            $this->maneuvering_hours = $noonReport->maneuvering_hours;

            // Noon Conditions
            $this->condition = $noonReport->condition;
            $this->displacement = $noonReport->displacement;
            $this->cargo_name = $noonReport->cargo_name;
            $this->cargo_weight = $noonReport->cargo_weight;
            $this->ballast_weight = $noonReport->ballast_weight;
            $this->fresh_water = $noonReport->fresh_water;
            $this->fwd_draft = $noonReport->fwd_draft;
            $this->aft_draft = $noonReport->aft_draft;
            $this->gm = $noonReport->gm;

            // Voyage Itinerary
            $this->next_port_voyage = $noonReport->next_port_voyage;
            $this->via = $noonReport->via;
            $this->eta_lt = $noonReport->eta_lt;
            $this->gmt_offset_voyage = $noonReport->gmt_offset_voyage;
            $this->distance_to_go_voyage = $noonReport->distance_to_go_voyage;
            $this->projected_speed = $noonReport->projected_speed;

            // Average Weather
            $this->wind_force_average_weather = $noonReport->wind_force_average_weather;
            $this->swell = $noonReport->swell;
            $this->sea_current = $noonReport->sea_current;
            $this->sea_temp = $noonReport->sea_temp;
            $this->observed_wind = $noonReport->observed_wind;
            $this->wind_sea_height = $noonReport->wind_sea_height;
            $this->sea_current_direction = $noonReport->sea_current_direction;
            $this->swell_height = $noonReport->swell_height;
            $this->observed_sea = $noonReport->observed_sea;
            $this->air_temp = $noonReport->air_temp;
            $this->observed_swell = $noonReport->observed_swell;
            $this->sea_ds = $noonReport->sea_ds;
            $this->atm_pressure = $noonReport->atm_pressure;

            // Bad Weather
            $this->wind_force_previous = $noonReport->wind_force_previous;
            $this->wind_force_current = $noonReport->wind_force_current;
            $this->sea_state_previous = $noonReport->sea_state_previous;
            $this->sea_state_current = $noonReport->sea_state_current;

            // Diesel Engine
            $this->dg1_run_hours = $noonReport->dg1_run_hours;
            $this->dg2_run_hours = $noonReport->dg2_run_hours;
            $this->dg3_run_hours = $noonReport->dg3_run_hours;
        }

        // Load ROB data
        $this->loadRobData();

        // Load weather blocks
        $this->loadWeatherBlocks();

        // Load remarks and master info
        if ($this->voyage->remarks) {
            $this->remarks = $this->voyage->remarks->remarks;
        }
        if ($this->voyage->master_info) {
            $this->master_info = $this->voyage->master_info->master_info;
        }
    }

    private function loadRobData()
    {
        // Initialize empty structure first
        foreach (array_keys($this->rob_data) as $type) {
            $this->rob_data[$type] = [
                'tanks' => [],
                'summary' => [
                    'previous' => '',
                    'current' => '',
                    'me_propulsion' => '',
                    'ae_cons' => '',
                    'boiler_cons' => '',
                    'incinerators' => '',
                    'me_24' => '',
                    'ae_24' => '',
                    'total_cons' => '',
                    'me_cyl_grade' => '',
                    'me_cyl_qty' => '',
                    'me_cyl_hrs' => '',
                    'me_cyl_cons' => '',
                    'me_cc_qty' => '',
                    'me_cc_hrs' => '',
                    'me_cc_cons' => '',
                    'ae_cc_qty' => '',
                    'ae_cc_hrs' => '',
                    'ae_cc_cons' => ''
                ]
            ];
        }

        // Load tank data
        foreach ($this->voyage->rob_tanks as $tank) {
            $fuelType = $tank->grade;
            if (isset($this->rob_data[$fuelType])) {
                $this->rob_data[$fuelType]['tanks'][] = [
                    'tank_no' => $tank->tank_no,
                    'description' => $tank->description,
                    'grade' => $tank->grade,
                    'capacity' => $tank->capacity,
                    'unit' => $tank->unit,
                    'rob' => $tank->rob,
                    'supply_date' => $tank->supply_date,
                ];
            }
        }

        // Load fuel report summary data
        foreach ($this->voyage->rob_fuel_reports as $report) {
            $fuelType = $report->fuel_type;
            if (isset($this->rob_data[$fuelType])) {
                $this->rob_data[$fuelType]['summary'] = [
                    'previous' => $report->previous,
                    'current' => $report->current,
                    'me_propulsion' => $report->me_propulsion,
                    'ae_cons' => $report->ae_cons,
                    'boiler_cons' => $report->boiler_cons,
                    'incinerators' => $report->incinerators,
                    'me_24' => $report->me_24,
                    'ae_24' => $report->ae_24,
                    'total_cons' => $report->total_cons,
                    'me_cyl_grade' => $report->me_cyl_grade,
                    'me_cyl_qty' => $report->me_cyl_qty,
                    'me_cyl_hrs' => $report->me_cyl_hrs,
                    'me_cyl_cons' => $report->me_cyl_cons,
                    'me_cc_qty' => $report->me_cc_qty,
                    'me_cc_hrs' => $report->me_cc_hrs,
                    'me_cc_cons' => $report->me_cc_cons,
                    'ae_cc_qty' => $report->ae_cc_qty,
                    'ae_cc_hrs' => $report->ae_cc_hrs,
                    'ae_cc_cons' => $report->ae_cc_cons,
                ];
            }
        }

        // Ensure each fuel type has at least one empty tank row for editing
        foreach (array_keys($this->rob_data) as $type) {
            if (empty($this->rob_data[$type]['tanks'])) {
                $this->addRobRow($type);
            }
        }
    }

    private function loadWeatherBlocks()
    {
        // Initialize default weather blocks if none exist
        $defaultBlocks = [
            '12:00 - 18:00',
            '18:00 - 00:00',
            '00:00 - 06:00',
            '06:00 - 12:00'
        ];

        $this->weather_blocks = [];

        if ($this->voyage->weather_observations->count() > 0) {
            foreach ($this->voyage->weather_observations as $observation) {
                $this->weather_blocks[] = [
                    'time_block' => $observation->time_block,
                    'wind_force' => $observation->wind_force,
                    'wind_direction' => $observation->wind_direction,
                    'swell_height' => $observation->swell_height,
                    'swell_direction' => $observation->swell_direction,
                    'wind_sea_height' => $observation->wind_sea_height,
                    'sea_direction' => $observation->sea_direction,
                    'sea_ds' => $observation->sea_ds,
                ];
            }
        } else {
            // Create default empty blocks
            foreach ($defaultBlocks as $block) {
                $this->weather_blocks[] = [
                    'time_block' => $block,
                    'wind_force' => '',
                    'wind_direction' => '',
                    'swell_height' => '',
                    'swell_direction' => '',
                    'wind_sea_height' => '',
                    'sea_direction' => '',
                    'sea_ds' => '',
                ];
            }
        }
    }

    public function addRobRow($type)
    {
        $nextNo = count($this->rob_data[$type]['tanks']) + 1;

        $this->rob_data[$type]['tanks'][] = [
            'tank_no' => $nextNo,
            'description' => '',
            'grade' => $type,
            'capacity' => '',
            'unit' => 'MT',
            'rob' => '',
            'supply_date' => '',
        ];
    }

    public function removeRobRow($type, $index)
    {
        unset($this->rob_data[$type]['tanks'][$index]);
        $this->rob_data[$type]['tanks'] = array_values($this->rob_data[$type]['tanks']);
        foreach ($this->rob_data[$type]['tanks'] as $i => &$tank) {
            $tank['tank_no'] = $i + 1;
        }
    }

    public function save()
    {
        $this->validate([
            'vessel_id' => 'required|exists:vessels,id',
            'master_info' => 'nullable|string|max:5000',
        ]);

        $vessel = ModelsVessel::findOrFail($this->vessel_id);

        // if (!$vessel->is_active) {
        //     Toaster::error('This vessel has been deactivated. It will no longer be available for report updates.');
        //     return;
        // }

        // Store old values for audit
        $oldValues = $this->voyage->toArray();

        // Update voyage basic details
        $this->voyage->update([
            'voyage_no' => $this->voyage_no,
            'port_gmt_offset' => $this->port_gmt_offset,
            'all_fast_datetime' => $this->all_fast_datetime,
            'gmt_offset' => $this->gmt_offset,
            'port' => $this->port,
            'bunkering_port' => $this->bunkering_port,
            'supplier' => $this->supplier,
        ]);

        // Update noon report
        $this->voyage->noon_report()->updateOrCreate(
            ['voyage_id' => $this->voyage->id],
            [
                // Details Since Last Report
                'cp_ordered_speed' => $this->cp_ordered_speed,
                'me_cons_cp_speed' => $this->me_cons_cp_speed,
                'obs_distance' => $this->obs_distance,
                'steaming_time' => $this->steaming_time,
                'avg_speed' => $this->avg_speed,
                'distance_to_go' => $this->distance_to_go,
                'course' => $this->course,
                'breakdown' => $this->breakdown,
                'avg_rpm' => $this->avg_rpm,
                'engine_distance' => $this->engine_distance,
                'slip' => $this->slip,
                'me_output_mcr' => $this->me_output_mcr,
                'avg_power' => $this->avg_power,
                'logged_distance' => $this->logged_distance,
                'speed_through_water' => $this->speed_through_water,
                'next_port' => $this->next_port,
                'eta_next_port' => $this->eta_next_port,
                'eta_gmt_offset' => $this->eta_gmt_offset,
                'anchored_hours' => $this->anchored_hours,
                'drifting_hours' => $this->drifting_hours,
                'maneuvering_hours' => $this->maneuvering_hours,

                // Noon Conditions
                'condition' => $this->condition,
                'displacement' => $this->displacement,
                'cargo_name' => $this->cargo_name,
                'cargo_weight' => $this->cargo_weight,
                'ballast_weight' => $this->ballast_weight,
                'fresh_water' => $this->fresh_water,
                'fwd_draft' => $this->fwd_draft,
                'aft_draft' => $this->aft_draft,
                'gm' => $this->gm,

                // Voyage Itinerary
                'next_port_voyage' => $this->next_port_voyage,
                'via' => $this->via,
                'eta_lt' => $this->eta_lt,
                'gmt_offset_voyage' => $this->gmt_offset_voyage,
                'distance_to_go_voyage' => $this->distance_to_go_voyage,
                'projected_speed' => $this->projected_speed,

                // Average Weather
                'wind_force_average_weather' => $this->wind_force_average_weather,
                'swell' => $this->swell,
                'sea_current' => $this->sea_current,
                'sea_temp' => $this->sea_temp,
                'observed_wind' => $this->observed_wind,
                'wind_sea_height' => $this->wind_sea_height,
                'sea_current_direction' => $this->sea_current_direction,
                'swell_height' => $this->swell_height,
                'observed_sea' => $this->observed_sea,
                'air_temp' => $this->air_temp,
                'observed_swell' => $this->observed_swell,
                'sea_ds' => $this->sea_ds,
                'atm_pressure' => $this->atm_pressure,

                // Bad Weather
                'wind_force_previous' => $this->wind_force_previous,
                'wind_force_current' => $this->wind_force_current,
                'sea_state_previous' => $this->sea_state_previous,
                'sea_state_current' => $this->sea_state_current,

                // Diesel Engine
                'dg1_run_hours' => $this->dg1_run_hours,
                'dg2_run_hours' => $this->dg2_run_hours,
                'dg3_run_hours' => $this->dg3_run_hours,
            ]
        );

        // Update ROB data
        $this->voyage->rob_tanks()->delete();
        $this->voyage->rob_fuel_reports()->delete();

        foreach ($this->rob_data as $fuelType => $data) {
            $hasTankData = collect($data['tanks'])->filter(function ($tank) {
                return !empty($tank['description']) || !empty($tank['rob']) ||
                    !empty($tank['capacity']) || !empty($tank['supply_date']);
            });

            $hasSummaryData = collect($data['summary'])->filter(function ($value) {
                return !empty($value);
            });

            if ($hasTankData->isNotEmpty()) {
                foreach ($hasTankData as $tank) {
                    $this->voyage->rob_tanks()->create([
                        'tank_no' => $tank['tank_no'] ?? '',
                        'description' => $tank['description'] ?? '',
                        'grade' => $tank['grade'] ?? $fuelType,
                        'capacity' => $tank['capacity'] ?? '',
                        'unit' => $tank['unit'] ?? '',
                        'rob' => $tank['rob'] ?? '',
                        'supply_date' => $tank['supply_date'] ?: null,
                    ]);
                }
            }

            if ($hasTankData->isNotEmpty() || $hasSummaryData->isNotEmpty()) {
                $this->voyage->rob_fuel_reports()->create(array_merge($data['summary'], [
                    'fuel_type' => $fuelType,
                ]));
            }
        }

        // Update weather observations
        $this->voyage->weather_observations()->delete();
        foreach ($this->weather_blocks as $block) {
            $this->voyage->weather_observations()->create([
                'time_block' => $block['time_block'] ?? null,
                'wind_force' => $block['wind_force'] ?? null,
                'wind_direction' => $block['wind_direction'] ?? null,
                'swell_height' => $block['swell_height'] ?? null,
                'swell_direction' => $block['swell_direction'] ?? null,
                'wind_sea_height' => $block['wind_sea_height'] ?? null,
                'sea_direction' => $block['sea_direction'] ?? null,
                'sea_ds' => $block['sea_ds'] ?? null,
            ]);
        }

        // Update remarks and master info
        $this->voyage->remarks()->updateOrCreate(
            ['voyage_id' => $this->voyage->id],
            ['remarks' => $this->remarks]
        );

        $this->voyage->master_info()->updateOrCreate(
            ['voyage_id' => $this->voyage->id],
            ['master_info' => $this->master_info]
        );

        // Create notification
        Notification::create([
            'vessel_id' => $this->voyage->vessel_id,
            'text' => "{$this->voyage->report_type} report has been updated.",
        ]);

        // Create audit log
        Audit::create([
            'user' => Auth::user()->name,
            'event' => 'updated_noon_report',
            'old_values' => $oldValues,
            'new_values' => $this->voyage->fresh()->toArray(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);

        Toaster::success('Noon Report Updated Successfully.');

        return redirect()->route('table-noon-report');
    }

    public function render()
    {
        return view('livewire.unit.edit-noon-report');
    }
}
