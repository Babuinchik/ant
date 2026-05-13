<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Tariff;
use App\Services\StatisticsService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function statistics(StatisticsService $stats)
    {
        return response()->json($stats->get());
    }

    public function users()
    {
        return User::all();
    }

    public function blockUser(User $user)
    {
        $user->update(['role' => 'blocked']);
        return response()->json(['message' => 'Пользователь заблокирован']);
    }

    public function storeTariff(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'duration_days' => 'required|integer',
            'max_devices' => 'required|integer',
            'protection_level' => 'required|string',
        ]);

        $tariff = Tariff::create($data);
        return response()->json($tariff, 201);
    }

    public function updateTariff(Request $request, Tariff $tariff)
    {
        $tariff->update($request->all());
        return response()->json($tariff);
    }

    public function destroyTariff(Tariff $tariff)
    {
        $tariff->delete();
        return response()->json(null, 204);
    }
}