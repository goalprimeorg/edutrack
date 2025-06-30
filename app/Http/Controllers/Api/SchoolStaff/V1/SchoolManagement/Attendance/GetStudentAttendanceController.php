<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Attendance;

use App\Actions\StudentAttendanceMeta\GetStudentAttendanceMetaByIdAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\SchoolStaff\V1\SchoolManagement\Attendance\GetStudentAttendanceResource;

class GetStudentAttendanceController extends Controller
{
    public function __construct(
        private GetStudentAttendanceMetaByIdAction $getStudentAttendanceMetaByIdAction
    ) {}

    public function __invoke(string $studentAttendanceMetaId)
    {
        $loggedInStaff = auth('school-staff')->user();

        $relationships = [
            'classroom',
            'markedBySchoolStaff',
            'studentAttendances.student',
        ];

        $studentAttendanceMeta = $this->getStudentAttendanceMetaByIdAction->execute(
            $studentAttendanceMetaId,
            $relationships
        );

        if (is_null($studentAttendanceMeta) || $studentAttendanceMeta->school_id !== $loggedInStaff->school_id) {
            return generateErrorApiMessage('Student attendance record does not exists', 404);
        }

        $mutatedStudentAttendance = new GetStudentAttendanceResource($studentAttendanceMeta);

        return generateSuccessApiMessage('Student attendance was retrieved successfully', 200, $mutatedStudentAttendance);
    }
}
