<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TableController;


Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Добавляем роут статистики ВЫШЕ apiResource столов
    Route::get('/tables/stats', [TableController::class, 'stats']);
    Route::apiResource('tables', TableController::class);

    //  Добавляем роут статистики ВЫШЕ роута со сlug/id {guest}
    Route::get('/guests/stats', [GuestController::class, 'stats']);
    Route::post('/guests', [GuestController::class, 'store']);
    Route::get('/guests', [GuestController::class, 'index']);
    Route::get('/guests/{guest}', [GuestController::class, 'show']);
    Route::patch('/guests/{guest}', [GuestController::class, 'update']);
    Route::delete('/guests/{guest}', [GuestController::class, 'destroy']);
});
