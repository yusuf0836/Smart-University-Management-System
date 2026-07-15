<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::where('name', 'Super Admin')
            ->where('guard_name', 'web')
            ->first();

        $user = User::updateOrCreate(
            [
                'email' => 'admin@sums.com',
            ],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
            ]
        );

        $user->syncRoles([$role]);
    }
}