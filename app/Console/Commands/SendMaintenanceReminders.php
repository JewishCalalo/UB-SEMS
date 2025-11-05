<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EquipmentInstance;
use App\Models\Equipment;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Log;

class SendMaintenanceReminders extends Command
{
    protected $signature = 'maintenance:send-reminders {--days=7 : Days in advance to send reminders}';
    protected $description = 'Send maintenance reminders for equipment approaching maintenance due dates';

    public function handle(): int
    {
        $daysInAdvance = (int) $this->option('days');
        $this->info("🔔 Sending maintenance reminders for equipment due in {$daysInAdvance} days...");

        try {
            // Get instances that will need maintenance soon
            $instancesNeedingReminders = EquipmentInstance::with('equipment.category')
                ->where('is_active', true)
                ->where('is_available', true)
                ->whereHas('equipment', function($query) {
                    $query->whereNotNull('maintenance_interval_days')
                          ->where('maintenance_interval_days', '>', 0);
                })
                ->get()
                ->filter(function($instance) use ($daysInAdvance) {
                    return $this->isMaintenanceDueSoon($instance, $daysInAdvance);
                });

            if ($instancesNeedingReminders->isEmpty()) {
                $this->info('✅ No maintenance reminders needed');
                return Command::SUCCESS;
            }

            $this->info("Found {$instancesNeedingReminders->count()} instances needing maintenance reminders");

            $reminderCount = 0;
            $failedCount = 0;

            foreach ($instancesNeedingReminders as $instance) {
                if ($this->sendReminder($instance)) {
                    $reminderCount++;
                    $this->line("✅ Sent reminder for {$instance->equipment->name} - {$instance->instance_code}");
                } else {
                    $failedCount++;
                    $this->warn("❌ Failed to send reminder for {$instance->equipment->name} - {$instance->instance_code}");
                }
            }

            $this->info("📋 Maintenance reminders completed:");
            $this->info("   - Successful: {$reminderCount}");
            $this->info("   - Failed: {$failedCount}");

            Log::info('Maintenance reminders sent', [
                'successful_reminders' => $reminderCount,
                'failed_reminders' => $failedCount,
                'days_in_advance' => $daysInAdvance
            ]);

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("❌ Error sending maintenance reminders: " . $e->getMessage());
            Log::error('Maintenance reminders failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return Command::FAILURE;
        }
    }

    private function isMaintenanceDueSoon(EquipmentInstance $instance, int $daysInAdvance): bool
    {
        if (!$instance->last_maintenance_date || !$instance->equipment->maintenance_interval_days) {
            return false;
        }

        $nextMaintenanceDate = $instance->last_maintenance_date->addDays($instance->equipment->maintenance_interval_days);
        $daysUntilMaintenance = now()->diffInDays($nextMaintenanceDate, false);

        // Return true if maintenance is due within the specified days
        return $daysUntilMaintenance >= 0 && $daysUntilMaintenance <= $daysInAdvance;
    }

    private function sendReminder(EquipmentInstance $instance): bool
    {
        try {
            NotificationService::notifyMaintenanceDueSoon($instance);
            return true;
        } catch (\Exception $e) {
            Log::warning('Failed to send maintenance reminder', [
                'instance_id' => $instance->id,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
