<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\PasswordManagement\ChangePassword;

use App\Actions\SchoolStaff\UpdateSchoolStaffAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\PasswordManagement\ChangePassword\ChangePasswordRequest;
use App\InfrastructureProviders\Internal\CipherClient;

class ChangePasswordController extends Controller
{
    public function __construct(
        private UpdateSchoolStaffAction $updateSchoolStaffAction,
    ) {}

    public function __invoke(ChangePasswordRequest $request)
    {
        $loggedInSchoolStaff = auth('school-staff')->user();

        if (CipherClient::verify($request->old_password, $loggedInSchoolStaff->password) === false) {
            return generateErrorApiMessage('Old password supplied is not valid');
        }

        $updateSchooLStaffRecordOptions = [
            'id' => $loggedInSchoolStaff->id,
            'data' => [
                'has_system_generated_password' => false,
                'password' => CipherClient::hash($request->new_password),
            ],
        ];

        $this->updateSchoolStaffAction->execute(
            $updateSchooLStaffRecordOptions
        );

        return generateSuccessApiMessage('Staff password was changed successfully');
    }
}
