<?php

namespace App\Services;

use App\Models\Table;
use App\Models\Guest;

class TableService
{
    /**
     * Рассчитать сводную статистику по столам и местам
     *
     * @return array
     */
    public function getTableStatistics(): array
    {
        $totalTables = Table::count();
        $totalCapacity = Table::sum('capacity');
        $occupiedSeats = Guest::whereNotNull('table_id')->count();
        $freeSeats = $totalCapacity - $occupiedSeats;

        return [
            'total_tables' => $totalTables,
            'total_capacity' => $totalCapacity,
            'occupied_seats' => $occupiedSeats,
            'free_seats' => max(0, $freeSeats),
        ];
    }
}
