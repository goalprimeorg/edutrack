<?php

namespace App\Actions\School;

use App\Models\School;

class ListSchoolsAction
{
    public function __construct(
        private School $school
    ) {}

    public function execute(array $listSchoolRecordOptions, array $relationships = [])
    {
        $perPage = $listSchoolRecordOptions['per_page'] ?? 100;
        $localGovernmentAreaId = $listSchoolRecordOptions['local_government_area_id'] ?? null;

        return $this->school->with(
            $relationships
        )->when($localGovernmentAreaId, function ($model, $localGovernmentAreaId) {
            $model->where([
                'local_government_area_id' => $localGovernmentAreaId,
            ]);
        })->orderBy('name', 'ASC')->paginate($perPage);
    }
}
