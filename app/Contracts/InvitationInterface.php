<?php

namespace App\Contracts;

use App\Models\Guest;

interface InvitationInterface
{
    /**
     * Сгенерировать финальный контент пригласительного для конкретного гостя.
     */
    public function generate(Guest $guest): mixed;
}
