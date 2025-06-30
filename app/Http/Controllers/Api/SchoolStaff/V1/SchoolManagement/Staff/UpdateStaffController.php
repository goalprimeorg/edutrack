<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Staff;

use App\Actions\Classroom\UpdateClassroomAction;
use App\Actions\SchoolStaff\GetSchoolStaffByIdAction;
use App\Actions\SchoolStaff\UpdateSchoolStaffAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\Staff\UpdateStaffRequest;
use Illuminate\Support\Facades\DB;

class UpdateStaffController extends Controller
{
    public function __construct(
        private GetSchoolStaffByIdAction $getSchoolStaffByIdAction,
        private UpdateSchoolStaffAction $updateSchoolStaffAction,
        private UpdateClassroomAction $updateClassroomAction,
    ) {}

    public function __invoke(UpdateStaffRequest $request, string $staffId)
    {
        $loggedInStaff = auth('school-staff')->user();

        $schoolStaff = $this->getSchoolStaffByIdAction->execute($staffId);

        if (is_null($schoolStaff) || $loggedInStaff->school_id !== $schoolStaff->school_id) {
            return generateErrorApiMessage('Staff record does not exist', 404);
        }

        DB::transaction(function () use ($request, $staffId) {
            $updateSchoolStaffData = $request->except('current_classroom_id');

            $updateSchoolStaffRecordOptions = [
                'id' => $staffId,
                'data' => $updateSchoolStaffData,
            ];

            $this->updateSchoolStaffAction->execute(
                $updateSchoolStaffRecordOptions
            );

            $updateClassroomRecordOptions = [
                'id' => $request->current_classroom_id,
                'data' => [
                    'form_teacher_id' => $staffId,
                ],
            ];

            $this->updateClassroomAction->execute(
                $updateClassroomRecordOptions
            );
        });

        return generateSuccessApiMessage('Staff record was updated successfully');
    }
}
