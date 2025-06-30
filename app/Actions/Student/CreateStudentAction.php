<?php

namespace App\Actions\Student;

use App\Models\Student;

class CreateStudentAction
{
    public function __construct(
        private Student $student
    ) {}

    public function execute(array $createStudentRecordOptions)
    {
        return $this->student->create(
            $createStudentRecordOptions
        );
    }
}
