<?php

namespace App\Contracts;

use App\Models\Guest;

interface NotificationSenderInterface
{
    /**
     * Отправить уведомление гостю
     *
     * @param Guest $guest
     * @param string $message
     * @return bool
     */
    public function send(Guest $guest, string $message): bool;
}
