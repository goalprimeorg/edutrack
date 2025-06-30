<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Student;

use App\Actions\Student\GetStudentByIdAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SchoolStaff\V1\SchoolManagement\Student\GetStudentResource;

class GetStudentController extends Controller
{
    public function __construct(
        private GetStudentByIdAction $getStudentByIdAction,
    ) {}

    public function __invoke(string $studentId)
    {
        $relationships = [
            'school',
            'currentClassroom.formTeacher',
        ];

        $loggedInStaff = auth('school-staff')->user();

        $student = $this->getStudentByIdAction->execute($studentId, $relationships);

        if (is_null($student) || $student->school_id !== $loggedInStaff->school_id) {
            return generateErrorApiMessage('Student record does not exist', 404);
        }

        $mutatedStudent = new GetStudentResource($student);

        return generateSuccessApiMessage('Student record was retrieved successfully', 200, $mutatedStudent);
    }
}
