<?php

namespace App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Profile;

use App\Actions\School\CreateSchoolAction;
use App\Actions\SchoolMetric\CreateSchoolMetricAction;
use App\Actions\SchoolStaff\CreateSchoolStaffAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SuperAdmin\V1\SchoolManagement\Profile\CreateNewSchoolRequest;
use App\InfrastructureProviders\Internal\CipherClient;
use Illuminate\Support\Facades\DB;

class CreateNewSchoolController extends Controller
{
    public function __construct(
        private CreateSchoolAction $createSchoolAction,
        private CreateSchoolStaffAction $createSchoolStaffAction,
        private CreateSchoolMetricAction $createSchoolMetricAction,
    ) {}

    public function __invoke(CreateNewSchoolRequest $request)
    {

        DB::transaction(function () use ($request) {
            $createSchoolRecordOptions = $request->except('school_admin');

            $createdSchool = $this->createSchoolAction->execute(
                $createSchoolRecordOptions
            );

            $createSchoolStaffRecordOptions = $request->school_admin;

            $randomPassword = generateRandomString();

            $createSchoolStaffRecordOptions = array_merge($createSchoolStaffRecordOptions, [
                'school_id' => $createdSchool->id,
                'password' => CipherClient::hash($randomPassword),
                'role' => 'admin',
            ]);

            $this->createSchoolStaffAction->execute(
                $createSchoolStaffRecordOptions
            );

            $createSchoolMetricsRecordOptions = [
                'school_id' => $createdSchool->id,
            ];

            $this->createSchoolMetricAction->execute(
                $createSchoolMetricsRecordOptions
            );
        });

        return generateSuccessApiMessage('School record was created successfully', 201);
    }
}
