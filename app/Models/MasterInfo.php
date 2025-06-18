<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterInfo extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'voyage_id',
        'master_info',
    ];

    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }
}
