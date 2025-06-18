<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BunkerType extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'voyage_id',
        'hsfo_quantity',
        'hsfo_viscosity',
        'biofuel_quantity',
        'biofuel_viscosity',
        'vlsfo_quantity',
        'vlsfo_viscosity',
        'lsmgo_quantity',
        'lsmgo_viscosity',
    ];

    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }
}
