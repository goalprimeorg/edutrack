<?php

use Illuminate\Support\Facades\Route;

Route::prefix('authentication')->group(__DIR__.'/AuthenticationRoutes.php');
Route::prefix('password-management')->group(__DIR__.'/PasswordManagementRoutes.php');
Route::prefix('school-management')->group(__DIR__.'/SchoolManagementRoutes.php');
