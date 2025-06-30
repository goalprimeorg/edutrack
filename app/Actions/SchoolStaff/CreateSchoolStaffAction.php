<?php

namespace App\Actions\SchoolStaff;

use App\Models\SchoolStaff;

class CreateSchoolStaffAction
{
    public function __construct(
        private SchoolStaff $schoolStaff
    ) {}

    public function execute(array $createSchoolStaffRecordOptions)
    {
        return $this->schoolStaff->create(
            $createSchoolStaffRecordOptions
        );
    }
}
