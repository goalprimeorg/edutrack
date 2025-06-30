<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Request;

use App\Actions\Request\GetRequestByIdAction;
use App\Actions\Request\UpdateRequestAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\Request\UpdateRequestRequest;

class UpdateRequestController extends Controller
{
    public function __construct(
        private GetRequestByIdAction $getRequestByIdAction,
        private UpdateRequestAction $updateRequestAction,
    ) {}

    public function __invoke(UpdateRequestRequest $request, string $requestId)
    {
        $loggedInSchoolStaff = auth('school-staff')->user();

        $requestRecord = $this->getRequestByIdAction->execute(
            $requestId,
        );

        if (is_null($requestRecord) || $requestRecord->school_id !== $loggedInSchoolStaff->school_id) {
            return generateErrorApiMessage('Request record does not exists', 404);
        }

        $updateRequestRecordOptions = [
            'id' => $requestId,
            'data' => $request->validated(),
        ];

        $this->updateRequestAction->execute(
            $updateRequestRecordOptions
        );

        return generateSuccessApiMessage('Request was updated successfully', 200);
    }
}
