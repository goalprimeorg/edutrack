<?php

namespace App\Actions\StudentAttendance;

use App\Models\StudentAttendance;

class UpdateStudentAttendanceAction
{
    public function __construct(
        private StudentAttendance $studentAttendance
    ) {}

    public function execute(array $updateStudentAttendance)
    {
        $id = $updateStudentAttendance['id'];
        $data = $updateStudentAttendance['data'];

        return $this->studentAttendance->where([
            'id' => $id,
        ])->update($data);
    }
}
