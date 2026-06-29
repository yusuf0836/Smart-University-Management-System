<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::firstOrCreate(
            [
                'email' => 'admin@sums.com',
            ],
            [
                'name' => 'Super Admin',
                'phone' => '01700000000',
                'employee_id' => 'EMP001',
                'password' => Hash::make('password'),
                'status' => true,
            ]
        );

        $admin->assignRole('Super Admin');
    }
}