<?php

namespace App\Actions\SchoolStoreItem;

use App\Models\SchoolStoreItem;

class UpdateSchoolStoreItemAction
{
    public function __construct(
        private SchoolStoreItem $schoolStoreItem
    ) {}

    public function execute(array $updateSchoolStoreItemRecordOptions)
    {
        $id = $updateSchoolStoreItemRecordOptions['id'];
        $data = $updateSchoolStoreItemRecordOptions['data'];

        return $this->schoolStoreItem->where([
            'id' => $id,
        ])->update($data);
    }
}
