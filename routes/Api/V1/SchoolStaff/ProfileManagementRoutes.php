<?php

use App\Http\Controllers\Api\SchoolStaff\V1\ProfileManagement\FetchProfileController;
use App\Http\Controllers\Api\SchoolStaff\V1\ProfileManagement\UpdateProfileController;
use App\Http\Controllers\Api\SchoolStaff\V1\ProfileManagement\UploadProfilePhotoController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['auth:school-staff'],
], function () {
    Route::post('/upload/profile-photo', UploadProfilePhotoController::class);
    Route::put('/update/profile', UpdateProfileController::class);
    Route::get('/fetch/profile', FetchProfileController::class);
});
