<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Classroom;

use App\Actions\Classroom\CreateClassroomAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\Classroom\CreateClassroomRequest;

class CreateClassroomController extends Controller
{
    public function __construct(
        private CreateClassroomAction $createClassroomAction
    ) {}

    public function __invoke(CreateClassroomRequest $request)
    {
        $loggedInStaff = auth('school-staff')->user();

        $createClassroomRecordOptions = $request->safe()->merge([
            'school_id' => $loggedInStaff->school_id,
        ])->all();

        $this->createClassroomAction->execute(
            $createClassroomRecordOptions
        );

        return generateSuccessApiMessage('Classroom record was created successfully', 201);
    }
}
