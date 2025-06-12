<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeatherObservation extends Model
{
    protected $fillable = [
        'voyage_id',
        'time_block',
        'wind_force',
        'wind_direction',
        'swell_height',
        'swell_direction',
        'wind_sea_height',
        'sea_direction',
        'sea_ds',
    ];

    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }
}
