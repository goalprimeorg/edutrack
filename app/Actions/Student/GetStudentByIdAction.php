<?php

namespace App\Actions\Student;

use App\Models\Student;

class GetStudentByIdAction
{
    public function __construct(
        private Student $student
    ) {}

    public function execute(string $id, array $relationships = [])
    {
        return $this->student->with(
            $relationships
        )->where([
            'id' => $id,
        ])->first();
    }
}
