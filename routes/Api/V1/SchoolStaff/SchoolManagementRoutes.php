<?php

use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Attendance\FetchStudentAttendanceController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Attendance\GetStudentAttendanceController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Attendance\MarkStudentAttendanceController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Classroom\CreateClassroomController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Classroom\DeleteClassroomController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Classroom\FetchClassroomsController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Classroom\GetClassroomController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Classroom\UpdateClassroomController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\IncidentReport\CreateIncidentReportController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\IncidentReport\DeleteIncidentReportController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\IncidentReport\FetchIncidentReportsController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\IncidentReport\GetIncidentReportController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\IncidentReport\UpdateIncidentReportController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Profile\FetchSchoolProfileController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Profile\UpdateSchoolGPSCoordinatesController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Profile\UpdateSchoolProfileController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Referral\CreateReferralController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Referral\DeleteReferralController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Referral\FetchReferralsController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Referral\GetReferralController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Referral\GetStudentByRegistrationNumberController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Referral\UpdateReferralController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Request\CreateRequestController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Request\DeleteRequestController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Request\FetchRequestsController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Request\GetRequestController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Request\UpdateRequestController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Staff\CreateStaffController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Staff\DeleteStaffController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Staff\FetchStaffController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Staff\GetStaffController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Staff\UpdateStaffController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Student\CreateStudentController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Student\DeleteStudentController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Student\FetchStudentsController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Student\GetStudentController;
use App\Http\Controllers\Api\SchoolStaff\V1\SchoolManagement\Student\UpdateStudentController;
use Illuminate\Support\Facades\Route;

Route::group([
    'middleware' => ['auth:school-staff'],
], function () {
    Route::group(['prefix' => 'profile'], function () {
        Route::get('/fetch/school', FetchSchoolProfileController::class);
        Route::put('/update/school', UpdateSchoolProfileController::class);
        Route::put('/update/gps-coordinates', UpdateSchoolGPSCoordinatesController::class);
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

    Route::group(['prefix' => 'incident-report'], function () {
        Route::delete('/delete/incident-report/{incidentReportId}', DeleteIncidentReportController::class);
        Route::put('/update/incident-report/{incidentReportId}', UpdateIncidentReportController::class);
        Route::get('/fetch/incident-report/{incidentReportId}', GetIncidentReportController::class);
        Route::get('/fetch/incident-reports', FetchIncidentReportsController::class);
        Route::post('/create/incident-report', CreateIncidentReportController::class);
    });

    Route::group([
        'prefix' => 'attendance',
    ], function () {
        Route::post('mark/attendance', MarkStudentAttendanceController::class);

        Route::get('fetch/attendance/{studentAttendanceMetaId}', GetStudentAttendanceController::class);
        Route::get('fetch/attendances', FetchStudentAttendanceController::class);

    });

    Route::group([
        'prefix' => 'referral',
    ], function () {
        Route::delete('/delete/referral/{referralId}', DeleteReferralController::class);
        Route::put('/update/referral/{referralId}', UpdateReferralController::class);
        Route::get('/fetch/referral/{referralId}', GetReferralController::class);
        Route::get('/fetch/referrals', FetchReferralsController::class);
        Route::post('/create/referral', CreateReferralController::class);

        Route::get('fetch/student/{registrationNumber}', GetStudentByRegistrationNumberController::class);

    });

    Route::group([
        'prefix' => 'request',
    ], function () {
        Route::delete('/delete/request/{requestId}', DeleteRequestController::class);
        Route::put('/update/request/{requestId}', UpdateRequestController::class);
        Route::get('/fetch/request/{requestId}', GetRequestController::class);
        Route::get('/fetch/requests', FetchRequestsController::class);
        Route::post('/create/request', CreateRequestController::class);
    });
});
