<?php

namespace App\Services;

use App\Contracts\NotificationSenderInterface;
use App\Models\Guest;
use InvalidArgumentException;

class NotificationFactory
{
    /**
     * Создать подходящий сервис отправки уведомлений на основе категории гостя
     */
    public function make(Guest $guest): NotificationSenderInterface
    {
        return match ($guest->category) {
            'friend'   => new TelegramNotificationSender(),
            'relative' => new EmailNotificationSender(),
            default    => throw new InvalidArgumentException("Неизвестный тип уведомления для категории: {$guest->category}"),
        };
    }
}
