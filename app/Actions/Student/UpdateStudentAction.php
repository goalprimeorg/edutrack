<?php

namespace App\Actions\Student;

use App\Models\Student;

class UpdateStudentAction
{
    public function __construct(
        private Student $student
    ) {}

    public function execute(array $updateStudentRecordOptions)
    {
        $id = $updateStudentRecordOptions['id'];
        $data = $updateStudentRecordOptions['data'];

        return $this->student->where([
            'id' => $id,
        ])->update($data);
    }
}
