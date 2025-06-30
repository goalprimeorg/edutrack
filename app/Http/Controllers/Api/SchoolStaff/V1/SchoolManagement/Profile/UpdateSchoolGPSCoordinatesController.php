<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Profile;

use App\Actions\School\UpdateSchoolAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\Profile\UpdateSchoolGPSCoordinatesRequest;
use Illuminate\Support\Facades\DB;

class UpdateSchoolGPSCoordinatesController extends Controller
{
    public function __construct(
        private UpdateSchoolAction $updateSchoolAction,
    ) {}

    public function __invoke(UpdateSchoolGPSCoordinatesRequest $request)
    {
        DB::transaction(function () use ($request) {
            $loggedInSchoolStaff = auth('school-staff')->user();

            $updateSchoolRecordData = $request->validated();

            $updateSchoolRecordRecordOptions = [
                'id' => $loggedInSchoolStaff->school_id,
                'data' => $updateSchoolRecordData,
            ];

            $this->updateSchoolAction->execute(
                $updateSchoolRecordRecordOptions
            );
        });

        return generateSuccessApiMessage('School record was updated successfully', 200);
    }
}
