<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterInfo extends Model
{
    protected $fillable = [
        'voyage_id',
        'master_info',
    ];

    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }
}
