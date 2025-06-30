<?php

namespace App\Actions\SchoolStaff;

use App\Models\SchoolStaff;

class DeleteSchoolStaffAction
{
    public function __construct(
        private SchoolStaff $schoolStaff
    ) {}

    public function execute(array $deleteSchoolStaffRecordOptions)
    {
        $id = $deleteSchoolStaffRecordOptions['id'];

        return $this->schoolStaff->where([
            'id' => $id,
        ])->delete();
    }
}
