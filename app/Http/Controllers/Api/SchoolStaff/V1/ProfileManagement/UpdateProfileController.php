<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\ProfileManagement;

use App\Actions\SchoolStaff\UpdateSchoolStaffAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\ProfileManagement\UpdateProfileRequest;

class UpdateProfileController extends Controller
{
    public function __construct(
        private UpdateSchoolStaffAction $updateSchoolStaffAction
    ) {}

    public function __invoke(UpdateProfileRequest $request)
    {
        $loggedInStaff = auth('school-staff')->user();

        $updateSchoolStaffProfileData = $request->validated();

        $updateSchoolStaffProfileData['trainings_attended'] = json_encode($updateSchoolStaffProfileData['trainings_attended']);

        $updateSchoolStaffRecordOptions['id'] = $loggedInStaff->id;
        $updateSchoolStaffRecordOptions['data'] = $updateSchoolStaffProfileData;

        $this->updateSchoolStaffAction->execute(
            $updateSchoolStaffRecordOptions
        );

        return generateSuccessApiMessage('School staff profile updated successfully', 200);
    }
}
