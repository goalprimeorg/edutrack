<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Attendance;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\Attendance\MarkStudentAttendanceRequest;
use App\Jobs\ProcessingJob\SchoolManagement\MarkStudentAttendanceProcessingJob;

class MarkStudentAttendanceController extends Controller
{
    public function __invoke(MarkStudentAttendanceRequest $request)
    {
        $loggedInStaff = auth('school-staff')->user();

        $markStudentAttendanceOptions = $request->merge([
            'marked_by_school_staff_id' => $loggedInStaff->id,
            'school_id' => $loggedInStaff->school_id,
        ])->all();

        dispatch(
            new MarkStudentAttendanceProcessingJob(
                $markStudentAttendanceOptions
            )
        );

        return generateSuccessApiMessage('Student attendance is currently being processed. Please wait...', 202);
    }
}
