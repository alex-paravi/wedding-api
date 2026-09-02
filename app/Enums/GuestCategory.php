<?php

namespace App\Enums;

enum GuestCategory: string
{
    case Friend = 'friend';
    case Relative = 'relative';
    case Colleague = 'colleague';
    case Family = 'family';
}
