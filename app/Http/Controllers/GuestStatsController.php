<?php

namespace App\Http\Controllers;

use App\Services\GuestStatsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GuestStatsController extends Controller
{
    /**
     * Получить общую статистику по гостям и кейтерингу.
     */
    public function __invoke(GuestStatsService $statsService, Request $request): JsonResponse
    {
        $user = $request->user();
        $stats = $statsService->getSummaryStats($user);

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }
}
