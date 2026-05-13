<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    protected $fillable = [
        'subscription_id', 'device_identifier', 'device_name', 'os', 'activated_at'
    ];

    public function subscription()
    {
        return $this->belongsTo(Subscription::class);
    }
}