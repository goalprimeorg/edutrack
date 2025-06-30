<?php

namespace App\Actions\StudentAttendance;

use App\Models\StudentAttendance;

class GetStudentAttendanceByIdAction
{
    public function __construct(
        private StudentAttendance $studentAttendance
    ) {}

    public function execute($studentAttendanceId, array $relationships = [])
    {
        return $this->studentAttendance->with($relationships)->where([
            'id' => $studentAttendanceId,
        ])->first();
    }
}
