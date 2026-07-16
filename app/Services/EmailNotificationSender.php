<?php

namespace App\Services;

use App\Contracts\NotificationSenderInterface;
use App\Models\Guest;
use Illuminate\Support\Facades\Log;

class EmailNotificationSender implements NotificationSenderInterface
{
    public function send(Guest $guest, string $message): bool
    {
        // В реальном проекте тут был бы Mail::to($guest->email)...
        // Сейчас мы просто сымитируем отправку в логи Laravel
        Log::info("Email отправлен гостю {$guest->name}: {$message}");

        return true;
    }
}
