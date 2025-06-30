<?php

namespace App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Staff;

use App\Actions\Classroom\UpdateClassroomAction;
use App\Actions\SchoolStaff\CreateSchoolStaffAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SuperAdmin\V1\SchoolManagement\Staff\CreateStaffRequest;
use App\InfrastructureProviders\Internal\CipherClient;
use Illuminate\Support\Facades\DB;

class CreateStaffController extends Controller
{
    public function __construct(
        private CreateSchoolStaffAction $createSchoolStaffAction,
        private UpdateClassroomAction $updateClassroomAction
    ) {}

    public function __invoke(CreateStaffRequest $request)
    {
        DB::transaction(function () use ($request) {
            $createStaffRecordOptions = $request->except('current_classroom_id');

            $randomPassword = generateRandomString();

            $createStaffRecordOptions = array_merge($createStaffRecordOptions, [
                'password' => CipherClient::hash($randomPassword),
                'role' => 'teacher',
            ]);

            $createdStaff = $this->createSchoolStaffAction->execute(
                $createStaffRecordOptions
            );

            $updateClassroomRecordOptions = [
                'id' => $request->current_classroom_id,
                'data' => [
                    'form_teacher_id' => $createdStaff->id,
                ],
            ];

            $this->updateClassroomAction->execute(
                $updateClassroomRecordOptions
            );
        });

        return generateSuccessApiMessage('Staff record was created successfully', 201);
    }
}
