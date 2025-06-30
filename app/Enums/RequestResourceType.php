<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum RequestResourceType: string
{
    use EnumToArray;

    case LearningMaterial = 'Learning Material';
    case TeachingMaterial = 'Teaching Material';
}
