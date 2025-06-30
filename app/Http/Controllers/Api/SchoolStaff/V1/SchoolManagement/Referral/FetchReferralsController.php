<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Referral;

use App\Actions\Referral\ListReferralsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\Referral\FetchReferralsRequest;
use App\Http\Resources\Api\SchoolStaff\V1\SchoolManagement\Referral\FetchReferralsResource;

class FetchReferralsController extends Controller
{
    public function __construct(
        private ListReferralsAction $listReferralsAction
    ) {}

    public function __invoke(FetchReferralsRequest $request)
    {
        $loggedInSchoolStaff = auth('school-staff')->user();

        $listReferralsRecordOptions = $request->safe()->merge([
            'school_id' => $loggedInSchoolStaff->school_id,
            'created_by_id' => $loggedInSchoolStaff->id,
        ])->all();

        $relationships = [
            'student',
            'referralServiceType',
        ];

        $referrals = $this->listReferralsAction->execute(
            $listReferralsRecordOptions,
            $relationships
        );

        $mutatedReferrals = FetchReferralsResource::collection($referrals);

        $links = generatePaginationLinks($referrals);
        $meta = generatePaginationMeta($referrals);

        $responsePayload = [
            'referrals' => $mutatedReferrals,
            'links' => $links,
            'meta' => $meta,
        ];

        return generateSuccessApiMessage('Referrals was retrieved successfully', 200, $responsePayload);
    }
}
