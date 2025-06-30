<?php

namespace App\Actions\StudentAttendanceMeta;

use App\Models\StudentAttendanceMeta;

class CreateStudentAttendanceMetaAction
{
    public function __construct(
        private StudentAttendanceMeta $studentAttendanceMeta
    ) {}

    public function execute(array $createStudentAttendanceMeta)
    {
        return $this->studentAttendanceMeta->create($createStudentAttendanceMeta);
    }
}
