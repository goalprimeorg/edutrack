<?php

use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::prefix('/super-admin')->group(__DIR__.'/SuperAdmin/index.php');
    Route::prefix('/school-staff')->group(__DIR__.'/SchoolStaff/index.php');
    Route::prefix('/common')->group(__DIR__.'/Common/index.php');
});
