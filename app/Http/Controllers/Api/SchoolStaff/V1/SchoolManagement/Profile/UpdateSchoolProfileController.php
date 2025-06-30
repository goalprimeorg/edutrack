<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Profile;

use App\Actions\School\GetSchoolByIdAction;
use App\Actions\School\UpdateSchoolAction;
use App\Actions\SchoolMetric\UpdateSchoolMetricAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\Profile\UpdateSchoolProfileRequest;
use Illuminate\Support\Facades\DB;

class UpdateSchoolProfileController extends Controller
{
    public function __construct(
        private GetSchoolByIdAction $getSchoolByIdAction,
        private UpdateSchoolAction $updateSchoolAction,
        private UpdateSchoolMetricAction $updateSchoolMetricAction
    ) {}

    public function __invoke(UpdateSchoolProfileRequest $request)
    {
        DB::transaction(function () use ($request) {
            $loggedInSchoolStaff = auth('school-staff')->user();

            $relationships = [
                'metric',
            ];
            $school = $this->getSchoolByIdAction->execute(
                $loggedInSchoolStaff->school_id,
                $relationships
            );

            $updateSchoolRecordData = array_merge([
                'has_completed_profile' => true,
            ], $request->only(['name', 'address']));

            $updateSchoolRecordRecordOptions = [
                'id' => $school->id,
                'data' => $updateSchoolRecordData,
            ];

            $this->updateSchoolAction->execute(
                $updateSchoolRecordRecordOptions
            );

            $updateSchoolMetricsRecordData = $request->except(['name', 'address']);

            $updateSchoolMetricsRecordOptions = [
                'id' => $school->metric->id,
                'data' => $updateSchoolMetricsRecordData,
            ];

            $this->updateSchoolMetricAction->execute(
                $updateSchoolMetricsRecordOptions
            );
        });

        return generateSuccessApiMessage('School record was updated successfully', 200);
    }
}
