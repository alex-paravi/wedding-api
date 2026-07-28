<?php

namespace App\Services;

use App\Models\Guest;
use Illuminate\Support\Collection;

class GuestStatsService
{
    /**
     * Получить общую сводную статистику по гостям и еде.
     */
    public function getSummaryStats(): array
    {
        $totalGuests = Guest::count();
        $confirmedGuests = Guest::where('status', 'confirmed')->count();
        $declinedGuests = Guest::where('status', 'declined')->count();
        $pendingGuests = Guest::where('status', 'pending')->count();

        // Собираем гостей, которые подтвердили участие и указали пожелания по еде
        $dietaryPreferences = Guest::where('status', 'confirmed')
            ->whereNotNull('dietary_preferences')
            ->pluck('dietary_preferences', 'name');

        return [
            'overview' => [
                'total' => $totalGuests,
                'confirmed' => $confirmedGuests,
                'declined' => $declinedGuests,
                'pending' => $pendingGuests,
            ],
            'catering' => [
                'confirmed_count' => $confirmedGuests,
                'preferences' => $dietaryPreferences,
            ],
        ];
    }
}
