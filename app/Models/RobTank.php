<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RobTank extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'voyage_id',
        'fuel_type',
        'tank_no',
        'description',
        'grade',
        'capacity',
        'unit',
        'rob',
        'supply_date',
    ];

    public function rob_fuel_report()
    {
        return $this->belongsTo(RobFuelReport::class, 'fuel_type', 'fuel_type')
            ->whereColumn('voyage_id', 'voyage_id');
    }

    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }
}
