<?php

namespace App\Actions\IncidentReport;

use App\Models\IncidentReport;

class DeleteIncidentReportAction
{
    public function __construct(
        private IncidentReport $incidentReport
    ) {}

    public function execute(array $deleteIncidentReportRecordOptions)
    {
        $id = $deleteIncidentReportRecordOptions['id'];

        return $this->incidentReport->where([
            'id' => $id,
        ])->delete();
    }
}
