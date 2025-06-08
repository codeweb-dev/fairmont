<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OffHire extends Model
{
    protected $fillable = [
        'voyage_id',
        'hire_hours',
        'hire_reason',
    ];

    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }
}
