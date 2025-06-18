<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Port extends Model
{
    use SoftDeletes;

    protected $fillable = ['voyage_id', 'port', 'activity', 'eta_etb', 'etcd', 'cargo', 'cargo_qty', 'remarks', 'voyage_no', 'charterers'];

    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }

    public function agents()
    {
        return $this->hasMany(Agent::class);
    }
}
