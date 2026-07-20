<?php

namespace App\Contracts;

use App\Models\Guest;

interface InvitationInterface
{
    /**
     * Сгенерировать финальный контент пригласительного для конкретного гостя.
     * 
     * @param Guest $guest
     * @return mixed
     */
    public function generate(Guest $guest): mixed;
}
