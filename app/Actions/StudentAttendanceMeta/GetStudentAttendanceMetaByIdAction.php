<?php

namespace App\Actions\StudentAttendanceMeta;

use App\Models\StudentAttendanceMeta;

class GetStudentAttendanceMetaByIdAction
{
    public function __construct(
        private StudentAttendanceMeta $studentAttendanceMeta
    ) {}

    public function execute($studentAttendanceMetaId, array $relationships = [])
    {
        return $this->studentAttendanceMeta->with($relationships)->where([
            'id' => $studentAttendanceMetaId,
        ])->first();
    }
}
