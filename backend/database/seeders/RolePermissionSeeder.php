<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        /*
        |--------------------------------------------------------------------------
        | Create Roles
        |--------------------------------------------------------------------------
        */

        $superAdmin = Role::firstOrCreate([
            'name' => 'Super Admin',
            'guard_name' => 'web',
        ]);

        $admin = Role::firstOrCreate([
            'name' => 'Admin',
            'guard_name' => 'web',
        ]);

        $teacher = Role::firstOrCreate([
            'name' => 'Teacher',
            'guard_name' => 'web',
        ]);

        $student = Role::firstOrCreate([
            'name' => 'Student',
            'guard_name' => 'web',
        ]);

        $accountant = Role::firstOrCreate([
            'name' => 'Accountant',
            'guard_name' => 'web',
        ]);

        $librarian = Role::firstOrCreate([
            'name' => 'Librarian',
            'guard_name' => 'web',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Super Admin
        |--------------------------------------------------------------------------
        */

        $superAdmin->syncPermissions(Permission::all());

        /*
        |--------------------------------------------------------------------------
        | Admin
        |--------------------------------------------------------------------------
        */

        $admin->syncPermissions(Permission::all());

        /*
        |--------------------------------------------------------------------------
        | Teacher
        |--------------------------------------------------------------------------
        */

        $teacher->syncPermissions([

            'dashboard.view',

            'faculty.view',
            'department.view',
            'teacher.view',

            'academic_session.view',
            'academic_session.update',

            'semester.view',

            'course.view',

            'student.view',

            'enrollment.view',

            'attendance.view',
            'attendance.create',
            'attendance.update',

            'result.view',
            'result.create',
            'result.update',

            'routine.view',

            'notice.view',

            'transcript.view',
            'transcript.generate',
            'transcript.download',

            'examination.view',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Student
        |--------------------------------------------------------------------------
        */

        $student->syncPermissions([

            'dashboard.view',

            'notice.view',

            'routine.view',

            'transcript.view',

            'transcript.download',
            'semester.view'

        ]);

        /*
        |--------------------------------------------------------------------------
        | Accountant
        |--------------------------------------------------------------------------
        */

        $accountant->syncPermissions([

            'dashboard.view',

            'notice.view',

            'fee.view',
            'fee.create',
            'fee.update',
            'fee.delete',

        ]);

        /*
        |--------------------------------------------------------------------------
        | Librarian
        |--------------------------------------------------------------------------
        */

        $librarian->syncPermissions([

            'dashboard.view',

            'notice.view',

        ]);

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}