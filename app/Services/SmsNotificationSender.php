<?php

namespace App\Services;

use App\Contracts\NotificationSenderInterface;
use App\Models\Guest;
use Illuminate\Support\Facades\Log;

class SmsNotificationSender implements NotificationSenderInterface
{
    public function send(Guest $guest, string $message): bool
    {

        Log::info("SMS отправлен гостю {$guest->name}: {$message}");

        return true;
    }
}
