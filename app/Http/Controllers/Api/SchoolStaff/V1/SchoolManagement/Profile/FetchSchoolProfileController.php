<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Profile;

use App\Actions\School\GetSchoolByIdAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SchoolStaff\V1\SchoolManagement\Profile\GetSchoolProfileResource;

class FetchSchoolProfileController extends Controller
{
    public function __construct(
        private GetSchoolByIdAction $getSchoolByIdAction
    ) {}

    public function __invoke()
    {
        $loggedInSchoolStaff = auth('school-staff')->user();

        $relationships = [
            'localGovernmentArea',
            'schoolAdmin',
            'metric',
        ];

        $school = $this->getSchoolByIdAction->execute(
            $loggedInSchoolStaff->school_id,
            $relationships
        );

        $responsePayload = new GetSchoolProfileResource($school);

        return generateSuccessApiMessage('School profile was retrieved successfully', 200, $responsePayload);
    }
}
