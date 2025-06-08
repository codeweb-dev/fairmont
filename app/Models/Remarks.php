<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Remarks extends Model
{
    protected $fillable = [
        'voyage_id',
        'remarks',
    ];

    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }
}
