<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OffHire extends Model
{
    use SoftDeletes;

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
