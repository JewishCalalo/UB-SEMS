<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SwitchToMailtrapCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'mail:switch-to-mailtrap';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Switch to Mailtrap configuration for testing';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Switching to Mailtrap configuration...');
        $this->info('');
        
        $this->info('📝 Please update your .env file with these settings:');
        $this->info('');
        $this->line('🔴 REMOVE or COMMENT OUT these lines:');
        $this->line('MAIL_MAILER=resend');
        $this->line('RESEND_API_KEY=re_N9ko9VAD_KFhfj8cjmWDfKyS4KaecRgWm');
        $this->info('');
        
        $this->line('🟢 ADD these lines:');
        $this->line('MAIL_MAILER=smtp');
        $this->line('MAIL_HOST=sandbox.smtp.mailtrap.io');
        $this->line('MAIL_PORT=2525');
        $this->line('MAIL_USERNAME=your_mailtrap_username');
        $this->line('MAIL_PASSWORD=your_mailtrap_password');
        $this->line('MAIL_ENCRYPTION=tls');
        $this->line('MAIL_FROM_ADDRESS=noreply@sems.ubaguio.edu');
        $this->line('MAIL_FROM_NAME="SEMS - University of Baguio"');
        $this->info('');
        
        $this->info('💡 To get Mailtrap credentials:');
        $this->line('   1. Go to https://mailtrap.io/');
        $this->line('   2. Create free account');
        $this->line('   3. Create new inbox');
        $this->line('   4. Go to inbox settings → SMTP Settings');
        $this->line('   5. Copy username and password');
        $this->info('');
        
        $this->info('✅ After updating .env file:');
        $this->line('   1. Save the file');
        $this->line('   2. Run: php artisan config:clear');
        $this->line('   3. Test: php artisan test:email 20214200@s.ubaguio.edu');
        $this->info('');
        
        $this->info('🎯 Mailtrap advantages:');
        $this->line('   ✅ No SSL certificate issues');
        $this->line('   ✅ Works immediately');
        $this->line('   ✅ Free for testing');
        $this->line('   ✅ Emails are caught in inbox (no spam)');
    }
}
