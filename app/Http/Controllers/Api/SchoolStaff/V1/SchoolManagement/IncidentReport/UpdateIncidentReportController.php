<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\IncidentReport;

use App\Actions\IncidentReport\GetIncidentReportByIdAction;
use App\Actions\IncidentReport\UpdateIncidentReportAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\IncidentReport\UpdateIncidentReportRequest;

class UpdateIncidentReportController extends Controller
{
    public function __construct(
        private GetIncidentReportByIdAction $getIncidentReportByIdAction,
        private UpdateIncidentReportAction $updateIncidentReportAction
    ) {}

    public function __invoke(UpdateIncidentReportRequest $request, string $incidentReportId)
    {
        $incidentReport = $this->getIncidentReportByIdAction->execute($incidentReportId);

        $loggedInStaff = auth('school-staff')->user();

        if (is_null($incidentReport) || $incidentReport->school_id !== $loggedInStaff->school_id) {
            return generateErrorApiMessage('Incident report record does not exist', 404);
        }

        $updateIncidentReportData = $request->validated();

        $updateIncidentReportRecordOptions = [
            'id' => $incidentReportId,
            'data' => $updateIncidentReportData,
        ];

        $this->updateIncidentReportAction->execute(
            $updateIncidentReportRecordOptions
        );

        return generateSuccessApiMessage('Incident report record was updated successfully');
    }
}
