<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Student;

use App\Actions\Student\CreateStudentAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\Student\CreateStudentRequest;

class CreateStudentController extends Controller
{
    public function __construct(
        private CreateStudentAction $createStudentAction
    ) {}

    public function __invoke(CreateStudentRequest $request)
    {
        $loggedInStaff = auth('school-staff')->user();

        $createStudentRecordOptions = $request->safe()->merge([
            'school_id' => $loggedInStaff->school_id,
        ])->all();

        $this->createStudentAction->execute(
            $createStudentRecordOptions
        );

        return generateSuccessApiMessage('Student record was created successfully', 201);
    }
}
