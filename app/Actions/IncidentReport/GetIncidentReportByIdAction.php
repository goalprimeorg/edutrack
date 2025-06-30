<?php

namespace App\Actions\IncidentReport;

use App\Models\IncidentReport;

class GetIncidentReportByIdAction
{
    public function __construct(
        private IncidentReport $incidentReport
    ) {}

    public function execute(string $id, array $relationships = [])
    {
        return $this->incidentReport->with(
            $relationships
        )->where([
            'id' => $id,
        ])->first();
    }
}
