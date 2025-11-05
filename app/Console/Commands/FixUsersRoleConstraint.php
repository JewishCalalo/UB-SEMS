<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class FixUsersRoleConstraint extends Command
{
    protected $signature = 'fix:users-role-constraint';
    protected $description = 'Fix the users table role constraint to allow instructor role';

    public function handle()
    {
        $this->info('Checking users table constraint...');

        try {
            // Check if the users table has the old CHECK constraint
            $constraints = DB::select("SELECT sql FROM sqlite_master WHERE type='table' AND name='users'");
            
            if (empty($constraints)) {
                $this->error('Users table not found!');
                return 1;
            }

            $tableSql = $constraints[0]->sql;
            
            if (strpos($tableSql, 'CHECK ("role" in') !== false) {
                $this->warn('Old CHECK constraint found. Fixing...');
                $this->fixUsersTableConstraint();
                $this->info('✅ Users table constraint fixed successfully!');
            } else {
                $this->info('✅ Users table constraint is already correct.');
            }

            // Test user creation
            $this->info('Testing user creation...');
            $user = \App\Models\User::create([
                'name' => 'test_constraint_fix',
                'email' => 'test_constraint_fix@test.com',
                'password' => \Illuminate\Support\Facades\Hash::make('1'),
                'role' => 'instructor',
                'is_verified' => false,
            ]);
            
            $this->info('✅ Test user created successfully with ID: ' . $user->id);
            $user->delete();
            $this->info('✅ Test user cleaned up.');

            return 0;

        } catch (\Exception $e) {
            $this->error('❌ Error: ' . $e->getMessage());
            return 1;
        }
    }

    private function fixUsersTableConstraint(): void
    {
        // For SQLite, we need to recreate the table to remove the CHECK constraint
        if (DB::getDriverName() === 'sqlite') {
            // Drop temp tables if they exist
            DB::statement('DROP TABLE IF EXISTS users_temp');
            DB::statement('DROP TABLE IF EXISTS users_new');
            
            // Create a temporary table with the correct structure (no CHECK constraint)
            Schema::create('users_new', function ($table) {
                $table->id();
                $table->string('name');
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->string('role')->default('instructor'); // No CHECK constraint
                $table->string('contact_number')->nullable();
                $table->string('department')->nullable();
                $table->boolean('is_verified')->default(false);
                $table->boolean('two_factor_enabled')->default(false);
                $table->text('two_factor_secret')->nullable();
                $table->timestamp('last_activity')->nullable();
                $table->rememberToken();
                $table->timestamps();
            });

            // Copy data from old table to new table
            DB::statement('INSERT INTO users_new SELECT * FROM users');

            // Drop the old table
            Schema::dropIfExists('users');

            // Rename the new table
            Schema::rename('users_new', 'users');
        }
    }
}