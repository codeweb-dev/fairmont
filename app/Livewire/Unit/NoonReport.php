<?php

namespace App\Livewire\Unit;

use App\Models\Notification;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Masmerise\Toaster\Toaster;
use App\Models\Voyage;
use Illuminate\Support\Facades\Session;

class NoonReport extends Component
{
    public $vessel_id;

    public $master_info;
    public $remarks;
    public $vesselName = null;

    // Voyage Details
    public $voyage_no;
    public $port_gmt_offset = ''; // as Report Type
    public $all_fast_datetime; // as Date/Time (LT)
    public $gmt_offset;
    public $port; // as Latitude
    public $bunkering_port; // as Longtitude
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
        "GMT+14:00",
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
        "337.5 - NNW",
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
        "12 - Hurricane",
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
        "9 - (14+m)",
    ];
    public array $robs = [];

    public array $rob_data = [
        'HSFO' => [
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
                // Lube
                'me_cyl_grade' => '',
                'me_cyl_qty' => '',
                'me_cyl_hrs' => '',
                'me_cyl_cons' => '',
                'me_cc_qty' => '',
                'me_cc_hrs' => '',
                'me_cc_cons' => '',
                'ae_cc_qty' => '',
                'ae_cc_hrs' => '',
                'ae_cc_cons' => '',
            ]
        ],
        'BIOFUEL' => [
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
                // Lube
                'me_cyl_grade' => '',
                'me_cyl_qty' => '',
                'me_cyl_hrs' => '',
                'me_cyl_cons' => '',
                'me_cc_qty' => '',
                'me_cc_hrs' => '',
                'me_cc_cons' => '',
                'ae_cc_qty' => '',
                'ae_cc_hrs' => '',
                'ae_cc_cons' => '',
            ]
        ],
        'VLSFO' => [
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
                // Lube
                'me_cyl_grade' => '',
                'me_cyl_qty' => '',
                'me_cyl_hrs' => '',
                'me_cyl_cons' => '',
                'me_cc_qty' => '',
                'me_cc_hrs' => '',
                'me_cc_cons' => '',
                'ae_cc_qty' => '',
                'ae_cc_hrs' => '',
                'ae_cc_cons' => '',
            ]
        ],
        'LSMGO' => [
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
                // Lube
                'me_cyl_grade' => '',
                'me_cyl_qty' => '',
                'me_cyl_hrs' => '',
                'me_cyl_cons' => '',
                'me_cc_qty' => '',
                'me_cc_hrs' => '',
                'me_cc_cons' => '',
                'ae_cc_qty' => '',
                'ae_cc_hrs' => '',
                'ae_cc_cons' => '',
            ]
        ],
    ];

    public array $weather_blocks = [
        [
            'time_block' => '12:00 - 18:00',
            'wind_force' => '',
            'wind_direction' => '',
            'swell_height' => '',
            'swell_direction' => '',
            'wind_sea_height' => '',
            'sea_direction' => '',
            'sea_ds' => '',
        ],
        [
            'time_block' => '18:00 - 00:00',
            'wind_force' => '',
            'wind_direction' => '',
            'swell_height' => '',
            'swell_direction' => '',
            'wind_sea_height' => '',
            'sea_direction' => '',
            'sea_ds' => '',
        ],
        [
            'time_block' => '00:00 - 06:00',
            'wind_force' => '',
            'wind_direction' => '',
            'swell_height' => '',
            'swell_direction' => '',
            'wind_sea_height' => '',
            'sea_direction' => '',
            'sea_ds' => '',
        ],
        [
            'time_block' => '06:00 - 12:00',
            'wind_force' => '',
            'wind_direction' => '',
            'swell_height' => '',
            'swell_direction' => '',
            'wind_sea_height' => '',
            'sea_direction' => '',
            'sea_ds' => '',
        ],
    ];

    protected $listeners = ['saveDraft'];

    public function mount()
    {
        $user = Auth::user();
        $vessel = $user->vessels()->first();

        if ($vessel) {
            $this->vessel_id = $vessel->id;
            $this->vesselName = $vessel->name;
        } else {
            return redirect()->route('unassigned');
        }

        foreach (array_keys($this->rob_data) as $type) {
            $this->addRobRow($type);
        }

        $this->loadDraft();
    }

    public function updated($property)
    {
        $this->saveDraft(); // Auto-save on any property update
    }

    public function saveDraft()
    {
        Session::put('noon_report_draft_' . Auth::id(), $this->only(array_keys(get_object_vars($this))));
    }

    public function loadDraft()
    {
        $draft = Session::get('noon_report_draft_' . Auth::id());

        if ($draft) {
            foreach ($draft as $key => $value) {
                if (property_exists($this, $key)) {
                    $this->{$key} = $value;
                }
            }
        }
    }

    public function clearDraft()
    {
        $draftKey = 'noon_report_draft_' . Auth::id();
        Session::forget($draftKey);
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
    }

    public function save()
    {
        $this->validate([
            'vessel_id' => 'required|exists:vessels,id',
            'master_info' => 'nullable|string|max:5000',
        ]);

        $filledFuelTypes = collect($this->rob_data)->filter(function ($data) {
            return collect($data['tanks'])->contains(function ($tank) {
                return !empty($tank['description']) ||
                    !empty($tank['rob']) ||
                    !empty($tank['capacity']) ||
                    !empty($tank['supply_date']);
            });
        });

        if ($filledFuelTypes->isEmpty()) {
            Toaster::error('At least one ROB tank must have data before submitting.');
            return;
        }

        $voyage = Voyage::create([
            'vessel_id' => $this->vessel_id,
            'unit_id' => Auth::id(),
            'report_type' => 'Noon Report',
            'voyage_no' => $this->voyage_no,
            'port_gmt_offset' => $this->port_gmt_offset,
            'all_fast_datetime' => $this->all_fast_datetime,
            'gmt_offset' => $this->gmt_offset,
            'port' => $this->port,
            'bunkering_port' => $this->bunkering_port,
            'supplier' => $this->supplier,
        ]);

        Notification::create([
            'text' => "{$voyage->report_type} report has been created.",
        ]);

        foreach ($this->rob_data as $fuelType => $data) {
            $hasTankData = collect($data['tanks'])->filter(function ($tank) {
                return !empty($tank['description']) ||
                    !empty($tank['rob']) ||
                    !empty($tank['capacity']) ||
                    !empty($tank['supply_date']);
            });

            $hasSummaryData = collect($data['summary'])->filter(function ($value) {
                return !empty($value);
            });

            if ($hasTankData->isNotEmpty()) {
                foreach ($hasTankData as $tank) {
                    $voyage->rob_tanks()->create([
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
                $voyage->rob_fuel_reports()->create(array_merge($data['summary'], [
                    'fuel_type' => $fuelType,
                ]));
            }
        }

        foreach ($this->weather_blocks as $block) {
            $voyage->weather_observations()->create([
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

        $voyage->noon_report()->create([
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
        ]);
        $voyage->remarks()->create(['remarks' => $this->remarks]);
        $voyage->master_info()->create(['master_info' => $this->master_info]);

        Toaster::success('Noon Report Created Successfully.');
        $this->clearDraft();
        $this->clearForm();

        $this->redirect('/table-noon-report');
    }

    public function export()
    {
        Toaster::info('Export feature not implemented yet.');
    }

    public function clearForm()
    {
        $this->clearDraft();

        $this->reset([
            'remarks',
            'master_info',
            'voyage_no',
            'port_gmt_offset',
            'all_fast_datetime',
            'gmt_offset',
            'port',
            'bunkering_port',
            'supplier',
            'cp_ordered_speed',
            'me_cons_cp_speed',
            'obs_distance',
            'steaming_time',
            'avg_speed',
            'distance_to_go',
            'course',
            'breakdown',
            'avg_rpm',
            'engine_distance',
            'slip',
            'me_output_mcr',
            'avg_power',
            'logged_distance',
            'speed_through_water',
            'next_port',
            'eta_next_port',
            'eta_gmt_offset',
            'anchored_hours',
            'drifting_hours',
            'maneuvering_hours',
            'condition',
            'displacement',
            'cargo_name',
            'cargo_weight',
            'ballast_weight',
            'fresh_water',
            'fwd_draft',
            'aft_draft',
            'gm',
            'next_port_voyage',
            'via',
            'eta_lt',
            'gmt_offset_voyage',
            'distance_to_go_voyage',
            'projected_speed',
            'wind_force_average_weather',
            'swell',
            'sea_current',
            'sea_temp',
            'observed_wind',
            'wind_sea_height',
            'sea_current_direction',
            'swell_height',
            'observed_sea',
            'air_temp',
            'observed_swell',
            'sea_ds',
            'atm_pressure',
            'wind_force_previous',
            'wind_force_current',
            'sea_state_previous',
            'sea_state_current',
            'dg1_run_hours',
            'dg2_run_hours',
            'dg3_run_hours',
            'weather_blocks',
            'rob_data',
        ]);

        foreach (array_keys($this->rob_data) as $type) {
            $this->addRobRow($type);
        }

        Toaster::success('Form cleared and draft removed.');
    }

    public function render()
    {
        return view('livewire.unit.noon-report');
    }
}
