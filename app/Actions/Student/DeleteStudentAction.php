<?php

namespace App\Actions\Student;

use App\Models\Student;

class DeleteStudentAction
{
    public function __construct(
        private Student $student
    ) {}

    public function execute(array $deleteStudentRecordOptions)
    {
        $id = $deleteStudentRecordOptions['id'];

        return $this->student->where([
            'id' => $id,
        ])->delete();
    }
}
