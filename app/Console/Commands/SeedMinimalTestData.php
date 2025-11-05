<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Database\Seeders\MinimalTestDataSeeder;

class SeedMinimalTestData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'seed:minimal-test-data {--fresh : Run fresh migrations before seeding}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seed the database with minimal test data for SEMS application';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🌱 Starting minimal test data seeding...');

        if ($this->option('fresh')) {
            $this->info('🔄 Running fresh migrations...');
            $this->call('migrate:fresh');
        }

        $this->info('📊 Seeding users, equipment categories, types, and equipment...');
        
        $seeder = new MinimalTestDataSeeder();
        $seeder->run();

        $this->info('✅ Minimal test data seeded successfully!');
        $this->line('');
        $this->info('📋 Test Data Summary:');
        $this->line('   • 3 Users (1 Admin, 2 Managers)');
        $this->line('   • 5 Equipment Categories');
        $this->line('   • 15 Equipment Types');
        $this->line('   • 6 Equipment Items with Instances');
        $this->line('');
        $this->info('🔑 Login Credentials:');
        $this->line('   Admin: 20214200@s.ubaguio.edu / password');
        $this->line('   Manager: 99999999@e.ubaguio.edu / password');
        $this->line('   Sports Manager: 88888888@e.ubaguio.edu / password');
    }
}
