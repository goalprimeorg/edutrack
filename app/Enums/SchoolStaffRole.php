<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum SchoolStaffRole: string
{
    use EnumToArray;

    case Admin = 'admin';
    case Teacher = 'teacher';
}
