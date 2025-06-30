<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\ProfileManagement;

use App\Actions\SchoolStaff\GetSchoolStaffByIdAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SchoolStaff\V1\ProfileManagement\GetStaffResource;

class FetchProfileController extends Controller
{
    public function __construct(
        private GetSchoolStaffByIdAction $getSchoolStaffByIdAction
    ) {}

    public function __invoke()
    {
        $loggedInStaff = auth('school-staff')->user();

        $relationships = [
            'highestQualification',
            'currentClassroom',
        ];

        $schoolStaff = $this->getSchoolStaffByIdAction->execute(
            $loggedInStaff->id,
            $relationships
        );

        $mutatedSchoolStaff = new GetStaffResource($schoolStaff);

        return generateSuccessApiMessage('Fetched school staff record successfully', 200, $mutatedSchoolStaff);
    }
}
