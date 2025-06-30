<?php

namespace App\Actions\SchoolStoreItemLog;

use App\Models\SchoolStoreItemLog;

class GetSchoolStoreItemLogByIdAction
{
    public function __construct(
        private SchoolStoreItemLog $schoolStoreItemLog
    ) {}

    public function execute(string $id, array $relationship = [])
    {
        return $this->schoolStoreItemLog->with(
            $relationship
        )->where([
            'id' => $id,
        ])->first();
    }
}
