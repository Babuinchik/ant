<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PurchaseSuccessful extends Notification
{
    use Queueable;

    public function __construct(public Subscription $subscription) {}

    public function via($notifiable): array
    {
        return ['mail', 'database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Подписка активирована')
            ->line('Ваш лицензионный ключ: ' . $this->subscription->license_key);
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => 'Подписка на тариф ' . $this->subscription->order->tariff->name . ' активирована',
            'license_key' => $this->subscription->license_key,
        ];
    }
}