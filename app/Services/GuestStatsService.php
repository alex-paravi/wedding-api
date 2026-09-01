<?php

namespace App\Services;

use App\Models\Guest;
use Illuminate\Support\Collection;
use App\Models\User;

class GuestStatsService
{
    /**
     * Получить общую сводную статистику по гостям и еде.
     */
    public function getSummaryStats(User $user): array
    {
        $totalGuests = Guest::visibleTo($user)->count();
        $confirmedGuests = Guest::visibleTo($user)->where('status', 'confirmed')->count();
        $declinedGuests = Guest::visibleTo($user)->where('status', 'declined')->count();
        $pendingGuests = Guest::visibleTo($user)->where('status', 'pending')->count();

        // Собираем гостей, которые подтвердили участие и указали пожелания по еде
        $dietaryPreferences = Guest::visibleTo($user)
            ->where('status', 'confirmed')
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
