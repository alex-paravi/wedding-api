<?php

namespace App\Http\Controllers;

use App\Services\TableStatsService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class TableStatsController extends Controller
{
    public function __invoke(TableStatsService $statsService, Request $request): JsonResponse
    {
        $user = $request->user();
        $stats = $statsService->getTableStatistics($user);

        return response()->json([
            'success' => true,
            'data' => $stats,
        ]);
    }
}
