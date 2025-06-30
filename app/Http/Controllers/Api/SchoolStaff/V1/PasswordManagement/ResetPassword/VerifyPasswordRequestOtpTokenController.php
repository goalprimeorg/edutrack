<?php

namespace App\Http\Controllers\Api\SchoolStaff\V1\PasswordManagement\ResetPassword;

use App\Actions\OtpToken\DeleteOtpTokenAction;
use App\Actions\OtpToken\GetOtpTokenAction;
use App\Actions\SchoolStaff\GetSchoolStaffByEmailAction;
use App\Actions\SchoolStaff\UpdateSchoolStaffAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SchoolStaff\V1\PasswordManagement\ResetPassword\VerifyPasswordResetRequest;
use App\InfrastructureProviders\Internal\CipherClient;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VerifyPasswordRequestOtpTokenController extends Controller
{
    public function __construct(
        private GetSchoolStaffByEmailAction $getSchoolStaffByEmailAction,
        private UpdateSchoolStaffAction $updateSchoolStaffAction,
        private GetOtpTokenAction $getOtpTokenAction,
        private DeleteOtpTokenAction $deleteOtpTokenAction
    ) {}

    public function __invoke(VerifyPasswordResetRequest $request)
    {
        $getOtpTokenRecordOptions = [
            'email' => $request->email,
            'purpose' => 'password-reset',
        ];

        $otpToken = $this->getOtpTokenAction->execute(
            $getOtpTokenRecordOptions
        );

        if (is_null($otpToken)) {
            return generateErrorApiMessage('You do not have any password reset token');
        }

        if ($otpToken->token !== $request->token) {
            return generateErrorApiMessage('Otp token supplied is not valid');
        }

        if (Carbon::now()->greaterThan($otpToken->expires_at)) {
            return generateErrorApiMessage('Otp token has expired');
        }

        DB::transaction(function () use ($request) {
            $deleteOtpTokenRecordOptions = [
                'email' => $request->email,
                'purpose' => 'password-reset',
            ];

            $this->deleteOtpTokenAction->execute(
                $deleteOtpTokenRecordOptions
            );

            $schoolStaff = $this->getSchoolStaffByEmailAction->execute($request->email);

            $updateSchoolStaffRecordOptions = [
                'id' => $schoolStaff->id,
                'data' => [
                    'password' => CipherClient::hash($request->new_password),
                ],
            ];

            $this->updateSchoolStaffAction->execute(
                $updateSchoolStaffRecordOptions
            );
        });

        return generateSuccessApiMessage('Staff password was reset successfully');
    }
}
