<?php

namespace App\Http\Controllers;

use App\Models\Table;
use App\Http\Resources\TableResource;
use App\Http\Requests\StoreTableRequest;
use App\Http\Requests\UpdateTableRequest;
use App\Models\Guest;
use App\Services\TableService;

class TableController extends Controller
{
    public function __construct(
        protected TableService $tableService
    ) {}

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
        // Контроллер больше ничего сам не считает! 
        // Он просто просит сервис сделать расчеты
        $stats = $this->tableService->getTableStatistics();

        // И возвращает результат клиенту
        return response()->json($stats);
    }
}
