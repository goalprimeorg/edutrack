<?php

namespace App\Actions\StudentAttendance;

use App\Models\StudentAttendance;

class DeleteStudentAttendanceAction
{
    public function __construct(
        private StudentAttendance $studentAttendance
    ) {}

    public function execute(array $deleteStudentAttendance)
    {
        $id = $deleteStudentAttendance['id'];

        return $this->studentAttendance->where([
            'id' => $id,
        ])->delete();
    }
}
