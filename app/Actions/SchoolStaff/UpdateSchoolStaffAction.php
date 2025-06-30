<?php

namespace App\Actions\SchoolStaff;

use App\Models\SchoolStaff;

class UpdateSchoolStaffAction
{
    public function __construct(
        private SchoolStaff $schoolStaff
    ) {}

    public function execute(array $updateSchoolStaffRecordOptions)
    {
        $id = $updateSchoolStaffRecordOptions['id'];
        $data = $updateSchoolStaffRecordOptions['data'];

        return $this->schoolStaff->where([
            'id' => $id,
        ])->update($data);
    }
}
