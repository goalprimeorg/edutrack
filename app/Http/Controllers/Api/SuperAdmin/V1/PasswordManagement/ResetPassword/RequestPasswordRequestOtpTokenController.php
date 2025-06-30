<?php

namespace App\Http\Controllers\Api\SuperAdmin\V1\PasswordManagement\ResetPassword;

use App\Actions\OtpToken\CreateOtpTokenAction;
use App\Actions\OtpToken\DeleteOtpTokenAction;
use App\Actions\OtpToken\GetOtpTokenAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\SuperAdmin\V1\PasswordManagement\ResetPassword\RequestPasswordResetRequest;
use App\Jobs\Notifications\PasswordManagement\SendPasswordResetOtpTokenNotificationJob;
use Carbon\Carbon;

class RequestPasswordRequestOtpTokenController extends Controller
{
    public function __construct(
        private GetOtpTokenAction $getOtpTokenAction,
        private CreateOtpTokenAction $createOtpTokenAction,
        private DeleteOtpTokenAction $deleteOtpTokenAction
    ) {}

    public function __invoke(RequestPasswordResetRequest $request)
    {
        $deleteOtpTokenRecordOptions = [
            'email' => $request->email,
            'purpose' => 'password-reset',
        ];

        $this->deleteOtpTokenAction->execute(
            $deleteOtpTokenRecordOptions
        );

        $otpToken = generateRandomNumber(4);

        $tokenExpirationTimestamp = Carbon::now()->addMinutes(10);

        $createOtpTokenRecordOptions = [
            'email' => $request->email,
            'purpose' => 'password-reset',
            'token' => $otpToken,
            'expires_at' => $tokenExpirationTimestamp,
        ];

        $this->createOtpTokenAction->execute(
            $createOtpTokenRecordOptions
        );

        dispatch(
            new SendPasswordResetOtpTokenNotificationJob([
                'email' => $request->email,
                'token' => $otpToken,
                'expires_at' => $tokenExpirationTimestamp,
            ])
        );

        return generateSuccessApiMessage('Super admin requested password reset successfully');
    }
}
