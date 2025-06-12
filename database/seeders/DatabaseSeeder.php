<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Step 1: Create roles if they don't exist
        $roles = ['admin', 'unit', 'officer'];
        foreach ($roles as $roleName) {
            Role::firstOrCreate(['name' => $roleName]);
        }

        // Step 2: Create the admin user
        $user = User::firstOrCreate(
            ['email' => 'fairmontshippinghk@gmail.com'],
            [
                'name' => 'Admin Fairmont',
                'password' => Hash::make('fairmontshipping'),
            ]
        );

        // Step 3: Assign 'admin' role
        $user->assignRole('admin');
    }
}
