<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Referral;

use App\Actions\Referral\CreateReferralAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\Referral\CreateReferralRequest;

class CreateReferralController extends Controller
{
    public function __construct(
        private CreateReferralAction $createReferralAction
    ) {}

    public function __invoke(CreateReferralRequest $request)
    {
        $loggedInSchoolStaff = auth('school-staff')->user();

        $createReferralsRecordOptions = $request->safe()->merge([
            'school_id' => $loggedInSchoolStaff->school_id,
            'created_by_id' => $loggedInSchoolStaff->id,
            'status' => 'pending',
        ])->all();

        $this->createReferralAction->execute(
            $createReferralsRecordOptions
        );

        return generateSuccessApiMessage('Referral was created successfully', 201);
    }
}
