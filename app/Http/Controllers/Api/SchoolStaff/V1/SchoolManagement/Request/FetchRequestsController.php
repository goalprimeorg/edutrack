<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Request;

use App\Actions\Request\ListRequestsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\Request\FetchRequestsRequest;
use App\Http\Resources\Api\SchoolStaff\V1\SchoolManagement\Request\FetchRequestsResource;

class FetchRequestsController extends Controller
{
    public function __construct(
        private ListRequestsAction $listRequestsAction
    ) {}

    public function __invoke(FetchRequestsRequest $request)
    {
        $loggedInSchoolStaff = auth('school-staff')->user();

        $listRequestsRecordOptions = $request->safe()->merge([
            'school_id' => $loggedInSchoolStaff->school_id,
        ])->all();

        $relationships = [
            'item',
        ];

        $requests = $this->listRequestsAction->execute(
            $listRequestsRecordOptions,
            $relationships
        );

        $mutatedRequests = FetchRequestsResource::collection($requests);

        $links = generatePaginationLinks($requests);
        $meta = generatePaginationMeta($requests);

        $responsePayload = [
            'requests' => $mutatedRequests,
            'links' => $links,
            'meta' => $meta,
        ];

        return generateSuccessApiMessage('Requests was retrieved successfully', 200, $responsePayload);
    }
}
