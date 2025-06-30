<?php

namespace App\Http\Controllers\Api\SuperAdmin\V1\PasswordManagement\ChangePassword;

use App\Actions\SuperAdmin\UpdateSuperAdminAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SuperAdmin\V1\PasswordManagement\ChangePassword\ChangePasswordRequest;
use App\InfrastructureProviders\Internal\CipherClient;

class ChangePasswordController extends Controller
{
    public function __construct(
        private UpdateSuperAdminAction $updateSuperAdminAction,
    ) {}

    public function __invoke(ChangePasswordRequest $request)
    {
        $loggedInSuperAdmin = auth('super-admin')->user();

        if (CipherClient::verify($request->old_password, $loggedInSuperAdmin->password) === false) {
            return generateErrorApiMessage('Old password supplied is not valid');
        }

        $updateSuperAdminRecordOptions = [
            'id' => $loggedInSuperAdmin->id,
            'data' => [
                'password' => CipherClient::hash($request->new_password),
            ],
        ];

        $this->updateSuperAdminAction->execute(
            $updateSuperAdminRecordOptions
        );

        return generateSuccessApiMessage('Super admin password was changed successfully');
    }
}
