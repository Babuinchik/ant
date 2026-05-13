<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\TariffController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\SubscriptionController;
use App\Http\Controllers\Api\DeviceController;
use App\Http\Controllers\Api\AdminController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::get('/tariffs', [TariffController::class, 'index']);
Route::get('/tariffs/{tariff}', [TariffController::class, 'show']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    Route::post('/orders', [OrderController::class, 'store']);
    Route::get('/orders', [OrderController::class, 'index']);

    Route::get('/subscriptions', [SubscriptionController::class, 'index']);
    Route::post('/subscriptions/{subscription}/cancel', [SubscriptionController::class, 'cancel']);
    Route::get('/subscriptions/{subscription}/license', [SubscriptionController::class, 'license']);

    Route::post('/devices/activate', [DeviceController::class, 'activate']);
    Route::get('/devices/status', [DeviceController::class, 'status']);

    Route::prefix('admin')->middleware('admin')->group(function () {
        Route::get('/statistics', [AdminController::class, 'statistics']);
        Route::get('/users', [AdminController::class, 'users']);
        Route::post('/users/{user}/block', [AdminController::class, 'blockUser']);
        Route::apiResource('/tariffs', AdminController::class)->only(['store', 'update', 'destroy']);
    });
});