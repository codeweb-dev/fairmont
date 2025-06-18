<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Engine extends Model
{
    use SoftDeletes;

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
