<?php

namespace App\Services;

use App\Models\Subscription;
use App\Models\Device;
use App\Models\User;
use Illuminate\Support\Str;

class LicenseService
{
    public function activateDevice(User $user, array $data): array
    {
        $subscription = Subscription::where('license_key', $data['license_key'])->first();

        if (!$subscription) {
            return ['success' => false, 'message' => 'Недействительный ключ'];
        }

        if (!$subscription->isActive()) {
            return ['success' => false, 'message' => 'Подписка неактивна'];
        }

        if ($subscription->user_id !== $user->id) {
            return ['success' => false, 'message' => 'Ключ не ваш'];
        }

        $maxDevices = $subscription->order->tariff->max_devices;
        if ($subscription->devices()->count() >= $maxDevices) {
            return ['success' => false, 'message' => 'Достигнут лимит устройств'];
        }

        $device = $subscription->devices()->create([
            'device_identifier' => (string) Str::uuid(),
            'device_name' => $data['device_name'],
            'os' => $data['os'],
            'activated_at' => now(),
        ]);

        return ['success' => true, 'device' => $device];
    }
}