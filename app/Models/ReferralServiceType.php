<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;

class ReferralServiceType extends AbstractModel
{
    public function referral(): HasMany
    {
        return $this->hasMany(Referral::class);
    }
}
