<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Classroom;

use App\Actions\Classroom\DeleteClassroomAction;
use App\Actions\Classroom\GetClassroomByIdAction;
use App\Http\Controllers\Controller;

class DeleteClassroomController extends Controller
{
    public function __construct(
        private GetClassroomByIdAction $getClassroomByIdAction,
        private DeleteClassroomAction $deleteClassroomAction
    ) {}

    public function __invoke(string $classroomId)
    {
        $classroom = $this->getClassroomByIdAction->execute($classroomId);

        $loggedInStaff = auth('school-staff')->user();

        if (is_null($classroom) || $classroom->school_id !== $loggedInStaff->school_id) {
            return generateErrorApiMessage('Classroom record does not exist', 404);
        }

        $deleteClassroomRecordOptions = [
            'id' => $classroomId,
        ];

        $this->deleteClassroomAction->execute(
            $deleteClassroomRecordOptions
        );

        return generateSuccessApiMessage('Classroom record was deleted successfully');
    }
}
