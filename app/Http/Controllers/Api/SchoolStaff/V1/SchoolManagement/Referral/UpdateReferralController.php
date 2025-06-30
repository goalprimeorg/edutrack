<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Referral;

use App\Actions\Referral\GetReferralByIdAction;
use App\Actions\Referral\UpdateReferralAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\Referral\UpdateReferralRequest;

class UpdateReferralController extends Controller
{
    public function __construct(
        private GetReferralByIdAction $getReferralByIdAction,
        private UpdateReferralAction $updateReferralAction,
    ) {}

    public function __invoke(UpdateReferralRequest $request, string $referralId)
    {
        $loggedInSchoolStaff = auth('school-staff')->user();

        $referral = $this->getReferralByIdAction->execute(
            $referralId,
        );

        if (is_null($referral) || $referral->school_id !== $loggedInSchoolStaff->school_id) {
            return generateErrorApiMessage('Referral record does not exists', 404);
        }

        $updateReferralRecordOptions = [
            'id' => $referralId,
            'data' => $request->validated(),
        ];

        $this->updateReferralAction->execute(
            $updateReferralRecordOptions
        );

        return generateSuccessApiMessage('Referral was updated successfully', 200);
    }
}
