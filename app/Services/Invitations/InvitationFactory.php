<?php

namespace App\Services\Invitations;

use App\Contracts\InvitationInterface;
use App\Services\Invitations\WebInvitation;
use App\Services\Invitations\PdfInvitation;
use App\Models\Guest;
use InvalidArgumentException;

class InvitationFactory
{
    /**
     * Создать нужный объект пригласительного на основе категории гостя.
     */
    public function make(Guest $guest): InvitationInterface
    {
        switch ($guest->category) {
            case 'friends':
                return new WebInvitation();

            case 'relatives':
                return new PdfInvitation();

            default:
                throw new InvalidArgumentException("Unknown guest category: {$guest->category}");
        }
    }
}
