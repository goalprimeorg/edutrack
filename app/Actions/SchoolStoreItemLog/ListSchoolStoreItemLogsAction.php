<?php

namespace App\Actions\SchoolStoreItemLog;

use App\Models\SchoolStoreItemLog;

class ListSchoolStoreItemLogsAction
{
    public function __construct(
        private SchoolStoreItemLog $schoolStoreItemLog
    ) {}

    public function execute(array $listSchoolStoreItemLogRecordOptions, array $relationships = [])
    {
        $schoolId = $listSchoolStoreItemLogRecordOptions['school_id'] ?? null;
        $schoolStoreItemId = $listSchoolStoreItemLogRecordOptions['school_store_item_id'] ?? null;
        $schoolStaffId = $listSchoolStoreItemLogRecordOptions['school_staff_id'] ?? null;

        $perPage = $listSchoolStoreItemLogRecordOptions['per_page'] ?? 100;

        return $this->schoolStoreItemLog->with(
            $relationships
        )->when($schoolId, function ($model, $schoolId) {
            $model->where([
                'school_id' => $schoolId,
            ]);
        })->when($schoolStoreItemId, function ($model, $schoolStoreItemId) {
            $model->where([
                'school_store_item_id' => $schoolStoreItemId,
            ]);
        })->when($schoolStaffId, function ($model, $schoolStaffId) {
            $model->where([
                'school_staff_id' => $schoolStaffId,
            ]);
        })->orderBy('created_at', 'DESC')->paginate($perPage);
    }
}
