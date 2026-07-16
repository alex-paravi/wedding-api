<?php

namespace App\Services;

use App\Models\Table;
use App\Models\Guest;
use App\Contracts\NotificationSenderInterface;

class TableService
{
    public function __construct(
        protected NotificationSenderInterface $notifier
    ) {}

    /**
     * Рассчитать сводную статистику по столам и местам
     */
    public function getTableStatistics(): array
    {
        $totalTables = Table::count();
        $totalCapacity = Table::sum('capacity');
        $occupiedSeats = Guest::whereNotNull('table_id')->count();
        $freeSeats = $totalCapacity - $occupiedSeats;

        // Отправку уведомлений мы оставим, но только для реального гостя, если он есть
        $someGuest = Guest::first();
        if ($someGuest) {
            $this->notifier->send($someGuest, "Привет! Статистика столов успешно обновлена.");
        }

        return [
            'total_tables' => $totalTables,
            'total_capacity' => $totalCapacity,
            'occupied_seats' => $occupiedSeats,
            'free_seats' => max(0, $freeSeats),
        ];
    }
}
