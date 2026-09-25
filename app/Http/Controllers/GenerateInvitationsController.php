<?php

namespace App\Http\Controllers;

use App\Services\InvitationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GenerateInvitationsController extends Controller
{
    public function __invoke(InvitationService $invitationService, Request $request): JsonResponse
    {
        $user = $request->user();
        $invitationService->generateAndSendAll($user);

        return response()->json([
            'message' => 'Рассылка приглашений поставлена в очередь.',
        ], 202);
    }
}
