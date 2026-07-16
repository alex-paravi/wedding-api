<?php

namespace App\Services;

use App\Contracts\NotificationSenderInterface;
use App\Models\Guest;
use Illuminate\Support\Facades\Log;

class TelegramNotificationSender implements NotificationSenderInterface
{
    public function send(Guest $guest, string $message): bool
    {
        // Имитируем отправку через Telegram API
        Log::info("Telegram-сообщение отправлено гостю {$guest->name}: {$message}");

        return true;
    }
}
