<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Attendance;

use App\Actions\StudentAttendanceMeta\ListStudentAttendanceMetasAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\Attendance\FetchStudentAttendanceRequest;
use App\Http\Resources\Api\SchoolStaff\V1\SchoolManagement\Attendance\FetchStudentAttendancesResource;

class FetchStudentAttendanceController extends Controller
{
    public function __construct(
        private ListStudentAttendanceMetasAction $listStudentAttendanceMetasAction
    ) {}

    public function __invoke(FetchStudentAttendanceRequest $request)
    {

        $loggedInStaff = auth('school-staff')->user();

        $listStudentAttendancesRecordOptions = $request->merge([
            'school_id' => $loggedInStaff->school_id,
        ])->all();

        if ($loggedInStaff !== 'admin') {
            $listStudentAttendancesRecordOptions['marked_by_school_staff_id'] = $loggedInStaff->id;
        }

        $relationships = [
            'classroom',
            'markedBySchoolStaff',
        ];

        $listOfStudentAttendances = $this->listStudentAttendanceMetasAction->execute(
            $listStudentAttendancesRecordOptions,
            $relationships
        );

        $mutatedStudentAttendances = FetchStudentAttendancesResource::collection($listOfStudentAttendances);
        $links = generatePaginationLinks($listOfStudentAttendances);
        $meta = generatePaginationMeta($listOfStudentAttendances);

        $responsePayload = [
            'student_attendances' => $mutatedStudentAttendances,
            'links' => $links,
            'meta' => $meta,
        ];

        return generateSuccessApiMessage('List of student attendances were retrieved successfully', 200, $responsePayload);
    }
}
