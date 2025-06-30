<?php

namespace App\Actions\SchoolMetric;

use App\Models\SchoolMetric;

class GetSchoolMetricByIdAction
{
    public function __construct(
        private SchoolMetric $schoolMetric
    ) {}

    public function execute(string $id, array $relationships)
    {
        return $this->schoolMetric->with($relationships)->where([
            'id' => $id,
        ])->first();
    }
}
