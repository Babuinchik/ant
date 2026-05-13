<?php

namespace App\Console\Commands;

use App\Models\Subscription;
use App\Notifications\SubscriptionExpiring;
use Illuminate\Console\Command;

class CheckExpiringSubscriptions extends Command
{
    protected $signature = 'subscriptions:check-expiring';
    protected $description = 'Уведомить пользователей о скором истечении подписки';

    public function handle()
    {
        $subscriptions = Subscription::where('status', 'active')
            ->whereBetween('expires_at', [now(), now()->addDays(7)])
            ->get();

        foreach ($subscriptions as $sub) {
            $sub->user->notify(new SubscriptionExpiring($sub));
        }

        $this->info('Уведомления отправлены (' . $subscriptions->count() . ' шт.)');
    }
}