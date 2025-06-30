<?php

namespace App\Actions\SchoolStoreItemLog;

use App\Models\SchoolStoreItemLog;

class UpdateSchoolStoreItemLogAction
{
    public function __construct(
        private SchoolStoreItemLog $schoolStoreItemLog
    ) {}

    public function execute(array $updateSchoolStoreItemLogRecordOptions)
    {
        $id = $updateSchoolStoreItemLogRecordOptions['id'];
        $data = $updateSchoolStoreItemLogRecordOptions['data'];

        return $this->schoolStoreItemLog->where([
            'id' => $id,
        ])->update($data);
    }
}
