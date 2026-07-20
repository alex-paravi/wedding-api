<?php

namespace App\Services\Invitations;

use App\Contracts\InvitationInterface;
use App\Models\Guest;

class WebInvitation implements InvitationInterface
{
    /**
     * Сгенерировать уникальную ссылку на онлайн-пригласительное.
     */
    public function generate(Guest $guest): string
    {
        // Базовый URL нашего фронтенда для гостей
        $baseUrl = config('app.url') . '/invitation/';

        // Генерируем уникальный хэш на основе ID гостя, чтобы ссылку нельзя было подобрать
        $hash = md5($guest->id . 'wedding_secret_salt');

        // Возвращаем красивую ссылку, по которой гость перейдет на красивую веб-страницу
        return $baseUrl . $hash;
    }
}
