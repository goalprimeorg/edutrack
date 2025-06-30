<?php

namespace App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Classroom;

use App\Actions\Classroom\CreateClassroomAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SuperAdmin\V1\SchoolManagement\Classroom\CreateClassroomRequest;

class CreateClassroomController extends Controller
{
    public function __construct(
        private CreateClassroomAction $createClassroomAction
    ) {}

    public function __invoke(CreateClassroomRequest $request)
    {
        $createClassroomRecordOptions = $request->validated();

        $this->createClassroomAction->execute(
            $createClassroomRecordOptions
        );

        return generateSuccessApiMessage('Classroom record was created successfully', 201);
    }
}
