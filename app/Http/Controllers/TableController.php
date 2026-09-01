<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Http\Resources\TableResource;
use App\Http\Requests\StoreTableRequest;
use App\Http\Requests\UpdateTableRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class TableController extends Controller
{

    public function index(Request $request)
    {
        Gate::authorize('viewAny', Table::class);
        $query = Table::with(['guests', 'user'])->visibleTo($request->user());
        $tables = $query->paginate(10);
        return TableResource::collection($tables);
    }

    /**
     * Используем StoreTableRequest вместо обычного Request
     */
    public function store(StoreTableRequest $request)
    {
        Gate::authorize('create', Table::class);
        $validated = $request->validated();
        $validated['user_id'] = $request->user()->id;
        $table = Table::create($validated);
        return new TableResource($table);
    }

    public function show(Table $table)
    {
        Gate::authorize('view', $table);
        $table->load('guests');
        return new TableResource($table);
    }

    /**
     * Используем UpdateTableRequest вместо обычного Request
     */
    public function update(UpdateTableRequest $request, Table $table)
    {
        Gate::authorize('update', $table);
        $table->update($request->validated());

        return new TableResource($table);
    }

    public function destroy(Table $table)
    {
        Gate::authorize('delete', $table);
        $table->delete();
        return response()->json(null, 204);
    }
}
