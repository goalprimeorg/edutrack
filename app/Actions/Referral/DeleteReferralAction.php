<?php

namespace App\Actions\Referral;

use App\Models\Referral;

class DeleteReferralAction
{
    public function __construct(
        private Referral $referral
    ) {}

    public function execute(array $deleteReferralRecordOptions)
    {
        $id = $deleteReferralRecordOptions['id'];

        return $this->referral->where([
            'id' => $id,
        ])->delete();
    }
}
