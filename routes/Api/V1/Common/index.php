<?php

use Illuminate\Support\Facades\Route;

Route::prefix('locations')->group(__DIR__.'/LocationRoutes.php');
Route::prefix('incidents')->group(__DIR__.'/IncidentRoutes.php');
Route::prefix('qualifications')->group(__DIR__.'/QualificationRoutes.php');
Route::prefix('items')->group(__DIR__.'/ItemRoutes.php');
Route::prefix('referrals')->group(__DIR__.'/ReferralServiceTypeRoutes.php');
