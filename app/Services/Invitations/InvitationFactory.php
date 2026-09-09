<?php

namespace App\Services\Invitations;

use App\Contracts\InvitationInterface;
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
            case 'friend':
                return new WebInvitation;

            case 'relative':
                return new PdfInvitation;

            case 'colleague':
            case 'family':
                return new SmsInvitation;

            default:
                throw new InvalidArgumentException("Unknown guest category: {$guest->category}");
        }
    }
}
