<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\IncidentReport;

use App\Actions\IncidentReport\DeleteIncidentReportAction;
use App\Actions\IncidentReport\GetIncidentReportByIdAction;
use App\Http\Controllers\Controller;

class DeleteIncidentReportController extends Controller
{
    public function __construct(
        private GetIncidentReportByIdAction $getIncidentReportByIdAction,
        private DeleteIncidentReportAction $deleteIncidentReportAction
    ) {}

    public function __invoke(string $incidentReportId)
    {
        $incidentReport = $this->getIncidentReportByIdAction->execute($incidentReportId);

        $loggedInStaff = auth('school-staff')->user();

        if (is_null($incidentReport) || $incidentReport->school_id !== $loggedInStaff->school_id) {
            return generateErrorApiMessage('Incident report record does not exist', 404);
        }

        $deleteIncidentReportRecordOptions = [
            'id' => $incidentReportId,
        ];

        $this->deleteIncidentReportAction->execute(
            $deleteIncidentReportRecordOptions
        );

        return generateSuccessApiMessage('Incident report record was deleted successfully');
    }
}
