<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AssociatedInformation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'voyage_id',
        'port_delivery',
        'eosp',
        'eosp_gmt',
        'barge',
        'barge_gmt',
        'cosp',
        'cosp_gmt',
        'anchor',
        'anchor_gmt',
        'pumping',
        'pumping_gmt',
    ];

    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }
}
