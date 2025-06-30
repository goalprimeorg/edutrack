<?php

namespace App\Actions\IncidentReport;

use App\Models\IncidentReport;

class CreateIncidentReportAction
{
    public function __construct(
        private IncidentReport $incidentReport
    ) {}

    public function execute(array $createIncidentReportRecordOptions)
    {
        return $this->incidentReport->create(
            $createIncidentReportRecordOptions
        );
    }
}
