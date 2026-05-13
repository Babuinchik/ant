<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Tariff;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@cockperskiy.com'],
            ['name' => 'Admin', 'password' => Hash::make('password'), 'role' => 'admin']
        );
        User::firstOrCreate(
            ['email' => 'user@cockperskiy.com'],
            ['name' => 'User', 'password' => Hash::make('password'), 'role' => 'user']
        );

        Tariff::create([
            'name' => 'Basic',
            'description' => 'Базовая защита',
            'price' => 999.00,
            'duration_days' => 365,
            'max_devices' => 1,
            'protection_level' => 'basic',
        ]);

        Tariff::create([
            'name' => 'Pro',
            'description' => 'Продвинутая защита',
            'price' => 1999.00,
            'duration_days' => 365,
            'max_devices' => 3,
            'protection_level' => 'pro',
        ]);

        Tariff::create([
            'name' => 'Ultimate',
            'description' => 'Максимальная защита',
            'price' => 2999.00,
            'duration_days' => 365,
            'max_devices' => 5,
            'protection_level' => 'ultimate',
        ]);
    }
}