<?php

namespace App\Actions\StudentAttendanceMeta;

use App\Models\StudentAttendanceMeta;

class GetDistinctStudentAttendanceMetaAction
{
    public function __construct(
        private StudentAttendanceMeta $studentAttendanceMeta
    ) {}

    public function execute($getDistinctStudentAttendanceMeta, array $relationships = [])
    {
        $schoolId = $getDistinctStudentAttendanceMeta['school_id'];
        $classroomId = $getDistinctStudentAttendanceMeta['classroom_id'];
        $dateOfAttendance = $getDistinctStudentAttendanceMeta['date_of_attendance'];

        return $this->studentAttendanceMeta->with($relationships)->where([
            'school_id' => $schoolId,
            'classroom_id' => $classroomId,
            'date_of_attendance' => $dateOfAttendance,
        ])->first();
    }
}
