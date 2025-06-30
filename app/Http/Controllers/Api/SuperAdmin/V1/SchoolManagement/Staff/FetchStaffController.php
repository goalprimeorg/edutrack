<?php

namespace App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Staff;

use App\Actions\SchoolStaff\ListSchoolStaffAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SuperAdmin\V1\SchoolManagement\Staff\FetchStaffRequest;
use App\Http\Resources\Api\SuperAdmin\V1\SchoolManagement\Staff\FetchStaffResource;

class FetchStaffController extends Controller
{
    public function __construct(
        public ListSchoolStaffAction $listSchoolStaffAction
    ) {}

    public function __invoke(FetchStaffRequest $request)
    {
        $listSchoolStaffsRecordOptions = $request->validated();

        $relationships = [
            'school',
        ];

        $schoolStaff = $this->listSchoolStaffAction->execute(
            $listSchoolStaffsRecordOptions,
            $relationships
        );

        $mutatedSchoolStaff = FetchStaffResource::collection($schoolStaff);

        $links = generatePaginationLinks($schoolStaff);
        $meta = generatePaginationMeta($schoolStaff);

        $responsePayload = [
            'staff' => $mutatedSchoolStaff,
            'meta' => $meta,
            'links' => $links,
        ];

        return generateSuccessApiMessage('Staff record was retrieved successfully', 200, $responsePayload);
    }
}
