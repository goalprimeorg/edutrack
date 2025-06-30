<?php

namespace App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Classroom;

use App\Actions\Classroom\GetClassroomByIdAction;
use App\Actions\Classroom\UpdateClassroomAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SuperAdmin\V1\SchoolManagement\Classroom\UpdateClassroomRequest;

class UpdateClassroomController extends Controller
{
    public function __construct(
        private GetClassroomByIdAction $getClassroomByIdAction,
        private UpdateClassroomAction $updateClassroomAction
    ) {}

    public function __invoke(UpdateClassroomRequest $request, string $classroomId)
    {
        $classroom = $this->getClassroomByIdAction->execute($classroomId);

        if (is_null($classroom)) {
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
