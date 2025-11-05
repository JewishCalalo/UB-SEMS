<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetupResendCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:resend';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup Resend for email delivery';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('📧 Setting up Resend for email delivery...');
        $this->info('');
        
        $this->info('Step 1: Create a free Resend account');
        $this->line('   • Go to: https://resend.com/');
        $this->line('   • Sign up for free account (3,000 emails/month)');
        $this->line('   • Verify your email address');
        $this->info('');
        
        $this->info('Step 2: Get your API Key');
        $this->line('   • Go to API Keys section');
        $this->line('   • Create a new API Key');
        $this->line('   • Copy the API Key');
        $this->info('');
        
        $this->info('Step 3: Update your .env file with these settings:');
        $this->info('');
        $this->line('MAIL_MAILER=resend');
        $this->line('RESEND_API_KEY=your_resend_api_key_here');
        $this->line('MAIL_FROM_ADDRESS=noreply@sems.ubaguio.edu');
        $this->line('MAIL_FROM_NAME="SEMS - University of Baguio"');
        $this->info('');
        
        $this->info('Step 4: Test the configuration');
        $this->line('   php artisan config:clear');
        $this->line('   php artisan test:email your-email@example.com');
        $this->info('');
        
        $this->info('✅ Benefits of Resend:');
        $this->line('   • Free tier: 3,000 emails/month');
        $this->line('   • Modern API-first approach');
        $this->line('   • No Google configuration needed');
        $this->line('   • Excellent deliverability');
        $this->line('   • Developer-friendly');
    }
}
