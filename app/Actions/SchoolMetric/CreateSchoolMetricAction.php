<?php

namespace App\Actions\SchoolMetric;

use App\Models\SchoolMetric;

class CreateSchoolMetricAction
{
    public function __construct(
        private SchoolMetric $schoolMetric
    ) {}

    public function execute(array $createSchoolMetricRecordOptions)
    {
        return $this->schoolMetric->create(
            $createSchoolMetricRecordOptions
        );
    }
}
