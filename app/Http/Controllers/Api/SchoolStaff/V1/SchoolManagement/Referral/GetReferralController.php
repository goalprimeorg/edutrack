<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Referral;

use App\Actions\Referral\GetReferralByIdAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SchoolStaff\V1\SchoolManagement\Referral\GetReferralResource;

class GetReferralController extends Controller
{
    public function __construct(
        private GetReferralByIdAction $getReferralByIdAction
    ) {}

    public function __invoke(string $referralId)
    {
        $loggedInSchoolStaff = auth('school-staff')->user();

        $relationships = [];

        $referral = $this->getReferralByIdAction->execute(
            $referralId,
            $relationships
        );

        if (is_null($referral) || $referral->school_id !== $loggedInSchoolStaff->school_id) {
            return generateErrorApiMessage('Referral record does not exists', 404);
        }

        $mutatedReferral = new GetReferralResource($referral);

        return generateSuccessApiMessage('Referral was retrieved successfully', 200, $mutatedReferral);
    }
}
