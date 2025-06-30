<?php

namespace App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Classroom;

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

        if (is_null($classroom)) {
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
