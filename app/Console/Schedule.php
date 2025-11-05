<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel;

class ConsoleSchedule extends Kernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Database backup schedule
        if (config('sems.auto_backup_enabled', true)) {
            $backupTime = config('sems.backup_time', '02:00');
            $schedule->command('backup:create --encrypt')
                ->daily()
                ->at($backupTime)
                ->withoutOverlapping()
                ->runInBackground()
                ->onSuccess(function () {
                    \Log::info('Scheduled database backup completed successfully');
                })
                ->onFailure(function () {
                    \Log::error('Scheduled database backup failed');
                });
        }

        // Clean up old notifications
        $schedule->command('notifications:cleanup')
            ->daily()
            ->at('03:00')
            ->withoutOverlapping()
            ->runInBackground();

        // Clean up old activity logs
        $schedule->command('logs:cleanup')
            ->weekly()
            ->sundays()
            ->at('04:00')
            ->withoutOverlapping()
            ->runInBackground();

        // Check for overdue maintenance
        $schedule->command('maintenance:check-overdue')
            ->daily()
            ->at('09:00')
            ->withoutOverlapping()
            ->runInBackground();

        // Send maintenance reminders
        $schedule->command('maintenance:send-reminders')
            ->daily()
            ->at('10:00')
            ->withoutOverlapping()
            ->runInBackground();

        // Enforce maintenance schedule (deactivate overdue instances)
        $schedule->command('maintenance:enforce-schedule')
            ->daily()
            ->at('11:00')
            ->withoutOverlapping()
            ->runInBackground();

        // Note: Expired reservations are now handled in real-time via ReservationExpirationService
        // The scheduled command is kept as a backup but runs less frequently
        $schedule->command('reservations:mark-expired')
            ->hourly()
            ->withoutOverlapping()
            ->runInBackground();

        // Check for overdue reservations
        $schedule->command('reservations:mark-overdue')
            ->daily()
            ->at('08:00')
            ->withoutOverlapping()
            ->runInBackground();

        // Send overdue reminders
        $schedule->command('reservations:send-overdue-reminders')
            ->daily()
            ->at('14:00')
            ->withoutOverlapping()
            ->runInBackground();


        // Generate daily reports
        $schedule->command('reports:generate-daily')
            ->daily()
            ->at('23:00')
            ->withoutOverlapping()
            ->runInBackground();

        // Optimize database tables (weekly)
        $schedule->command('db:optimize')
            ->weekly()
            ->sundays()
            ->at('05:00')
            ->withoutOverlapping()
            ->runInBackground();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
