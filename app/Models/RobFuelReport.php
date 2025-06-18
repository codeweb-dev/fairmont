<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RobFuelReport extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'voyage_id',
        'fuel_type',
        // ROB summary
        'previous',
        'current',
        'me_propulsion',
        'ae_cons',
        'boiler_cons',
        'incinerators',
        'me_24',
        'ae_24',
        'total_cons',
        // Lube - ME CYL
        'me_cyl_grade',
        'me_cyl_qty',
        'me_cyl_hrs',
        'me_cyl_cons',
        // Lube - ME CC
        'me_cc_qty',
        'me_cc_hrs',
        'me_cc_cons',
        // Lube - AE CC
        'ae_cc_qty',
        'ae_cc_hrs',
        'ae_cc_cons',
    ];

    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }

    public function rob_tanks()
    {
        return $this->hasMany(RobTank::class, 'fuel_type', 'fuel_type')
            ->whereColumn('voyage_id', 'voyage_id');
    }
}
