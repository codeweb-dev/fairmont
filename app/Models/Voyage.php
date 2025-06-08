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

        'bunkering_port',
        'supplier',
        'port_etd',
        'port_gmt_offset',
        'bunker_completed',
        'bunker_gmt_offset',
    ];

    // All Fast Report Relation
    public function robs()
    {
        return $this->hasMany(Rob::class);
    }
    // End All Fast

    // Bunker Report Relation
    public function bunker()
    {
        return $this->hasOne(BunkerType::class);
    }

    public function assiociated_information()
    {
        return $this->hasOne(AssociatedInformation::class);
    }
    // End Bunker

    public function master_info()
    {
        return $this->hasOne(MasterInfo::class);
    }

    public function remarks()
    {
        return $this->hasOne(Remarks::class);
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
