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
use App\Http\Controllers\Api\AcademicSessionController;

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
        Route::prefix('dashboard')->group(function () {

            Route::get('/', [DashboardController::class, 'index'])
                ->middleware('permission:dashboard.view');

        });
        
        Route::middleware([
            'auth:sanctum'
        ])->group(function () {

            Route::apiResource(
                'academic-sessions',
                AcademicSessionController::class
            );

        });

        /**
         * Academic Session Management
         */
        //Route::prefix('academic_session')->group(function () {

         //   Route::get('/', [AcademicSessionController::class, 'index'])
                //->middleware('permission:academic_session.view');

            //Route::post('/', [AcademicSessionController::class, 'store'])
              //  ->middleware('permission:academic_session.create');

            //Route::get('/{academicSession}', [AcademicSessionController::class, 'show'])
              //  ->middleware('permission:academic_session.view');

            //Route::put('/{academicSession}', [AcademicSessionController::class, 'update'])
              //  ->middleware('permission:academic_session.update');

            //Route::delete('/{academicSession}', [AcademicSessionController::class, 'destroy'])
             //   ->middleware('permission:academic_session.delete');
        //});

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

        });

        /**
         * Admin & Teacher
         */
        Route::middleware('role:Admin|Teacher')->group(function () {

        });

        /**
         * Notice Management
         */
        Route::prefix('notices')->group(function () {

            Route::get('/', [NoticeController::class, 'index'])
                ->middleware('permission:notice.view');

            Route::post('/', [NoticeController::class, 'store'])
                ->middleware('permission:notice.create');

            Route::get('/{notice}', [NoticeController::class, 'show'])
                ->middleware('permission:notice.view');

            Route::put('/{notice}', [NoticeController::class, 'update'])
                ->middleware('permission:notice.update');

            Route::delete('/{notice}', [NoticeController::class, 'destroy'])
                ->middleware('permission:notice.delete');
        });

        /**
         * Fee Management
         */
        Route::prefix('fees')->group(function () {

            Route::get('/', [FeeController::class, 'index'])
                ->middleware('permission:fee.view');

            Route::post('/', [FeeController::class, 'store'])
                ->middleware('permission:fee.create');

            Route::get('/{fee}', [FeeController::class, 'show'])
                ->middleware('permission:fee.view');

            Route::put('/{fee}', [FeeController::class, 'update'])
                ->middleware('permission:fee.update');

            Route::delete('/{fee}', [FeeController::class, 'destroy'])
                ->middleware('permission:fee.delete');
        });

        /**
         * Examination Management
         */
        Route::prefix('examinations')->group(function () {

            Route::get('/', [ExaminationController::class, 'index'])
                ->middleware('permission:examination.view');

            Route::post('/', [ExaminationController::class, 'store'])
                ->middleware('permission:examination.create');

            Route::get('/{examination}', [ExaminationController::class, 'show'])
                ->middleware('permission:examination.view');

            Route::put('/{examination}', [ExaminationController::class, 'update'])
                ->middleware('permission:examination.update');

            Route::delete('/{examination}', [ExaminationController::class, 'destroy'])
                ->middleware('permission:examination.delete');
        });

        /**
         * Routine Management
         */
        Route::prefix('routines')->group(function () {

            Route::get('/', [RoutineController::class, 'index'])
                ->middleware('permission:routine.view');

            Route::post('/', [RoutineController::class, 'store'])
                ->middleware('permission:routine.create');

            Route::get('/{routine}', [RoutineController::class, 'show'])
                ->middleware('permission:routine.view');

            Route::put('/{routine}', [RoutineController::class, 'update'])
                ->middleware('permission:routine.update');

            Route::delete('/{routine}', [RoutineController::class, 'destroy'])
                ->middleware('permission:routine.delete');
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


        });

        /**
         * Transcript Management
         */
        Route::prefix('transcripts')->group(function () {

            Route::get('/', [TranscriptController::class, 'index'])
                ->middleware('permission:transcript.view');

            Route::post('/generate', [TranscriptController::class, 'generate'])
                ->middleware('permission:transcript.generate');

            Route::get('/{transcript}', [TranscriptController::class, 'show'])
                ->middleware('permission:transcript.view');

            Route::get('/{transcript}/pdf', [TranscriptController::class, 'downloadPdf'])
                ->middleware('permission:transcript.download');

            Route::delete('/{transcript}', [TranscriptController::class, 'destroy'])
                ->middleware('permission:transcript.delete');
        });

    });

});