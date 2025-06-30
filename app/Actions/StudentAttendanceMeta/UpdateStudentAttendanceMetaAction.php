<?php

namespace App\Actions\StudentAttendanceMeta;

use App\Models\StudentAttendanceMeta;

class UpdateStudentAttendanceMetaAction
{
    public function __construct(
        private StudentAttendanceMeta $studentAttendanceMeta
    ) {}

    public function execute(array $updateStudentAttendanceMeta)
    {
        $id = $updateStudentAttendanceMeta['id'];
        $data = $updateStudentAttendanceMeta['data'];

        return $this->studentAttendanceMeta->where([
            'id' => $id,
        ])->update($data);
    }
}
