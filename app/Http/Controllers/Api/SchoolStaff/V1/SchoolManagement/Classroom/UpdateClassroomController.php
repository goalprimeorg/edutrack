<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Classroom;

use App\Actions\Classroom\GetClassroomByIdAction;
use App\Actions\Classroom\UpdateClassroomAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\Classroom\UpdateClassroomRequest;

class UpdateClassroomController extends Controller
{
    public function __construct(
        private GetClassroomByIdAction $getClassroomByIdAction,
        private UpdateClassroomAction $updateClassroomAction
    ) {}

    public function __invoke(UpdateClassroomRequest $request, string $classroomId)
    {
        $classroom = $this->getClassroomByIdAction->execute($classroomId);

        $loggedInStaff = auth('school-staff')->user();

        if (is_null($classroom) || $classroom->school_id !== $loggedInStaff->school_id) {
            return generateErrorApiMessage('Classroom record does not exist', 404);
        }

        $updateClassroomData = $request->validated();

        $updateClassroomRecordOptions = [
            'id' => $classroomId,
            'data' => $updateClassroomData,
        ];

        $this->updateClassroomAction->execute(
            $updateClassroomRecordOptions
        );

        return generateSuccessApiMessage('Classroom record was updated successfully');
    }
}
