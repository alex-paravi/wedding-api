<?php

namespace App\Services\Invitations;

use App\Contracts\InvitationInterface;
use App\Models\Guest;
use Illuminate\Support\Str;

class WebInvitation implements InvitationInterface
{
    /**
     * Сгенерировать уникальную ссылку на онлайн-пригласительное.
     */
    public function generate(Guest $guest): string
    {
        // 1. Генерируем уникальный токен (или берем существующий)
        if (!$guest->invitation_token) {
            $token = Str::random(32);
            $guest->update(['invitation_token' => $token]);
        } else {
            $token = $guest->invitation_token;
        }

        // 2. Базовый URL нашего фронтенда для гостей
        $baseUrl = config('app.url') . '/invitation/';

        // 3. Возвращаем ссылку именно с $token!
        return $baseUrl . $token;
    }
}
