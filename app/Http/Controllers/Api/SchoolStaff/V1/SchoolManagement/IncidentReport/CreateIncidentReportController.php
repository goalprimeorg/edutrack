<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\IncidentReport;

use App\Actions\IncidentReport\CreateIncidentReportAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\IncidentReport\CreateIncidentReportRequest;

class CreateIncidentReportController extends Controller
{
    public function __construct(
        private CreateIncidentReportAction $createIncidentReportAction
    ) {}

    public function __invoke(CreateIncidentReportRequest $request)
    {
        $loggedInStaff = auth('school-staff')->user();

        $createIncidentReportRecordOptions = $request->safe()->merge([
            'school_id' => $loggedInStaff->school_id,
            'tracking_code' => generateRandomString(),
        ])->all();

        $this->createIncidentReportAction->execute(
            $createIncidentReportRecordOptions
        );

        return generateSuccessApiMessage('Incident report record was created successfully', 201);
    }
}
