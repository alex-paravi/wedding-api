<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuestRequest;
use App\Http\Requests\UpdateGuestRequest;
use Illuminate\Http\Request;
use App\Models\Guest;
use App\Http\Resources\GuestResource;
use Illuminate\Support\Facades\Gate;

class GuestController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()->role === 'admin') {
            $guests = Guest::all();
        } else {
            $guests = Guest::where('user_id', $request->user()->id)->get();
        }

        return GuestResource::collection($guests);
    }

    public function store(StoreGuestRequest $request)
    {
        Gate::authorize('create', Guest::class);

        $validated = $request->validated();

        $validated['user_id'] = $request->user()->id;

        $guest = Guest::create($validated);

        return new GuestResource($guest);
    }
    public function show(Guest $guest)
    {
        Gate::authorize('view', $guest);

        return new GuestResource($guest);
    }
    public function update(UpdateGuestRequest $request, Guest $guest)
    {
        Gate::authorize('update', $guest);

        $guest->update($request->validated());

        return new GuestResource($guest);
    }
    public function destroy(Guest $guest)
    {
        Gate::authorize('delete', $guest);

        $guest->delete();

        return response()->json(null, 204);
    }
}
