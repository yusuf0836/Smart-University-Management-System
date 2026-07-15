<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        $modules = [

            'dashboard' => [
                'view',
            ],

            'academic_session' => [
                'view',
                'create',
                'update',
                'delete',
            ],

            'faculty' => [
                'view',
                'create',
                'update',
                'delete',
            ],

            'department' => [
                'view',
                'create',
                'update',
                'delete',
            ],

            'teacher' => [
                'view',
                'create',
                'update',
                'delete',
            ],

            'student' => [
                'view',
                'create',
                'update',
                'delete',
            ],

            'semester' => [
                'view',
                'create',
                'update',
                'delete',
            ],

            'course' => [
                'view',
                'create',
                'update',
                'delete',
            ],

            'enrollment' => [
                'view',
                'create',
                'update',
                'delete',
            ],

            'attendance' => [
                'view',
                'create',
                'update',
                'delete',
            ],

            'result' => [
                'view',
                'create',
                'update',
                'delete',
            ],

            'routine' => [
                'view',
                'create',
                'update',
                'delete',
            ],

            'notice' => [
                'view',
                'create',
                'update',
                'delete',
            ],

            'fee' => [
                'view',
                'create',
                'update',
                'delete',
            ],

            'examination' => [
                'view',
                'create',
                'update',
                'delete',
            ],

            'transcript' => [
                'view',
                'generate',
                'download',
                'delete',
            ],

        ];

        foreach ($modules as $module => $actions) {

            foreach ($actions as $action) {

                Permission::firstOrCreate([
                    'name' => "{$module}.{$action}",
                    'guard_name' => 'web',
                ]);

            }

        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}