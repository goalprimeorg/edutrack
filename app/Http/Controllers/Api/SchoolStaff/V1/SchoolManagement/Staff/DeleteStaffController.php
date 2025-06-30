<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Staff;

use App\Actions\SchoolStaff\DeleteSchoolStaffAction;
use App\Actions\SchoolStaff\GetSchoolStaffByIdAction;
use App\Http\Controllers\Controller;

class DeleteStaffController extends Controller
{
    public function __construct(
        private GetSchoolStaffByIdAction $getSchoolStaffByIdAction,
        private DeleteSchoolStaffAction $deleteSchoolStaffAction
    ) {}

    public function __invoke(string $staffId)
    {
        $loggedInStaff = auth('school-staff')->user();

        $schoolStaff = $this->getSchoolStaffByIdAction->execute($staffId);

        if (is_null($schoolStaff) || $loggedInStaff->school_id !== $schoolStaff->school_id) {
            return generateErrorApiMessage('Staff record does not exist', 404);
        }

        $deleteSchoolStaffRecordOptions = [
            'id' => $staffId,
        ];

        $this->deleteSchoolStaffAction->execute(
            $deleteSchoolStaffRecordOptions
        );

        return generateSuccessApiMessage('Staff record was deleted successfully');
    }
}
