<?php

use App\Http\Controllers\Api\Common\V1\Location\FetchLocalGovernmentAreasController;
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::get('/fetch/local-government-areas', FetchLocalGovernmentAreasController::class);
});
