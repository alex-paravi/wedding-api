<?php

namespace App\Contracts;

use App\Models\Guest;

interface NotificationSenderInterface
{
    /**
     * Отправить уведомление гостю
     */
    public function send(Guest $guest, string $message): bool;
}
