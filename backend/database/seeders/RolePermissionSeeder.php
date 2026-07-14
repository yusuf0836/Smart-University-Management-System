<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'Super Admin']);
        Role::firstOrCreate(['name' => 'Admin']);
        Role::firstOrCreate(['name' => 'Teacher']);
        Role::firstOrCreate(['name' => 'Student']);
        Role::firstOrCreate(['name' => 'Accountant']);
        Role::firstOrCreate(['name' => 'Librarian']);
        app()[PermissionRegistrar::class]->forgetCachedPermissions();
        /*
            * Create roles
        */
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $teacher = Role::firstOrCreate(['name' => 'Teacher']);
        $student = Role::firstOrCreate(['name' => 'Student']);
        $accountant = Role::firstOrCreate(['name' => 'Accountant']);
        $librarian = Role::firstOrCreate(['name' => 'Librarian']);

        /*
            * Assign all permissions to Super Admin
        */
        $superAdmin->syncPermissions(Permission::all());

        $admin->syncPermissions(Permission::all());

        /*
            * Assign specific permissions to Teacher
        */
        $teacher->syncPermissions([
            'student.view',

            'attendance.view',
            'attendance.create',
            'attendance.update',

            'result.view',
            'result.create',
            'result.update',

            'routine.view',

            'transcript.view',
            'transcript.generate',

            'dashboard.view',
            'department.view',
            'course.view',
        ]);

        /*
            * Assign specific permissions to Student
        */
        $student->syncPermissions([
            'transcript.view',
            'dashboard.view',
        ]);

        /*
            * Assign specific permissions to Accountant
        */
        $accountant->syncPermissions([
            'fee.view',
            'fee.create',
            'fee.update',
            'fee.delete',

            'dashboard.view',
        ]);

        /*
            * Assign specific permissions to Librarian
        */
        $librarian->syncPermissions([
            'dashboard.view',
        ]);
    }
}