<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {

        // Admin
        User::updateOrCreate(
            ['email' => 'admin@e.ubaguio.edu'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
                'is_verified' => true,
                'contact_number' => '09123456789',
                'department' => 'IT Department',
            ]
        );

        // Manager
        User::updateOrCreate(
            ['email' => 'manager@e.ubaguio.edu'],
            [
                'name' => 'Manager User',
                'password' => Hash::make('password'),
                'role' => 'manager',
                'email_verified_at' => now(),
                'is_verified' => true,
                'contact_number' => '09876543210',
                'department' => 'Physical Education Office',
            ]
        );

        // Note: Regular users don't need accounts - they can reserve equipment without logging in
        // Only admin and manager users are created here
    }
}
