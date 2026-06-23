<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuestRequest;
use App\Http\Requests\UpdateGuestRequest;
use Illuminate\Http\Request;
use App\Models\Guest;

class GuestController extends Controller
{
    public function store(StoreGuestRequest $request)
    {
        $validated = $request->validated();
        $guest = Guest::create($validated);
        return response()->json($guest, 201);
    }
    public function index()
    {
        $guests = Guest::all();
        return response()->json($guests, 200);
    }
    public function show($id)
    {
        $guest = Guest::find($id);
        if (!$guest) {
            return response()->json(['message' => 'Гость не найден'], 404);
        }
        return response()->json($guest, 200);
    }
    public function update(UpdateGuestRequest $request, Guest $guest)
    {
        $guest->update($request->validated());
        return response()->json($guest, 200);
    }
    public function destroy($id)
    {
        $guest = Guest::find($id);
        if (!$guest) {
            return response()->json(['message' => 'Гость не найден'], 404);
        }
        $guest->delete();
        return response()->json(null, 204);
    }
}
