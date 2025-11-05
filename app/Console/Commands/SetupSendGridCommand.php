<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetupSendGridCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup:sendgrid';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup SendGrid for email delivery';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('📧 Setting up SendGrid for email delivery...');
        $this->info('');
        
        $this->info('Step 1: Create a free SendGrid account');
        $this->line('   • Go to: https://sendgrid.com/');
        $this->line('   • Sign up for free account (100 emails/day)');
        $this->line('   • Verify your email address');
        $this->info('');
        
        $this->info('Step 2: Create an API Key');
        $this->line('   • Go to Settings → API Keys');
        $this->line('   • Create a new API Key');
        $this->line('   • Select "Full Access" or "Restricted Access"');
        $this->line('   • Copy the API Key');
        $this->info('');
        
        $this->info('Step 3: Update your .env file with these settings:');
        $this->info('');
        $this->line('MAIL_MAILER=smtp');
        $this->line('MAIL_HOST=smtp.sendgrid.net');
        $this->line('MAIL_PORT=587');
        $this->line('MAIL_USERNAME=apikey');
        $this->line('MAIL_PASSWORD=your_sendgrid_api_key_here');
        $this->line('MAIL_ENCRYPTION=tls');
        $this->line('MAIL_FROM_ADDRESS=noreply@sems.ubaguio.edu');
        $this->line('MAIL_FROM_NAME="SEMS - University of Baguio"');
        $this->info('');
        
        $this->info('Step 4: Test the configuration');
        $this->line('   php artisan config:clear');
        $this->line('   php artisan test:email your-email@example.com');
        $this->info('');
        
        $this->info('✅ Benefits of SendGrid:');
        $this->line('   • Free tier: 100 emails/day');
        $this->line('   • Professional email delivery');
        $this->line('   • No Google configuration needed');
        $this->line('   • High deliverability rates');
        $this->line('   • Email analytics');
    }
}
