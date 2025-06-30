<?php

namespace App\Http\Controllers\Api\Common\V1\ReferralServiceType;

use App\Actions\ReferralServiceType\ListReferralServiceTypesAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Common\V1\ReferralServiceType\FetchReferralServiceTypesResource;

class FetchReferralServiceTypesController extends Controller
{
    public function __construct(
        private ListReferralServiceTypesAction $listReferralServiceTypesAction
    ) {}

    public function __invoke()
    {
        $ReferralServiceTypes = $this->listReferralServiceTypesAction->execute();

        $responsePayload = FetchReferralServiceTypesResource::collection($ReferralServiceTypes);

        return generateSuccessApiMessage('Fetched referral service types types successfully', 200, $responsePayload);
    }
}
