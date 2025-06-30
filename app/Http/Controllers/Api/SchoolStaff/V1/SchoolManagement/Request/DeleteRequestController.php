<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Request;

use App\Actions\Request\DeleteRequestAction;
use App\Actions\Request\GetRequestByIdAction;
use App\Http\Controllers\Controller;

class DeleteRequestController extends Controller
{
    public function __construct(
        private GetRequestByIdAction $getRequestByIdAction,
        private DeleteRequestAction $deleteRequestAction
    ) {}

    public function __invoke(string $requestId)
    {
        $loggedInSchoolStaff = auth('school-staff')->user();

        $relationships = [];

        $request = $this->getRequestByIdAction->execute(
            $requestId,
            $relationships
        );

        if (is_null($request) || $request->school_id !== $loggedInSchoolStaff->school_id) {
            return generateErrorApiMessage('Request record does not exists', 404);
        }

        $deleteRequestRecordOptions['id'] = $requestId;

        $this->deleteRequestAction->execute(
            $deleteRequestRecordOptions
        );

        return generateSuccessApiMessage('Request was deleted successfully', 200);
    }
}
