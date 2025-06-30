<?php

namespace App\Actions\School;

use App\Models\School;

class UpdateSchoolAction
{
    public function __construct(
        private School $school
    ) {}

    public function execute(array $updateSchoolRecordOptions)
    {
        $id = $updateSchoolRecordOptions['id'];
        $data = $updateSchoolRecordOptions['data'];

        return $this->school->where([
            'id' => $id,
        ])->update($data);
    }
}
