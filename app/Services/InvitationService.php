<?php

namespace App\Services;

use App\Models\Guest;
use App\Services\Invitations\InvitationFactory;
use App\Services\NotificationFactory;
use Illuminate\Support\Collection;
use App\Models\User;

class InvitationService
{
    public function __construct(
        protected InvitationFactory $invitationFactory,
        protected NotificationFactory $notificationFactory
    ) {}

    /**
     * Сгенерировать приглашения и отправить уведомления всем гостям.
     */
    public function generateAndSendAll(User $user): Collection
    {
        $guests = Guest::visibleTo($user)->get();

        return $guests->map(function (Guest $guest) {
            $invitationWorker = $this->invitationFactory->make($guest);
            $invitationLink = $invitationWorker->generate($guest);

            $notificationSender = $this->notificationFactory->make($guest);
            $message = "Здравствуйте, {$guest->name}! Ваше приглашение: {$invitationLink}";
            $isSent = $notificationSender->send($guest, $message);

            // Прикрепляем результат к модели для отдачи в ресурс
            $guest->generated_link = $invitationLink;
            $guest->is_notified = $isSent;

            return $guest;
        });
    }
}
