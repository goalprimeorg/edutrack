<?php

use App\Http\Controllers\Api\SchoolStaff\V1\PasswordManagement\ChangePassword\ChangePasswordController;
use App\Http\Controllers\Api\SchoolStaff\V1\PasswordManagement\ResetPassword\RequestPasswordRequestOtpTokenController;
use App\Http\Controllers\Api\SchoolStaff\V1\PasswordManagement\ResetPassword\VerifyPasswordRequestOtpTokenController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'reset-password',
], function () {
    Route::post('request-otp-token', RequestPasswordRequestOtpTokenController::class);
    Route::post('verify-otp-token', VerifyPasswordRequestOtpTokenController::class);
});

Route::group([
    'prefix' => 'change-password',
    'middleware' => ['auth:school-staff'],
], function () {
    Route::post('/', ChangePasswordController::class);
});
