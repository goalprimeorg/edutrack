<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum EmisStatus: string
{
    use EnumToArray;

    case Active = 'active';
    case Suspend = 'suspended';
}
