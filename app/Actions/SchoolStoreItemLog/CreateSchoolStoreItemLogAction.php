<?php

namespace App\Actions\SchoolStoreItemLog;

use App\Models\SchoolStoreItemLog;

class CreateSchoolStoreItemLogAction
{
    public function __construct(
        private SchoolStoreItemLog $schoolStoreItemLog
    ) {}

    public function execute(array $createSchoolStoreItemLogRecordOptions)
    {
        return $this->schoolStoreItemLog->create(
            $createSchoolStoreItemLogRecordOptions
        );
    }
}
