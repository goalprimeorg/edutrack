<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Classroom;

use App\Actions\Classroom\GetClassroomByIdAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SchoolStaff\V1\SchoolManagement\Classroom\GetClassroomResource;

class GetClassroomController extends Controller
{
    public function __construct(
        private GetClassroomByIdAction $getClassroomByIdAction,
    ) {}

    public function __invoke(string $classroomId)
    {
        $relationships = [
            'school',
            'formTeacher',
        ];

        $classroom = $this->getClassroomByIdAction->execute($classroomId, $relationships);

        $loggedInStaff = auth('school-staff')->user();

        if (is_null($classroom) || $classroom->school_id !== $loggedInStaff->school_id) {
            return generateErrorApiMessage('Classroom record does not exist', 404);
        }

        $mutatedClassroom = new GetClassroomResource($classroom);

        return generateSuccessApiMessage('Classroom record was retrieved successfully', 200, $mutatedClassroom);
    }
}
