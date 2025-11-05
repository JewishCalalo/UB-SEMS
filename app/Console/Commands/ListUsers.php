<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class ListUsers extends Command
{
    protected $signature = 'users:list';
    protected $description = 'List all users in the database';

    public function handle()
    {
        $users = User::all(['name', 'email', 'role', 'is_verified']);
        
        $this->info('Available Users:');
        $this->info('================');
        
        foreach ($users as $user) {
            $status = $user->is_verified ? '✓ Verified' : '✗ Not Verified';
            $this->line(sprintf(
                '%-20s %-25s %-10s %s',
                $user->name,
                $user->email,
                $user->role,
                $status
            ));
        }
        
        $this->info('');
        $this->info('Default Login Credentials:');
        $this->info('========================');
        $this->info('Admin:   admin@ubaguio.edu / password');
        $this->info('Manager: manager@ubaguio.edu / password');
        $this->info('Student: student@ubaguio.edu / password');
        
        return 0;
    }
}
