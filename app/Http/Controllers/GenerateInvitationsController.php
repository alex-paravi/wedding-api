<?php

namespace App\Http\Controllers;

use App\Services\InvitationService;
use App\Http\Resources\GuestResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class GenerateInvitationsController extends Controller
{
    public function __invoke(InvitationService $invitationService): AnonymousResourceCollection
    {
        $processedGuests = $invitationService->generateAndSendAll();

        return GuestResource::collection($processedGuests);
    }
}
