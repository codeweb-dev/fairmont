<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Voyage extends Model
{
    use SoftDeletes;

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

        'call_sign',
        'flag',
        'port_of_registry',
        'official_number',
        'imo_number',
        'class_society',
        'class_no',
        'pi_club',
        'loa',
        'lbp',
        'breadth_extreme',
        'depth_moulded',
        'height_maximum',
        'bridge_front_bow',
        'bridge_front_stern',
        'light_ship_displacement',
        'keel_laid',
        'launched',
        'delivered',
        'shipyard',
    ];

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

    // Voyage Report Relation
    public function location()
    {
        return $this->hasOne(Location::class);
    }

    public function off_hire()
    {
        return $this->hasOne(OffHire::class);
    }

    public function engine()
    {
        return $this->hasOne(Engine::class);
    }

    public function received()
    {
        return $this->hasOne(Received::class);
    }

    public function consumption()
    {
        return $this->hasOne(Consumption::class);
    }
    // End Voyage

    // For Crew Monitoring Plan Relation
    public function crew_change()
    {
        return $this->hasMany(CrewChange::class);
    }

    public function board_crew()
    {
        return $this->hasMany(BoardCrew::class);
    }
    // End Crew MOnitoring Plan

    // For Weekly Schedule Relation
    public function ports()
    {
        return $this->hasMany(Port::class);
    }
    // For Weekly Schedule

    // For Kpi Relation
    public function waste()
    {
        return $this->hasOne(Waste::class);
    }
    // End Kpi

    // For Noon Report Relation
    public function noon_report()
    {
        return $this->hasOne(Report::class);
    }

    public function weather_observations()
    {
        return $this->hasMany(WeatherObservation::class);
    }

    public function rob_tanks()
    {
        return $this->hasMany(RobTank::class);
    }

    public function rob_fuel_reports()
    {
        return $this->hasMany(RobFuelReport::class);
    }
    // End Noon Report

    public function robs()
    {
        return $this->hasMany(Rob::class);
    }

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
