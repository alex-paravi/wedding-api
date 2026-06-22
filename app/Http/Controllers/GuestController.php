<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Guest;

class GuestController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->only(['name', 'is_confirmed']);
        $guest = Guest::create($data);
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
    public function update(Request $request, $id)
    {
        $guest = Guest::find($id);
        if (!$guest) {
            return response()->json(['message' => 'Гость не найден'], 404);
        }
        $data = $request->only(['is_confirmed']);
        $guest->update($data);
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
