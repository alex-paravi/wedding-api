<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuestRequest;
use App\Http\Requests\UpdateGuestRequest;
use Illuminate\Http\Request;
use App\Models\Guest;
use App\Http\Resources\GuestResource;

class GuestController extends Controller
{
    public function store(StoreGuestRequest $request)
    {
        $validated = $request->validated();
        $guest = Guest::create($validated);
        return new GuestResource($guest);
    }
    public function index()
    {
        $guests = Guest::all();
        return GuestResource::collection($guests);
    }
    public function show(Guest $guest)
    {
        return new GuestResource($guest);
    }
    public function update(UpdateGuestRequest $request, Guest $guest)
    {
        $guest->update($request->validated());
        return new GuestResource($guest);
    }
    public function destroy(Guest $guest)
    {
        $guest->delete();
        return response()->json(null, 204);
    }
}
