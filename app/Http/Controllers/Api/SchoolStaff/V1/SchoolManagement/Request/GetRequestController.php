<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Request;

use App\Actions\Request\GetRequestByIdAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SchoolStaff\V1\SchoolManagement\Request\GetRequestResource;

class GetRequestController extends Controller
{
    public function __construct(
        private GetRequestByIdAction $getRequestByIdAction
    ) {}

    public function __invoke(string $requestId)
    {
        $loggedInSchoolStaff = auth('school-staff')->user();

        $relationships = [
            'item',
        ];

        $request = $this->getRequestByIdAction->execute(
            $requestId,
            $relationships
        );

        if (is_null($request) || $request->school_id !== $loggedInSchoolStaff->school_id) {
            return generateErrorApiMessage('Request record does not exists', 404);
        }

        $mutatedRequest = new GetRequestResource($request);

        return generateSuccessApiMessage('Request was retrieved successfully', 200, $mutatedRequest);
    }
}
