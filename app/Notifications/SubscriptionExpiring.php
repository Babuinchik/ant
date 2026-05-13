<?php

namespace App\Notifications;

use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class SubscriptionExpiring extends Notification
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
            ->subject('Срок подписки истекает')
            ->line(
                'Подписка ' . $this->subscription->order->tariff->name .
                ' истекает ' . $this->subscription->expires_at->format('d.m.Y')
            );
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => 'Подписка истекает ' . $this->subscription->expires_at->format('d.m.Y'),
        ];
    }
}