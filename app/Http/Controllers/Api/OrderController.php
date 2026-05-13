<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Tariff;
use App\Services\PurchaseService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(Request $request, PurchaseService $purchaseService)
    {
        $request->validate([
            'tariff_id' => 'required|exists:tariffs,id',
        ]);

        $tariff = Tariff::findOrFail($request->tariff_id);
        $order = $purchaseService->createOrder($request->user(), $tariff);

        // Загружаем связь, чтобы вернуть вместе с подпиской
        return response()->json($order->load('subscription'), 201);
    }

    public function index(Request $request)
    {
        return $request->user()->orders()->with('tariff')->latest()->get();
    }
}