<?php

namespace App\Actions\ReferralServiceType;

use App\Models\ReferralServiceType;

class ListReferralServiceTypesAction
{
    public function __construct(
        private ReferralServiceType $referralServiceType
    ) {}

    public function execute(array $relationships = [])
    {
        return $this->referralServiceType->with($relationships)->orderBy('name', 'ASC')->get();
    }
}
