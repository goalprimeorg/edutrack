<?php

namespace App\Actions\IncidentType;

use App\Models\IncidentType;

class ListIncidentTypesAction
{
    public function __construct(
        private IncidentType $incidentType
    ) {}

    public function execute(array $relationships = [])
    {
        return $this->incidentType->with(
            $relationships
        )->orderBy('name', 'asc')->get();
    }
}
