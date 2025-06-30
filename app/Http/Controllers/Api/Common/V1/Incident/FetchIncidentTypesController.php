<?php

namespace App\Http\Controllers\Api\Common\V1\Incident;

use App\Actions\IncidentType\ListIncidentTypesAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Common\V1\Incident\FetchIncidentTypesResource;

class FetchIncidentTypesController extends Controller
{
    public function __construct(
        private ListIncidentTypesAction $listIncidentTypesAction
    ) {}

    public function __invoke()
    {
        $incidentTypes = $this->listIncidentTypesAction->execute();

        $responsePayload = FetchIncidentTypesResource::collection($incidentTypes);

        return generateSuccessApiMessage('Fetched incident types successfully', 200, $responsePayload);
    }
}
