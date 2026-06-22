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
}
