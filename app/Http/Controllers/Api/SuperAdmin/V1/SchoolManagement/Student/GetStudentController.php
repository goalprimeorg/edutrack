<?php

namespace App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Student;

use App\Actions\Student\GetStudentByIdAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SuperAdmin\V1\SchoolManagement\Student\GetStudentResource;

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

        $Student = $this->getStudentByIdAction->execute($studentId, $relationships);

        if (is_null($Student)) {
            return generateErrorApiMessage('Student record does not exist', 404);
        }

        $mutatedStudent = new GetStudentResource($Student);

        return generateSuccessApiMessage('Student record was retrieved successfully', 200, $mutatedStudent);
    }
}
