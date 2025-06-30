<?php

namespace App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Student;

use App\Actions\Student\GetStudentByIdAction;
use App\Actions\Student\UpdateStudentAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SuperAdmin\V1\SchoolManagement\Student\UpdateStudentRequest;

class UpdateStudentController extends Controller
{
    public function __construct(
        private GetStudentByIdAction $getStudentByIdAction,
        private UpdateStudentAction $updateStudentAction
    ) {}

    public function __invoke(UpdateStudentRequest $request, string $studentId)
    {
        $Student = $this->getStudentByIdAction->execute($studentId);

        if (is_null($Student)) {
            return generateErrorApiMessage('Student record does not exist', 404);
        }

        $updateStudentData = $request->validated();

        $updateStudentRecordOptions = [
            'id' => $studentId,
            'data' => $updateStudentData,
        ];

        $this->updateStudentAction->execute(
            $updateStudentRecordOptions
        );

        return generateSuccessApiMessage('Student record was updated successfully');
    }
}
