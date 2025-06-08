<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Engine extends Model
{
    protected $fillable = [
        'voyage_id',
        'avg_me_rpm',
        'avg_me_kw',
        'tdr',
        'tst',
        'slip',
    ];

    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }
}
