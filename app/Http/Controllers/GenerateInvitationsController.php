<?php

namespace App\Http\Controllers;

use App\Services\InvitationService;
use App\Http\Resources\GuestResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Request;

class GenerateInvitationsController extends Controller
{
    public function __invoke(InvitationService $invitationService, Request $request): AnonymousResourceCollection
    {
        $user = $request->user();
        $processedGuests = $invitationService->generateAndSendAll($user);

        return GuestResource::collection($processedGuests);
    }
}
