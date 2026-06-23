<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GuestController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/guests', [GuestController::class, 'store']);
Route::get('/guests', [GuestController::class, 'index']);
Route::get('/guests/{guest}', [GuestController::class, 'show']);
Route::patch('/guests/{guest}', [GuestController::class, 'update']);
Route::delete('/guests/{guest}', [GuestController::class, 'destroy']);
