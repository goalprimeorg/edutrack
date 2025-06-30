<?php

namespace App\Actions\QualificationType;

use App\Models\QualificationType;

class ListQualificationTypesAction
{
    public function __construct(
        private QualificationType $qualificationType
    ) {}

    public function execute(array $relationships = [])
    {
        return $this->qualificationType->with(
            $relationships
        )->orderBy('name', 'asc')->get();
    }
}
