<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\IncidentReport;

use App\Actions\IncidentReport\ListIncidentReportsAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\IncidentReport\FetchIncidentReportsRequest;
use App\Http\Resources\Api\SchoolStaff\V1\SchoolManagement\IncidentReport\FetchIncidentReportsResource;

class FetchIncidentReportsController extends Controller
{
    public function __construct(
        public ListIncidentReportsAction $listIncidentReportsAction
    ) {}

    public function __invoke(FetchIncidentReportsRequest $request)
    {
        $loggedInSchoolStaff = auth('school-staff')->user();

        $listIncidentReportsRecordOptions = $request->safe()->merge([
            'school_id' => $loggedInSchoolStaff->school_id,
        ])->all();

        $relationships = [
            'school',
            'incidentType',
        ];

        $incidentReports = $this->listIncidentReportsAction->execute(
            $listIncidentReportsRecordOptions,
            $relationships
        );

        $mutatedIncidentReports = FetchIncidentReportsResource::collection($incidentReports);

        $links = generatePaginationLinks($incidentReports);
        $meta = generatePaginationMeta($incidentReports);

        $responsePayload = [
            'incident_reports' => $mutatedIncidentReports,
            'links' => $links,
            'meta' => $meta,
        ];

        return generateSuccessApiMessage('Incident reports record was retrieved successfully', 200, $responsePayload);
    }
}
