<?php

namespace App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Classroom;

use App\Actions\Classroom\GetClassroomByIdAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SuperAdmin\V1\SchoolManagement\Classroom\GetClassroomResource;

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

        if (is_null($classroom)) {
            return generateErrorApiMessage('Classroom record does not exist', 404);
        }

        $mutatedClassroom = new GetClassroomResource($classroom);

        return generateSuccessApiMessage('Classroom record was retrieved successfully', 200, $mutatedClassroom);
    }
}
