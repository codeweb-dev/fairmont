<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Received extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'voyage_id',
        'hsfo',
        'biofuel',
        'vlsfo',
        'lsmgo',
        'me_cc_oil',
        'mc_cyl_oil',
        'ge_cc_oil',
        'fw',
        'fw_produced',
    ];

    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }
}
