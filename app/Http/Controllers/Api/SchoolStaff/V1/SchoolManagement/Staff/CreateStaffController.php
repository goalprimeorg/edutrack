<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Staff;

use App\Actions\Classroom\UpdateClassroomAction;
use App\Actions\SchoolStaff\CreateSchoolStaffAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\SchoolManagement\Staff\CreateStaffRequest;
use App\InfrastructureProviders\Internal\CipherClient;
use App\Jobs\Notifications\Onboarding\SendNewSchoolStaffNotificationJob;
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
            $loggedInStaff = auth('school-staff')->user();

            $createStaffRecordOptions = $request->except('current_classroom_id');

            $createStaffRecordOptions = array_merge($createStaffRecordOptions, [
                'password' => CipherClient::hash($request->phone_number),
                'role' => 'teacher',
                'school_id' => $loggedInStaff->school_id,
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

            dispatch(
                new SendNewSchoolStaffNotificationJob([
                    'email' => $createdStaff->email,
                    'full_name' => "{$createdStaff->first_name} {$createdStaff->middle_name} {$createdStaff->last_name}",
                    'role' => $createdStaff->role,
                    'password' => $request->phone_number,
                ])
            );
        });

        return generateSuccessApiMessage('Staff record was created successfully', 201);
    }
}
