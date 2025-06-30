<?php

use App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Classroom\CreateClassroomController;
use App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Classroom\DeleteClassroomController;
use App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Classroom\FetchClassroomsController;
use App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Classroom\GetClassroomController;
use App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Classroom\UpdateClassroomController;
use App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Profile\CreateNewSchoolController;
use App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Profile\FetchSchoolsController;
use App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Staff\CreateStaffController;
use App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Staff\DeleteStaffController;
use App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Staff\FetchStaffController;
use App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Staff\GetStaffController;
use App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Staff\UpdateStaffController;
use App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Student\CreateStudentController;
use App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Student\DeleteStudentController;
use App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Student\FetchStudentsController;
use App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Student\GetStudentController;
use App\Http\Controllers\Api\SuperAdmin\V1\SchoolManagement\Student\UpdateStudentController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['auth:super-admin'],
], function () {
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/fetch/schools', FetchSchoolsController::class);
        Route::post('/create/school', CreateNewSchoolController::class);
    });

    Route::group(['prefix' => 'classroom'], function () {
        Route::delete('/delete/classroom/{classroomId}', DeleteClassroomController::class);
        Route::put('/update/classroom/{classroomId}', UpdateClassroomController::class);
        Route::get('/fetch/classroom/{classroomId}', GetClassroomController::class);
        Route::get('/fetch/classrooms', FetchClassroomsController::class);

        Route::post('/create/classroom', CreateClassroomController::class);
    });

    Route::group(['prefix' => 'student'], function () {
        Route::delete('/delete/student/{studentId}', DeleteStudentController::class);
        Route::put('/update/student/{studentId}', UpdateStudentController::class);
        Route::get('/fetch/student/{studentId}', GetStudentController::class);
        Route::get('/fetch/students', FetchStudentsController::class);

        Route::post('/create/student', CreateStudentController::class);
    });

    Route::group(['prefix' => 'staff'], function () {
        Route::delete('/delete/staff/{staffId}', DeleteStaffController::class);
        Route::put('/update/staff/{staffId}', UpdateStaffController::class);
        Route::get('/fetch/staff/{staffId}', GetStaffController::class);
        Route::get('/fetch/staff', FetchStaffController::class);
        Route::post('/create/staff', CreateStaffController::class);
    });
});
