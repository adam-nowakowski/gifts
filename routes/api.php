<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\RoomController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::apiResource('bookings', BookingController::class)->only([
        'index',
        'store',
        'destroy'
    ]);

    Route::apiResource('rooms', RoomController::class)->only([
        'index',
        'store'
    ]);
});

