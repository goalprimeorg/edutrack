<?php

namespace App\Actions\Referral;

use App\Models\Referral;

class UpdateReferralAction
{
    public function __construct(
        private Referral $referral
    ) {}

    public function execute(array $updateReferralRecordOptions)
    {
        $id = $updateReferralRecordOptions['id'];
        $data = $updateReferralRecordOptions['data'];

        return $this->referral->where([
            'id' => $id,
        ])->update($data);
    }
}
