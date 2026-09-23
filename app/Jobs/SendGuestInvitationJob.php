<?php

namespace App\Jobs;

use App\Models\Guest;
use App\Services\InvitationService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\User;

class SendGuestInvitationJob implements ShouldQueue
{
    use Queueable;
    public Guest $guest;


    public function __construct(Guest $guest)
    {
        $this->guest = $guest;
    }

    /**
     * Execute the job.
     */
    public function handle(InvitationService $invitationService): void
    {
        $invitationService->sendInvitationTo($this->guest);
    }
}
