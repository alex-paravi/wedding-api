<?php

namespace App\Services\Invitations;

use App\Contracts\InvitationInterface;
use App\Models\Guest;

class PdfInvitation implements InvitationInterface
{
    /**
     * Сгенерировать PDF-файл пригласительного и вернуть путь к нему.
     */
    public function generate(Guest $guest): string
    {
        // Заглушка для демонстрации паттерна Factory.

        // Имитируем генерацию файла на сервере
        $fileName = 'invitation_'.$guest->id.'.pdf';
        $storagePath = 'storage/app/public/invitations/'.$fileName;

        // Сервер выполняет инструкцию «сохранить файл на диск»
        // file_put_contents($storagePath, 'Контент PDF для ' . $guest->name);

        // Возвращаем путь к готовому файлу, чтобы его можно было прикрепить к письму
        return $storagePath;
    }
}
