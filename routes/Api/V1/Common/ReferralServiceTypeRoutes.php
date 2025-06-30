<?php

use App\Http\Controllers\Api\Common\V1\ReferralServiceType\FetchReferralServiceTypesController;
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::get('/fetch/referral-service-types', FetchReferralServiceTypesController::class);
});
