<?php

namespace App\Actions\Referral;

use App\Models\Referral;

class CreateReferralAction
{
    public function __construct(
        private Referral $referral
    ) {}

    public function execute(array $createReferral)
    {
        return $this->referral->create($createReferral);
    }
}
