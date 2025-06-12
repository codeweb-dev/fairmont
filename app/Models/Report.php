<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $fillable = [
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

        // Noon Condition
        'condition',
        'displacement',
        'cargo_name',
        'cargo_weight',
        'ballast_weight',
        'fresh_water',
        'fwd_draft',
        'aft_draft',
        'gm',

        // Voyage Itinerary
        'next_port_voyage',
        'via',
        'eta_lt',
        'gmt_offset_voyage',
        'distance_to_go_voyage',
        'projected_speed',

        // Average Weather
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

        // Bad Weather
        'wind_force_previous',
        'wind_force_current',
        'sea_state_previous',
        'sea_state_current',

        // Diesel Engine
        'dg1_run_hours',
        'dg2_run_hours',
        'dg3_run_hours',
    ];

    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }
}
