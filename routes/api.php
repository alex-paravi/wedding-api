<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TableController;
use App\Http\Controllers\RsvpController;
use App\Http\Controllers\GuestStatsController;
use App\Http\Controllers\GenerateInvitationsController;
use App\Http\Controllers\TableStatsController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/invitations/{token}/rsvp', RsvpController::class);

Route::middleware('auth:sanctum')->group(function () {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Столы
    Route::get('/tables/stats', TableStatsController::class);
    Route::apiResource('tables', TableController::class);

    // Гости (Спец-роуты строго ВЫШЕ apiResource!)
    Route::get('/guests/stats', GuestStatsController::class);
    Route::get('/guests/generate-invitations', GenerateInvitationsController::class);

    // Чистый CRUD
    Route::apiResource('guests', GuestController::class);
});
