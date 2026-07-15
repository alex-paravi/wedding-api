<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Http\Resources\TableResource;
use App\Http\Requests\StoreTableRequest;
use App\Http\Requests\UpdateTableRequest;
use App\Models\Guest;

class TableController extends Controller
{
    public function index()
    {
        // Вместо ->get() используем ->paginate(10), указывая по сколько элементов выводить на страницу
        $tables = Table::with('guests')->paginate(10);
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

    public function stats()
    {
        // 1. Считаем сколько всего столов создано
        $totalTables = Table::count();

        // 2. Считаем общую вместимость (суммируем колонку capacity всех столов)
        $totalCapacity = Table::sum('capacity');

        // 3. Считаем, сколько гостей уже привязано к столам (где table_id не null)
        $occupiedSeats = Guest::whereNotNull('table_id')->count();

        // 4. Вычисляем свободные места
        $freeSeats = $totalCapacity - $occupiedSeats;

        // Возвращаем аккуратный JSON-ответ
        return response()->json([
            'total_tables' => $totalTables,
            'total_capacity' => $totalCapacity,
            'occupied_seats' => $occupiedSeats,
            'free_seats' => max(0, $freeSeats), // max(0, ...) защитит от ухода в минус, если гостей посадили больше вместимости
        ]);
    }
}
