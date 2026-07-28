<?php

namespace App\Http\Controllers;

use App\Services\GuestStatsService;
use Illuminate\Http\JsonResponse;

class GuestStatsController extends Controller
{
    /**
     * Получить общую статистику по гостям и кейтерингу.
     */
    public function __invoke(GuestStatsService $statsService): JsonResponse
    {
        $stats = $statsService->getSummaryStats();

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }
}
