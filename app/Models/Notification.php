<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = [
        'text',
        'vessel_id',
        'user_id',
        'is_read',
    ];

    public function vessel()
    {
        return $this->belongsTo(Vessel::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
