<?php

namespace App\Actions\SchoolStoreItem;

use App\Models\SchoolStoreItem;

class ListSchoolStoreItemsAction
{
    public function __construct(
        private SchoolStoreItem $schoolStoreItem
    ) {}

    public function execute(array $listSchoolStoreItemRecordOptions, array $relationships = [])
    {
        $schoolId = $listSchoolStoreItemRecordOptions['school_id'] ?? null;
        $itemId = $listSchoolStoreItemRecordOptions['item_id'] ?? null;
        $perPage = $listSchoolStoreItemRecordOptions['per_page'] ?? 100;

        return $this->schoolStoreItem->with(
            $relationships
        )->when($schoolId, function ($model, $schoolId) {
            $model->where([
                'school_id' => $schoolId,
            ]);
        })->when($itemId, function ($model, $itemId) {
            $model->where([
                'item_id' => $itemId,
            ]);
        })->orderBy('current_quantity', 'DESC')->paginate($perPage);
    }
}
