<?php

namespace App\Actions\SchoolStoreItem;

use App\Models\SchoolStoreItem;

class CreateSchoolStoreItemAction
{
    public function __construct(
        private SchoolStoreItem $schoolStoreItem
    ) {}

    public function execute(array $createSchoolStoreItemRecordOptions)
    {
        return $this->schoolStoreItem->create(
            $createSchoolStoreItemRecordOptions
        );
    }
}
