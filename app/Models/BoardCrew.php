<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BoardCrew extends Model
{
    protected $fillable = [
        'no',
        'voyage_id',
        'vessel_name',
        'report_type',
        'crew_surname',
        'crew_first_name',
        'rank',
        'crew_nationality',
        'joining_date',
        'contract_completion',
        'current_date',
        'days_contract_completion',
        'months_on_board',
    ];

    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }
}
