<?php

namespace App\Actions\SchoolStoreItem;

use App\Models\SchoolStoreItem;

class GetSchoolStoreItemByIdAction
{
    public function __construct(
        private SchoolStoreItem $schoolStoreItem
    ) {}

    public function execute(string $id, array $relationship = [])
    {
        return $this->schoolStoreItem->with(
            $relationship
        )->where([
            'id' => $id,
        ])->first();
    }
}
