<?php

namespace App\Actions\StudentAttendanceMeta;

use App\Models\StudentAttendanceMeta;

class DeleteStudentAttendanceMetaAction
{
    public function __construct(
        private StudentAttendanceMeta $studentAttendanceMeta
    ) {}

    public function execute(array $deleteStudentAttendanceMeta)
    {
        $id = $deleteStudentAttendanceMeta['id'];

        return $this->studentAttendanceMeta->where([
            'id' => $id,
        ])->delete();
    }
}
