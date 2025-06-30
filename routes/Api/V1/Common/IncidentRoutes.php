<?php

use App\Http\Controllers\Api\Common\V1\Incident\FetchIncidentTypesController;
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::get('/fetch/incident-types', FetchIncidentTypesController::class);
});
