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
use App\Http\Controllers\Api\DashboardController;

Route::prefix('v1')->group(function () {

    /**
     * Public Routes
     */
    Route::post('/login', [AuthController::class, 'login']);

    /**
     * Protected Routes
     */
    Route::middleware('auth:sanctum')->group(function () {

        /**
         * Authentication
         */
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    
        /**
         * Dashboard
         */
        Route::get('/dashboard', [DashboardController::class, 'index']);

        /**
         * Student Management
         */
        Route::prefix('students')->group(function () {

            Route::get('/', [StudentController::class, 'index'])
                ->middleware('permission:student.view');

            Route::post('/', [StudentController::class, 'store'])
                ->middleware('permission:student.create');

            Route::get('/{student}', [StudentController::class, 'show'])
                ->middleware('permission:student.view');

            Route::put('/{student}', [StudentController::class, 'update'])
                ->middleware('permission:student.update');

            Route::delete('/{student}', [StudentController::class, 'destroy'])
                ->middleware('permission:student.delete');
        });

        /**
         * Admin Only
         */
        Route::middleware('role:Admin')->group(function () {
            Route::apiResource('fees', FeeController::class);
            Route::apiResource('notices', NoticeController::class);

        });

        /**
         * Admin & Teacher
         */
        Route::middleware('role:Admin|Teacher')->group(function () {
            Route::apiResource('attendances', AttendanceController::class);
            Route::apiResource('routines', RoutineController::class);
            Route::apiResource('examinations', ExaminationController::class);

        });

        /**
         * Attendance Management
         */
        Route::prefix('attendances')->group(function () {

            Route::get('/', [AttendanceController::class, 'index'])
                ->middleware('permission:attendance.view');

            Route::post('/', [AttendanceController::class, 'store'])
                ->middleware('permission:attendance.create');

            Route::get('/{attendance}', [AttendanceController::class, 'show'])
                ->middleware('permission:attendance.view');

            Route::put('/{attendance}', [AttendanceController::class, 'update'])
                ->middleware('permission:attendance.update');

            Route::delete('/{attendance}', [AttendanceController::class, 'destroy'])
                ->middleware('permission:attendance.delete');
        });

        /**
         * Result Management
         */
        Route::prefix('results')->group(function () {

            Route::get('/', [ResultController::class, 'index'])
                ->middleware('permission:result.view');

            Route::post('/', [ResultController::class, 'store'])
                ->middleware('permission:result.create');

            Route::get('/{result}', [ResultController::class, 'show'])
                ->middleware('permission:result.view');

            Route::put('/{result}', [ResultController::class, 'update'])
                ->middleware('permission:result.update');

            Route::delete('/{result}', [ResultController::class, 'destroy'])
                ->middleware('permission:result.delete');
        });

        /**
         * Enrollment Management
         */
        Route::prefix('enrollments')->group(function () {

            Route::get('/', [EnrollmentController::class, 'index'])
                ->middleware('permission:enrollment.view');

            Route::post('/', [EnrollmentController::class, 'store'])
                ->middleware('permission:enrollment.create');

            Route::get('/{enrollment}', [EnrollmentController::class, 'show'])
                ->middleware('permission:enrollment.view');

            Route::put('/{enrollment}', [EnrollmentController::class, 'update'])
                ->middleware('permission:enrollment.update');

            Route::delete('/{enrollment}', [EnrollmentController::class, 'destroy'])
                ->middleware('permission:enrollment.delete');
        });

        /**
         * Course Management
         */
        Route::prefix('courses')->group(function () {

            Route::get('/', [CourseController::class, 'index'])
                ->middleware('permission:course.view');

            Route::post('/', [CourseController::class, 'store'])
                ->middleware('permission:course.create');

            Route::get('/{course}', [CourseController::class, 'show'])
                ->middleware('permission:course.view');

            Route::put('/{course}', [CourseController::class, 'update'])
                ->middleware('permission:course.update');

            Route::delete('/{course}', [CourseController::class, 'destroy'])
                ->middleware('permission:course.delete');
        });

        /**
         * Semester Management
         */
        Route::prefix('semesters')->group(function () {

            Route::get('/', [SemesterController::class, 'index'])
                ->middleware('permission:semester.view');

            Route::post('/', [SemesterController::class, 'store'])
                ->middleware('permission:semester.create');

            Route::get('/{semester}', [SemesterController::class, 'show'])
                ->middleware('permission:semester.view');

            Route::put('/{semester}', [SemesterController::class, 'update'])
                ->middleware('permission:semester.update');

            Route::delete('/{semester}', [SemesterController::class, 'destroy'])
                ->middleware('permission:semester.delete');
        });

        /**
         * Faculty Management
         */
        Route::prefix('faculties')->group(function () {

            Route::get('/', [FacultyController::class, 'index'])
                ->middleware('permission:faculty.view');

            Route::post('/', [FacultyController::class, 'store'])
                ->middleware('permission:faculty.create');

            Route::get('/{faculty}', [FacultyController::class, 'show'])
                ->middleware('permission:faculty.view');

            Route::put('/{faculty}', [FacultyController::class, 'update'])
                ->middleware('permission:faculty.update');

            Route::delete('/{faculty}', [FacultyController::class, 'destroy'])
                ->middleware('permission:faculty.delete');
        });

        /**
         * Teacher
         */
        Route::prefix('teachers')->group(function () {

            Route::get('/', [TeacherController::class, 'index'])
                ->middleware('permission:teacher.view');

            Route::post('/', [TeacherController::class, 'store'])
                ->middleware('permission:teacher.create');

            Route::get('/{teacher}', [TeacherController::class, 'show'])
                ->middleware('permission:teacher.view');

            Route::put('/{teacher}', [TeacherController::class, 'update'])
                ->middleware('permission:teacher.update');

            Route::delete('/{teacher}', [TeacherController::class, 'destroy'])
                ->middleware('permission:teacher.delete');
        });

        /**
         * Department Management
         */
        Route::prefix('departments')->group(function () {

            Route::get('/', [DepartmentController::class, 'index'])
                ->middleware('permission:department.view');

            Route::post('/', [DepartmentController::class, 'store'])
                ->middleware('permission:department.create');

            Route::get('/{department}', [DepartmentController::class, 'show'])
                ->middleware('permission:department.view');

            Route::put('/{department}', [DepartmentController::class, 'update'])
                ->middleware('permission:department.update');

            Route::delete('/{department}', [DepartmentController::class, 'destroy'])
                ->middleware('permission:department.delete');
        });

        /**
         * Transcript
         * Accessible by Admin, Teacher & Student
         */
        Route::middleware('role:Admin|Teacher|Student')->group(function () {

            Route::get('transcripts', [TranscriptController::class, 'index']);
            Route::post('transcripts/generate', [TranscriptController::class, 'generate']);
            Route::get('transcripts/{transcript}', [TranscriptController::class, 'show']);
            Route::get('transcripts/{transcript}/pdf', [TranscriptController::class, 'downloadPdf']);
            Route::delete('transcripts/{transcript}', [TranscriptController::class, 'destroy']);

        });

    });

});