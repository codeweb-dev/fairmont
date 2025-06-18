<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Location extends Model
{
    use SoftDeletes;

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
