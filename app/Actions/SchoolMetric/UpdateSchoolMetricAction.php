<?php

namespace App\Actions\SchoolMetric;

use App\Models\SchoolMetric;

class UpdateSchoolMetricAction
{
    public function __construct(
        private SchoolMetric $schoolMetric
    ) {}

    public function execute(array $updateSchoolMetricRecordOptions)
    {
        $id = $updateSchoolMetricRecordOptions['id'];
        $data = $updateSchoolMetricRecordOptions['data'];

        return $this->schoolMetric->where([
            'id' => $id,
        ])->update($data);
    }
}
