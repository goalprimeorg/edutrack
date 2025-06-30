<?php

namespace App\Http\Controllers\Api\Common\V1\Qualification;

use App\Actions\QualificationType\ListQualificationTypesAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Common\V1\Qualification\FetchQualificationTypesResource;

class FetchQualificationTypesController extends Controller
{
    public function __construct(
        private ListQualificationTypesAction $listQualificationTypesAction
    ) {}

    public function __invoke()
    {
        $qualificationTypes = $this->listQualificationTypesAction->execute();

        $responsePayload = FetchQualificationTypesResource::collection($qualificationTypes);

        return generateSuccessApiMessage('Fetched Qualification types successfully', 200, $responsePayload);
    }
}
