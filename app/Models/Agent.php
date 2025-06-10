<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{
    protected $fillable = ['port_id', 'name', 'address', 'pic_name', 'telephone', 'mobile', 'email', 'port_of_calling', 'country', 'purpose', 'ata_eta_date', 'ata_eta_time', 'ship_info_date', 'ship_info_time', 'gmt', 'duration_days', 'total_days'];

    public function port()
    {
        return $this->belongsTo(Port::class);
    }
}
