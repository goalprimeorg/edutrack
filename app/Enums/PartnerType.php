<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum PartnerType: string
{
    use EnumToArray;

    case NGO = 'ngo';
    case Government = 'government';
}
