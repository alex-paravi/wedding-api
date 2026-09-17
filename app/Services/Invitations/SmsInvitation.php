<?php

namespace App\Services\Invitations;

use App\Contracts\InvitationInterface;
use App\Models\Guest;

class SmsInvitation implements InvitationInterface
{
    public function generate(Guest $guest): string
    {
        // Заглушка для демонстрации паттерна Factory.
        // В отличие от WebInvitation/PdfInvitation, не генерирует и не сохраняет invitation_token —
        // RSVP-flow для категорий colleague/family не предполагался в рамках этого pet-проекта.
        return "SMS приглашение отправлено гостю {$guest->name}";
    }
}
