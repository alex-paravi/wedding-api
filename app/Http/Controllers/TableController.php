<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Http\Resources\TableResource;
use App\Http\Requests\StoreTableRequest;
use App\Http\Requests\UpdateTableRequest;

class TableController extends Controller
{
    public function index()
    {
        $tables = Table::with('guests')->get();
        return TableResource::collection($tables);
    }

    /**
     * Используем StoreTableRequest вместо обычного Request
     */
    public function store(StoreTableRequest $request)
    {
        // $request->validated() вернет только те данные, которые прошли проверку
        $table = Table::create($request->validated());

        return new TableResource($table);
    }

    public function show(Table $table)
    {
        $table->load('guests');
        return new TableResource($table);
    }

    /**
     * Используем UpdateTableRequest вместо обычного Request
     */
    public function update(UpdateTableRequest $request, Table $table)
    {
        $table->update($request->validated());

        return new TableResource($table);
    }

    public function destroy(Table $table)
    {
        $table->delete();
        return response()->json(null, 204);
    }
}
