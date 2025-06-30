<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum RequestPriorityStatus: string
{
    use EnumToArray;
    case High = 'high';

    case Medium = 'medium';
    case Low = 'low';
}
