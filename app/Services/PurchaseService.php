<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Subscription;
use App\Models\User;
use App\Models\Tariff;
use App\Notifications\PurchaseSuccessful;
use Illuminate\Support\Str;

class PurchaseService
{
    public function createOrder(User $user, Tariff $tariff): Order
    {
        $order = $user->orders()->create([
            'tariff_id' => $tariff->id,
            'amount' => $tariff->price,
            'status' => 'pending',
        ]);

        // Имитация оплаты
        $order->update(['status' => 'paid']);

        $licenseKey = strtoupper(Str::random(8) . '-' . Str::random(8) . '-' . Str::random(8));
        $subscription = $user->subscriptions()->create([
            'order_id' => $order->id,
            'license_key' => $licenseKey,
            'status' => 'active',
            'expires_at' => now()->addDays($tariff->duration_days),
        ]);
        
        // Уведомление отключено, т.к. нет таблицы notifications + не настроена почта
        //$user->notify(new PurchaseSuccessful($subscription));

        return $order;
    }
}