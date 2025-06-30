<?php

use App\Http\Controllers\Api\Common\V1\Item\FetchItemsController;
use Illuminate\Support\Facades\Route;

Route::group([], function () {
    Route::get('/fetch/items', FetchItemsController::class);
});
