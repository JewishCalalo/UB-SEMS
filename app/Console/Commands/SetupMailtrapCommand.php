<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetupMailtrapCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:mailtrap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup Mailtrap for email testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('📧 Setting up Mailtrap for email testing...');
        $this->info('');
        
        $this->info('Step 1: Create a free Mailtrap account');
        $this->line('   • Go to: https://mailtrap.io/');
        $this->line('   • Sign up for free account');
        $this->line('   • Create a new inbox');
        $this->info('');
        
        $this->info('Step 2: Get your Mailtrap credentials');
        $this->line('   • Go to your inbox settings');
        $this->line('   • Select "SMTP Settings"');
        $this->line('   • Copy the credentials');
        $this->info('');
        
        $this->info('Step 3: Update your .env file with these settings:');
        $this->info('');
        $this->line('MAIL_MAILER=smtp');
        $this->line('MAIL_HOST=sandbox.smtp.mailtrap.io');
        $this->line('MAIL_PORT=2525');
        $this->line('MAIL_USERNAME=your_mailtrap_username');
        $this->line('MAIL_PASSWORD=your_mailtrap_password');
        $this->line('MAIL_ENCRYPTION=tls');
        $this->line('MAIL_FROM_ADDRESS=noreply@sems.ubaguio.edu');
        $this->line('MAIL_FROM_NAME="SEMS - University of Baguio"');
        $this->info('');
        
        $this->info('Step 4: Test the configuration');
        $this->line('   php artisan config:clear');
        $this->line('   php artisan test:email your-email@example.com');
        $this->info('');
        
        $this->info('✅ Benefits of Mailtrap:');
        $this->line('   • Free for development');
        $this->line('   • No email delivery (catches all emails)');
        $this->line('   • Professional email testing');
        $this->line('   • No Google configuration needed');
        $this->line('   • Works immediately');
    }
}
