<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Subscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    // Список подписок текущего пользователя
    public function index(Request $request)
    {
        return $request->user()
            ->subscriptions()
            ->with('order.tariff')
            ->latest()
            ->get();
    }

    // Отмена подписки
    public function cancel(Request $request, Subscription $subscription)
    {
        // Проверяем, что подписка принадлежит текущему пользователю
        if ($subscription->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Доступ запрещён'], 403);
        }

        $subscription->update(['status' => 'revoked']);
        return response()->json(['message' => 'Подписка отменена']);
    }

    // Получить лицензионный ключ
    public function license(Request $request, Subscription $subscription)
    {
        if ($subscription->user_id !== $request->user()->id) {
            return response()->json(['message' => 'Доступ запрещён'], 403);
        }

        return response()->json(['license_key' => $subscription->license_key]);
    }
}