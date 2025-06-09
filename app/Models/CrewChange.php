<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CrewChange extends Model
{
    protected $fillable = [
        'vessel_name',
        'voyage_id',
        'port',
        'country',
        'joiners_boarding',
        'off_signers',
        'joiner_ranks',
        'off_signers_ranks',
        'total_crew_change',
        'reason_change',
        'remarks',
    ];

    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }
}
