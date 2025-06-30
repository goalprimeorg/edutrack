<?php

use App\Http\Controllers\Api\Common\V1\Qualification\FetchQualificationTypesController;
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::get('/fetch/qualification-types', FetchQualificationTypesController::class);
});
