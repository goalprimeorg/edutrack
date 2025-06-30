<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Student;

use App\Actions\Student\DeleteStudentAction;
use App\Actions\Student\GetStudentByIdAction;
use App\Http\Controllers\Controller;

class DeleteStudentController extends Controller
{
    public function __construct(
        private GetStudentByIdAction $getStudentByIdAction,
        private DeleteStudentAction $deleteStudentAction
    ) {}

    public function __invoke(string $studentId)
    {
        $loggedInStaff = auth('school-staff')->user();

        $student = $this->getStudentByIdAction->execute($studentId);

        if (is_null($student) || $student->school_id !== $loggedInStaff->school_id) {
            return generateErrorApiMessage('Student record does not exist', 404);
        }

        $deleteStudentRecordOptions = [
            'id' => $studentId,
        ];

        $this->deleteStudentAction->execute(
            $deleteStudentRecordOptions
        );

        return generateSuccessApiMessage('Student record was deleted successfully');
    }
}
