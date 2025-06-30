<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Student;

use App\Actions\Student\GetStudentByIdAction;
use App\Actions\Student\UpdateStudentAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\Student\UpdateStudentRequest;

class UpdateStudentController extends Controller
{
    public function __construct(
        private GetStudentByIdAction $getStudentByIdAction,
        private UpdateStudentAction $updateStudentAction
    ) {}

    public function __invoke(UpdateStudentRequest $request, string $studentId)
    {
        $loggedInStaff = auth('school-staff')->user();

        $student = $this->getStudentByIdAction->execute($studentId);

        if (is_null($student) || $student->school_id !== $loggedInStaff->school_id) {
            return generateErrorApiMessage('Student record does not exist', 404);
        }

        $updateStudentData = $request->validated();

        $updateStudentRecordOptions = [
            'id' => $studentId,
            'data' => $updateStudentData,
        ];

        $this->updateStudentAction->execute(
            $updateStudentRecordOptions
        );

        return generateSuccessApiMessage('Student record was updated successfully');
    }
}
