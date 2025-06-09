<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Port extends Model
{
    protected $fillable = ['voyage_id', 'port', 'activity', 'eta_etb', 'etcd', 'cargo', 'cargo_qty', 'remarks'];

    public function voyage()
    {
        return $this->belongsTo(Voyage::class);
    }

    public function agents()
    {
        return $this->hasMany(Agent::class);
    }
}
