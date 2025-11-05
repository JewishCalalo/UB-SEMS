<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SwitchEmailDriverCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:switch {driver}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Switch email driver (log, smtp, sendgrid, resend)';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $driver = $this->argument('driver');
        
        $this->info("Switching email driver to: {$driver}");
        
        switch ($driver) {
            case 'log':
                $this->info('✅ Using LOG driver - emails will be saved to logs only');
                $this->info('📧 Check logs: php artisan logs:password-reset');
                break;
                
            case 'smtp':
                $this->info('✅ Using SMTP driver - emails will be sent via SMTP');
                $this->info('⚠️  Make sure your .env file has correct SMTP settings');
                break;
                
            case 'sendgrid':
                $this->info('✅ Using SendGrid driver - emails will be sent via SendGrid');
                $this->info('📧 Run: php artisan setup:sendgrid for setup instructions');
                break;
                
            case 'resend':
                $this->info('✅ Using Resend driver - emails will be sent via Resend');
                $this->info('📧 Run: php artisan setup:resend for setup instructions');
                break;
                
            default:
                $this->error("❌ Unknown driver: {$driver}");
                $this->info('Available drivers: log, smtp, sendgrid, resend');
                return;
        }
        
        // Update the configuration
        config(['mail.default' => $driver]);
        
        $this->info('');
        $this->info('📧 Test the configuration:');
        $this->line("   php artisan test:email your-email@example.com");
        $this->line("   php artisan test:password-reset 20214200@s.ubaguio.edu");
    }
}
