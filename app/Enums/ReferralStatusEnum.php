<?php

namespace App\Enums;

use App\Traits\EnumToArray;

enum ReferralStatusEnum: string
{
    use EnumToArray;

    case Pending = 'pending';

    case Approved = 'approved';

    case Rejected = 'rejected';

}
