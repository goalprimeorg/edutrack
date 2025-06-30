<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Referral;

use App\Actions\Referral\DeleteReferralAction;
use App\Actions\Referral\GetReferralByIdAction;
use App\Http\Controllers\Controller;

class DeleteReferralController extends Controller
{
    public function __construct(
        private GetReferralByIdAction $getReferralByIdAction,
        private DeleteReferralAction $deleteReferralAction
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

        $deleteReferralRecordOptions['id'] = $referralId;

        $this->deleteReferralAction->execute(
            $deleteReferralRecordOptions
        );

        return generateSuccessApiMessage('Referral was deleted successfully', 200);
    }
}
