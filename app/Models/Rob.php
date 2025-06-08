<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rob extends Model
{
    protected $fillable = [
        'voyage_id',
        'hsfo',
        'biofuel',
        'vlsfo',
        'lsmgo',
    ];

    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }
}
