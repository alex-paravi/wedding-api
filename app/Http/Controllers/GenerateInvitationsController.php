<?php

namespace App\Http\Controllers;

use App\Http\Resources\GuestResource;
use App\Services\InvitationService;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GenerateInvitationsController extends Controller
{
    public function __invoke(InvitationService $invitationService, Request $request): AnonymousResourceCollection
    {
        $user = $request->user();
        $processedGuests = $invitationService->generateAndSendAll($user);

        return GuestResource::collection($processedGuests);
    }
}
