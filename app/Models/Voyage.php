<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voyage extends Model
{
    protected $fillable = [
        'vessel_id',
        'unit_id',
        'report_type',
        'voyage_no',
        'all_fast_datetime',
        'port',
        'gmt_offset',
    ];

    public function robs()
    {
        return $this->hasMany(Rob::class);
    }

    public function vessel()
    {
        return $this->belongsTo(Vessel::class);
    }

    public function unit()
    {
        return $this->belongsTo(User::class, 'unit_id');
    }
}
