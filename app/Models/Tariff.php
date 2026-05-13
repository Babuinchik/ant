<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tariff extends Model
{
    protected $fillable = [
        'name', 'description', 'price',
        'duration_days', 'max_devices', 'protection_level'
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}