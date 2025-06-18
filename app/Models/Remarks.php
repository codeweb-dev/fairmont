<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Remarks extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'voyage_id',
        'remarks',
    ];

    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }
}
