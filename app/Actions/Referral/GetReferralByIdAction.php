<?php

namespace App\Actions\Referral;

use App\Models\Referral;

class GetReferralByIdAction
{
    public function __construct(
        private Referral $referral
    ) {}

    public function execute($referralId, array $relationships = [])
    {
        return $this->referral->with($relationships)->where([
            'id' => $referralId,
        ])->first();
    }
}
