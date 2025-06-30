<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Referral;

use App\Actions\Student\GetStudentByRegistrationNumberAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SchoolStaff\V1\SchoolManagement\Referral\GetStudentByRegistrationNumberResource;

class GetStudentByRegistrationNumberController extends Controller
{
    public function __construct(
        private GetStudentByRegistrationNumberAction $getStudentByRegistrationNumberAction
    ) {}

    public function __invoke(string $registrationNumber)
    {
        $loggedInSchoolStaff = auth('school-staff')->user();

        $student = $this->getStudentByRegistrationNumberAction->execute($registrationNumber);

        if (is_null($student) || $student->school_id !== $loggedInSchoolStaff->school_id) {
            return generateErrorApiMessage('Student profile does not exists', 404);
        }

        $responsePayload = new GetStudentByRegistrationNumberResource($student);

        return generateSuccessApiMessage('Student profile was retrieved successfully', 200, $responsePayload);
    }
}
