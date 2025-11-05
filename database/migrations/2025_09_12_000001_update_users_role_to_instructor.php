<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // For SQLite, we need to recreate the table to fix the CHECK constraint
        if (DB::getDriverName() === 'sqlite') {
            // Disable foreign key checks to avoid references to tables not yet created
            DB::statement('PRAGMA foreign_keys = OFF');
            // Create a temporary table with the correct structure
            Schema::create('users_temp', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('first_name')->nullable();
                $table->string('last_name')->nullable();
                $table->string('email')->unique();
                $table->timestamp('email_verified_at')->nullable();
                $table->string('password');
                $table->string('role')->default('instructor'); // Changed from enum to string
                $table->string('contact_number')->nullable();
                $table->string('department')->nullable();
                $table->boolean('is_verified')->default(false);
                $table->boolean('two_factor_enabled')->default(false);
                $table->text('two_factor_secret')->nullable();
                $table->timestamp('last_activity')->nullable();
                $table->rememberToken();
                $table->timestamps();
            });

            // Copy data from old table to new table (specify columns explicitly to avoid mismatch)
            DB::statement('INSERT INTO users_temp (id, name, first_name, last_name, email, email_verified_at, password, role, contact_number, department, is_verified, two_factor_enabled, two_factor_secret, last_activity, remember_token, created_at, updated_at) SELECT id, name, first_name, last_name, email, email_verified_at, password, role, contact_number, department, is_verified, two_factor_enabled, two_factor_secret, last_activity, remember_token, created_at, updated_at FROM users');

            // Drop the old table
            Schema::dropIfExists('users');

            // Rename the new table
            Schema::rename('users_temp', 'users');

            // Re-enable foreign key checks
            DB::statement('PRAGMA foreign_keys = ON');
        } else {
            // For other databases, just update the role values
            DB::table('users')->where('role', 'user')->update(['role' => 'instructor']);
        }
    }

    public function down(): void
    {
        // Revert instructors that were previously users back to 'user'
        DB::table('users')->where('role', 'instructor')->update(['role' => 'user']);
    }
};


