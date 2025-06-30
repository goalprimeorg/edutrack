<?php

namespace App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Staff;

use App\Actions\SchoolStaff\GetSchoolStaffByIdAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SuperAdmin\V1\SchoolManagement\Staff\GetStaffResource;

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

        $staff = $this->getSchoolStaffByIdAction->execute($staffId, $relationships);

        if (is_null($staff)) {
            return generateErrorApiMessage('Staff does not exist', 404);
        }

        $mutatedStaff = new GetStaffResource($staff);

        return generateSuccessApiMessage('Staff was retrieved successfully', 200, $mutatedStaff);
    }
}
