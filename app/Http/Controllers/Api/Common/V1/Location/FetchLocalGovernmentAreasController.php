<?php

namespace App\Http\Controllers\Api\Common\V1\Location;

use App\Actions\LocalGovernmentArea\ListLocalGovernmentAreasAction;
use App\Http\Controllers\Controller;
use App\Http\Resources\Api\Common\V1\Location\FetchLocalGovernmentAreasResource;

class FetchLocalGovernmentAreasController extends Controller
{
    public function __construct(
        private ListLocalGovernmentAreasAction $listLocalGovernmentAreasAction
    ) {}

    public function __invoke()
    {
        $localGovernmentAreas = $this->listLocalGovernmentAreasAction->execute();

        $responsePayload = FetchLocalGovernmentAreasResource::collection($localGovernmentAreas);

        return generateSuccessApiMessage('Fetched local government areas successfully', 200, $responsePayload);
    }
}
