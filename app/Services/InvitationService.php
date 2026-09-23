<?php

namespace App\Services;

use App\Models\Guest;
use App\Models\User;
use App\Services\Invitations\InvitationFactory;
use App\Jobs\SendGuestInvitationJob;

class InvitationService
{
    public function __construct(
        protected InvitationFactory $invitationFactory,
        protected NotificationFactory $notificationFactory
    ) {}



    public function sendInvitationTo(Guest $guest): void
    {
        $invitationWorker = $this->invitationFactory->make($guest);
        $invitationLink = $invitationWorker->generate($guest);

        $notificationSender = $this->notificationFactory->make($guest);
        $message = "Здравствуйте, {$guest->name}! Ваше приглашение: {$invitationLink}";
        $isSent = $notificationSender->send($guest, $message);

        // теперь реально сохраняем, а не просто присваиваем в памяти
        $guest->update([
            'is_notified' => $isSent,
        ]);
    }
    public function generateAndSendAll(User $user): void
    {
        $guests = Guest::visibleTo($user)->get();

        $guests->each(function (Guest $guest) {
            SendGuestInvitationJob::dispatch($guest);
        });
    }
}
