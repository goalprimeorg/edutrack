<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Request;

use App\Actions\Request\CreateRequestAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\Request\CreateRequestRequest;
use Illuminate\Support\Facades\DB;

class CreateRequestController extends Controller
{
    public function __construct(
        private CreateRequestAction $createRequestAction
    ) {}

    public function __invoke(CreateRequestRequest $request)
    {
        $requests = $request->requests;

        DB::transaction(function () use ($requests) {
            $loggedInSchoolStaff = auth('school-staff')->user();

            foreach ($requests as $request) {
                $createRequestsRecordOptions = [
                    'school_id' => $loggedInSchoolStaff->school_id,
                    'status' => 'pending',
                    'priority' => $request['priority'],
                    'item_id' => $request['item_id'],
                    'request_resource_type' => $request['request_resource_type'],
                    'requested_quantity' => $request['requested_quantity'],
                    'remarks' => $request['remarks'],
                ];

                $this->createRequestAction->execute(
                    $createRequestsRecordOptions
                );
            }
        });
        return generateSuccessApiMessage('Request was created successfully', 201);
    }
}
