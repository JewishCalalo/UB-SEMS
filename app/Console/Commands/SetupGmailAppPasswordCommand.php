<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetupGmailAppPasswordCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:gmail-app-password';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup Gmail App Password for SMTP';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('📧 Setting up Gmail App Password...');
        $this->info('');
        
        $this->info('Step 1: Enable 2-Factor Authentication');
        $this->line('   • Go to: https://myaccount.google.com/');
        $this->line('   • Navigate to "Security"');
        $this->line('   • Enable "2-Step Verification"');
        $this->info('');
        
        $this->info('Step 2: Generate App Password');
        $this->line('   • Go to: https://myaccount.google.com/apppasswords');
        $this->line('   • Select "Mail" as the app');
        $this->line('   • Select "Other" as the device');
        $this->line('   • Click "Generate"');
        $this->line('   • Copy the 16-character password (e.g., abcd efgh ijkl mnop)');
        $this->info('');
        
        $this->info('Step 3: Update your .env file');
        $this->line('   Replace your current MAIL_PASSWORD with the App Password:');
        $this->info('');
        $this->line('MAIL_MAILER=smtp');
        $this->line('MAIL_HOST=smtp.gmail.com');
        $this->line('MAIL_PORT=587');
        $this->line('MAIL_USERNAME=vawdrac@gmail.com');
        $this->line('MAIL_PASSWORD=your_16_character_app_password_here');
        $this->line('MAIL_ENCRYPTION=tls');
        $this->line('MAIL_FROM_ADDRESS=vawdrac@gmail.com');
        $this->line('MAIL_FROM_NAME="SEMS - University of Baguio"');
        $this->info('');
        
        $this->info('Step 4: Test the configuration');
        $this->line('   php artisan config:clear');
        $this->line('   php artisan test:email vawdrac@gmail.com');
        $this->info('');
        
        $this->info('✅ Benefits:');
        $this->line('   • Secure authentication');
        $this->line('   • No need to change your regular password');
        $this->line('   • Works with Gmail SMTP');
        $this->line('   • Professional email delivery');
    }
}
