<?php

namespace App\Actions\Student;

use App\Models\Student;

class GetStudentByRegistrationNumberAction
{
    public function __construct(
        private Student $student
    ) {}

    public function execute(string $registrationNumber, array $relationships = [])
    {
        return $this->student->with(
            $relationships
        )->where([
            'registration_number' => $registrationNumber,
        ])->first();
    }
}
