<?php

namespace App\Services;

use App\Models\Table;
use App\Models\Guest;
use App\Contracts\NotificationSenderInterface; // Импортируем наш интерфейс!

class TableService
{
    // Внедряем интерфейс, а не конкретный Email или Telegram класс!
    public function __construct(
        protected NotificationSenderInterface $notifier
    ) {}

    public function getTableStatistics(): array
    {
        $totalTables = Table::count();
        $totalCapacity = Table::sum('capacity');
        $occupiedSeats = Guest::whereNotNull('table_id')->count();
        $freeSeats = $totalCapacity - $occupiedSeats;

        // Давай для теста отправим фейковое уведомление первому попавшемуся гостю
        $someGuest = Guest::first();
        if ($someGuest) {
            // Наш сервис просто вызывает метод send(), он понятия не имеет, как именно уйдет сообщение!
            $this->notifier->send($someGuest, "Привет! Твоя статистика столов обновилась.");
            $notificationResult = "Вызвана отправка для гостя: " . $someGuest->name;
        }

        return [
            'total_tables' => $totalTables,
            'total_capacity' => $totalCapacity,
            'occupied_seats' => $occupiedSeats,
            'free_seats' => max(0, $freeSeats),
            'debug_notification' => $notificationResult,
        ];
    }
}
