<?php

namespace App\Actions\School;

use App\Models\School;

class CreateSchoolAction
{
    public function __construct(
        private School $school
    ) {}

    public function execute(array $createSchoolRecordOptions)
    {
        return $this->school->create(
            $createSchoolRecordOptions
        );
    }
}
