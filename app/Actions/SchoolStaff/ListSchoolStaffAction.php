<?php

namespace App\Actions\SchoolStaff;

use App\Models\SchoolStaff;

class ListSchoolStaffAction
{
    public function __construct(
        private SchoolStaff $schoolStaff
    ) {}

    public function execute(array $listSchoolStaffRecordOptions, array $relationships = [])
    {
        $schoolId = $listSchoolStaffRecordOptions['school_id'] ?? null;
        $perPage = $listSchoolStaffRecordOptions['per_page'] ?? 100;

        return $this->schoolStaff->with($relationships)->when($schoolId, function ($model, $schoolId) {
            $model->where([
                'school_id' => $schoolId,
            ]);
        })->orderBy('first_name', 'ASC')->paginate($perPage);
    }
}
