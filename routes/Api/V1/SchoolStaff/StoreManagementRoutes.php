<?php

use App\Http\Controllers\Api\SchoolStaff\V1\StoreManagement\StoreItem\DeductStoreItemController;
use App\Http\Controllers\Api\SchoolStaff\V1\StoreManagement\StoreItem\FetchStoreItemsController;
use App\Http\Controllers\Api\SchoolStaff\V1\StoreManagement\StoreItemLog\FetchStoreItemLogsController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['auth:school-staff'],
], function () {
    Route::get('/fetch/items', FetchStoreItemsController::class);
    Route::post('/deduct/item', DeductStoreItemController::class);
    
    Route::get('/fetch/logs', FetchStoreItemLogsController::class);
});
