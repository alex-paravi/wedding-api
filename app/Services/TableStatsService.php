<?php

namespace App\Services;

use App\Models\Table;
use App\Models\Guest;
use App\Models\User;

class TableStatsService
{

    /**
     * Рассчитать сводную статистику по столам и местам
     */
    public function getTableStatistics(User $user): array
    {
        $totalTables = Table::visibleTo($user)->count();
        $totalCapacity = Table::visibleTo($user)->sum('capacity');
        $occupiedSeats = Guest::visibleTo($user)->whereNotNull('table_id')->count();
        $freeSeats = $totalCapacity - $occupiedSeats;

        return [
            'total_tables' => $totalTables,
            'total_capacity' => $totalCapacity,
            'occupied_seats' => $occupiedSeats,
            'free_seats' => max(0, $freeSeats),
        ];
    }
}
