<?php

namespace App\Services\Invitations;

use App\Contracts\InvitationInterface;
use App\Enums\GuestCategory;
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
            case GuestCategory::Friend:
                return new WebInvitation;

            case GuestCategory::Relative:
                return new PdfInvitation;

            case GuestCategory::Colleague:
            case GuestCategory::Family:
                return new SmsInvitation;

            default:
                throw new InvalidArgumentException("Unknown guest category: {$guest->category->value}");
        }
    }
}
