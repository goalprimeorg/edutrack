<?php

namespace App\Actions\IncidentReport;

use App\Models\IncidentReport;

class ListIncidentReportsAction
{
    public function __construct(
        private IncidentReport $incidentReport
    ) {}

    public function execute(array $listIncidentReportsRecordOptions, array $relationships = [])
    {
        $schoolId = $listIncidentReportsRecordOptions['school_id'] ?? null;
        $incidentTypeId = $listIncidentReportsRecordOptions['incident_type_id'] ?? null;
        $perPage = $listIncidentReportsRecordOptions['per_page'] ?? 100;

        return $this->incidentReport->with(
            $relationships
        )->when($schoolId, function ($model, $schoolId) {
            $model->where([
                'school_id' => $schoolId,
            ]);
        })->when($incidentTypeId, function ($model, $incidentTypeId) {
            $model->where([
                'incident_type_id' => $incidentTypeId,
            ]);
        })->orderBy('date_of_incident', 'DESC')->paginate($perPage);
    }
}
