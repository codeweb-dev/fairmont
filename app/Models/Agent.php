<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = ['port_id', 'name', 'address', 'pic_name', 'telephone', 'mobile', 'email'];

    public function port()
    {
        return $this->belongsTo(Port::class);
    }
}
