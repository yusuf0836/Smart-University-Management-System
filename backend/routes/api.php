<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\FacultyController;
use App\Http\Controllers\Api\DepartmentController;
use App\Http\Controllers\Api\TeacherController;
use App\Http\Controllers\Api\StudentController;
use App\Http\Controllers\Api\SemesterController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\Api\EnrollmentController;
use App\Http\Controllers\Api\ResultController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\NoticeController;
use App\Http\Controllers\Api\RoutineController;
use App\Http\Controllers\Api\FeeController;
use App\Http\Controllers\Api\ExaminationController;
use App\Http\Controllers\Api\TranscriptController;

Route::prefix('v1')->group(function () {

    Route::post('/login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {

        Route::post('/logout', [AuthController::class, 'logout']);

        Route::get('/me', [AuthController::class, 'me']);
        Route::apiResource('faculties', FacultyController::class);
        Route::apiResource('departments', DepartmentController::class);
        Route::apiResource('teachers', TeacherController::class);
        Route::apiResource('students', StudentController::class);
        Route::apiResource('semesters', SemesterController::class);
        Route::apiResource('courses', CourseController::class);
        Route::apiResource('enrollments', EnrollmentController::class);
        Route::apiResource('results', ResultController::class);
        Route::apiResource('attendances', AttendanceController::class);
        Route::apiResource('notices', NoticeController::class);
        Route::apiResource('routines', RoutineController::class);
        Route::apiResource('fees', FeeController::class);
        Route::apiResource('examinations', ExaminationController::class);
        
        /**
         * Transcript Routes
         */
        Route::get('transcripts', [TranscriptController::class, 'index']);
        Route::post('transcripts/generate', [TranscriptController::class, 'generate']);
        Route::get('transcripts/{transcript}', [TranscriptController::class, 'show']);
        Route::get('transcripts/{transcript}/pdf', [TranscriptController::class, 'downloadPdf']);
        Route::delete('transcripts/{transcript}', [TranscriptController::class, 'destroy']);

    });

});