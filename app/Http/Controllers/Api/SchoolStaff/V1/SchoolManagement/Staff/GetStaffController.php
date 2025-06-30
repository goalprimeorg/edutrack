<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Staff;

use App\Actions\SchoolStaff\GetSchoolStaffByIdAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SchoolStaff\V1\SchoolManagement\Staff\GetStaffResource;

class GetStaffController extends Controller
{
    public function __construct(
        private GetSchoolStaffByIdAction $getSchoolStaffByIdAction,
    ) {}

    public function __invoke(string $staffId)
    {
        $relationships = [
            'school',
            'currentClassroom',
        ];

        $loggedInStaff = auth('school-staff')->user();

        $schoolStaff = $this->getSchoolStaffByIdAction->execute($staffId);

        if (is_null($schoolStaff) || $loggedInStaff->school_id !== $schoolStaff->school_id) {
            return generateErrorApiMessage('Staff record does not exist', 404);
        }

        $mutatedStaff = new GetStaffResource($schoolStaff);

        return generateSuccessApiMessage('Staff was retrieved successfully', 200, $mutatedStaff);
    }
}
