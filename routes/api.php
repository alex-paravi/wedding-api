<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/guests', [GuestController::class, 'store']);
Route::get('/guests', [GuestController::class, 'index']);
Route::get('/guests/{id}', [GuestController::class, 'show']);
Route::patch('/guests/{id}', [GuestController::class, 'update']);
