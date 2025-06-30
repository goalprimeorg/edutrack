<?php

namespace App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Profile;

use App\Actions\School\ListSchoolsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SuperAdmin\V1\SchoolManagement\Profile\FetchSchoolsRequest;
use App\Http\Resources\Api\SuperAdmin\V1\SchoolManagement\Profile\FetchSchoolsResource;

class FetchSchoolsController extends Controller
{
    public function __construct(
        private ListSchoolsAction $listSchoolsAction
    ) {}

    public function __invoke(FetchSchoolsRequest $request)
    {
        $listSchoolsRecordOptions = $request->validated();

        $relationships = [
            'localGovernmentArea',
            'schoolAdmin',
        ];

        $schools = $this->listSchoolsAction->execute(
            $listSchoolsRecordOptions,
            $relationships
        );

        $mutatedSchoolList = FetchSchoolsResource::collection($schools);

        $paginationMeta = generatePaginationMeta($schools);
        $paginationLinks = generatePaginationLinks($schools);

        $responsePayload = [
            'schools' => $mutatedSchoolList,
            'pagination_meta' => $paginationMeta,
            'pagination_links' => $paginationLinks,
        ];

        return generateSuccessApiMessage('School list was retrieved successfully', 200, $responsePayload);
    }
}
