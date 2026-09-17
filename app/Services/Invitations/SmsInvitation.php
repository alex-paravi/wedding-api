<?php

namespace App\Services\Invitations;

use App\Contracts\InvitationInterface;
use App\Models\Guest;

class SmsInvitation implements InvitationInterface
{
    public function generate(Guest $guest): string
    {
        // Заглушка для демонстрации паттерна Factory.
        return "SMS приглашение отправлено гостю {$guest->name}";
    }
}
