<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    protected $fillable = [
        'voyage_id',
        'port_departure',
        'port_arrival',
    ];

    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }
}
