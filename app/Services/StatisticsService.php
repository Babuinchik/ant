<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Subscription;
use App\Models\User;

class StatisticsService
{
    public function get(): array
    {
        return [
            'revenue' => Order::where('status', 'paid')->sum('amount'),
            'active_subscriptions' => Subscription::where('status', 'active')
                ->where('expires_at', '>', now())
                ->count(),
            'total_users' => User::count(),
            'conversion_rate' => User::count() > 0
                ? round(
                    (Order::where('status', 'paid')->distinct('user_id')->count('user_id') / User::count()) * 100,
                    2
                )
                : 0,
        ];
    }
}