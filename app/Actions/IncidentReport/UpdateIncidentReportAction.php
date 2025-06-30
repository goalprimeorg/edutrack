<?php

namespace App\Actions\IncidentReport;

use App\Models\IncidentReport;

class UpdateIncidentReportAction
{
    public function __construct(
        private IncidentReport $incidentReport
    ) {}

    public function execute(array $updateIncidentReportRecordOptions)
    {
        $id = $updateIncidentReportRecordOptions['id'];
        $data = $updateIncidentReportRecordOptions['data'];

        return $this->incidentReport->where([
            'id' => $id,
        ])->update($data);
    }
}
