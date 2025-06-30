<?php

namespace App\Actions\StudentAttendance;

use App\Models\StudentAttendance;

class CreateStudentAttendanceAction
{
    public function __construct(
        private StudentAttendance $studentAttendance
    ) {}

    public function execute(array $createStudentAttendance)
    {
        return $this->studentAttendance->create($createStudentAttendance);
    }
}
