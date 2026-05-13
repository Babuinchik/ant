<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\LicenseService;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function activate(Request $request, LicenseService $licenseService)
    {
        $request->validate([
            'license_key' => 'required|string',
            'device_name' => 'required|string',
            'os' => 'required|string',
        ]);

        $result = $licenseService->activateDevice($request->user(), $request->all());

        if (!$result['success']) {
            return response()->json($result, 422);
        }

        return response()->json($result, 200);
    }

    public function status(Request $request)
    {
        $request->validate([
            'license_key' => 'required|string',
        ]);

        $subscription = \App\Models\Subscription::where('license_key', $request->license_key)->first();

        return response()->json([
            'valid' => $subscription && $subscription->isActive(),
        ]);
    }
}