<?php

use App\Http\Controllers\Api\SchoolStaff\V1\Authentication\AuthenticationController;
use Illuminate\Support\Facades\Route;

Route::post('login', AuthenticationController::class);
