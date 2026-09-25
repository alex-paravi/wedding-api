<?php

namespace App\Services;

use App\Contracts\NotificationSenderInterface;
use App\Enums\GuestCategory;
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
            GuestCategory::Friend => new TelegramNotificationSender,
            GuestCategory::Relative => new EmailNotificationSender,
            GuestCategory::Colleague, GuestCategory::Family => new SmsNotificationSender,
            default => throw new InvalidArgumentException("Неизвестный тип уведомления для категории: {$guest->category->value}"),
        };
    }
}
