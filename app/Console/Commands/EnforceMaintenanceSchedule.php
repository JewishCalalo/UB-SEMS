<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EquipmentInstance;
use App\Models\Equipment;
use App\Services\NotificationService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EnforceMaintenanceSchedule extends Command
{
    protected $signature = 'maintenance:enforce-schedule {--dry-run : Show what would be done without making changes}';
    protected $description = 'Enforce maintenance schedule by deactivating overdue equipment instances';

    public function handle(): int
    {
        $this->info('🔧 Starting maintenance schedule enforcement...');
        
        $dryRun = $this->option('dry-run');
        if ($dryRun) {
            $this->warn('DRY RUN MODE - No changes will be made');
        }

        try {
            DB::beginTransaction();

            // Get all active instances that need maintenance enforcement
            $instancesNeedingEnforcement = EquipmentInstance::with('equipment.category')
                ->where('is_active', true)
                ->whereHas('equipment', function($query) {
                    $query->whereNotNull('maintenance_interval_days')
                          ->where('maintenance_interval_days', '>', 0);
                })
                ->get()
                ->filter(function($instance) {
                    return $instance->needsMaintenance();
                });

            if ($instancesNeedingEnforcement->isEmpty()) {
                $this->info('✅ All equipment instances are up to date with maintenance');
                return Command::SUCCESS;
            }

            $this->info("Found {$instancesNeedingEnforcement->count()} instances needing maintenance enforcement");

            $deactivatedCount = 0;
            $notifiedCount = 0;

            foreach ($instancesNeedingEnforcement as $instance) {
                $this->processInstance($instance, $dryRun, $deactivatedCount, $notifiedCount);
            }

            if (!$dryRun) {
                DB::commit();
                $this->info("✅ Successfully enforced maintenance schedule");
                $this->info("   - Deactivated instances: {$deactivatedCount}");
                $this->info("   - Notifications sent: {$notifiedCount}");
                
                Log::info('Maintenance schedule enforcement completed', [
                    'deactivated_instances' => $deactivatedCount,
                    'notifications_sent' => $notifiedCount
                ]);
            } else {
                DB::rollBack();
                $this->info("📋 DRY RUN SUMMARY:");
                $this->info("   - Would deactivate instances: {$deactivatedCount}");
                $this->info("   - Would send notifications: {$notifiedCount}");
            }

            return Command::SUCCESS;

        } catch (\Exception $e) {
            DB::rollBack();
            $this->error("❌ Error during maintenance enforcement: " . $e->getMessage());
            Log::error('Maintenance enforcement failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return Command::FAILURE;
        }
    }

    private function processInstance(EquipmentInstance $instance, bool $dryRun, int &$deactivatedCount, int &$notifiedCount): void
    {
        $equipment = $instance->equipment;
        $daysOverdue = $this->calculateDaysOverdue($instance);
        
        $this->line("Processing {$equipment->display_name} - Instance {$instance->instance_code}");
        $this->line("  - Last maintenance: " . ($instance->last_maintenance_date ? $instance->last_maintenance_date->format('Y-m-d') : 'Never'));
        $this->line("  - Days overdue: {$daysOverdue}");
        $this->line("  - Current status: " . ($instance->is_available ? 'Available' : 'Unavailable'));

        // Determine enforcement action based on overdue severity
        if ($daysOverdue >= 30) {
            // Severely overdue - deactivate completely
            $this->enforceSevereOverdue($instance, $dryRun, $deactivatedCount);
        } elseif ($daysOverdue >= 7) {
            // Moderately overdue - make unavailable but keep active
            $this->enforceModerateOverdue($instance, $dryRun, $deactivatedCount);
        } else {
            // Slightly overdue - just notify
            $this->enforceSlightOverdue($instance, $dryRun, $notifiedCount);
        }

        // Update equipment counts after instance changes
        if (!$dryRun) {
            $equipment->recalculateCounts();
        }
    }

    private function calculateDaysOverdue(EquipmentInstance $instance): int
    {
        if (!$instance->last_maintenance_date || !$instance->equipment->maintenance_interval_days) {
            return 0;
        }

        $nextMaintenanceDate = $instance->last_maintenance_date->addDays($instance->equipment->maintenance_interval_days);
        return max(0, now()->diffInDays($nextMaintenanceDate));
    }

    private function enforceSevereOverdue(EquipmentInstance $instance, bool $dryRun, int &$deactivatedCount): void
    {
        $this->warn("  🚨 SEVERELY OVERDUE - Deactivating instance");
        
        if (!$dryRun) {
            $instance->update([
                'is_active' => false,
                'is_available' => false,
                'condition' => 'needs_repair'
            ]);
            
            // Create maintenance record
            \App\Models\MaintenanceRecord::create([
                'equipment_id' => $instance->equipment_id,
                'maintenance_type' => 'enforcement_deactivation',
                'maintenance_date' => now(),
                'description' => 'Automatically deactivated due to severe maintenance overdue',
                'performed_by' => 'System', // System action
                'affected_instances' => [
                    [
                        'instance_id' => $instance->id,
                        'instance_code' => $instance->instance_code,
                        'old_condition' => $instance->getOriginal('condition'),
                        'new_condition' => 'needs_repair',
                        'location' => $instance->location ?? 'Not specified',
                        'notes' => 'Automatically deactivated due to severe maintenance overdue'
                    ]
                ]
            ]);
        }
        
        $deactivatedCount++;
    }

    private function enforceModerateOverdue(EquipmentInstance $instance, bool $dryRun, int &$deactivatedCount): void
    {
        $this->warn("  ⚠️ MODERATELY OVERDUE - Making unavailable");
        
        if (!$dryRun) {
            $instance->update([
                'is_available' => false,
                'condition' => 'needs_repair'
            ]);
            
            // Create maintenance record
            \App\Models\MaintenanceRecord::create([
                'equipment_id' => $instance->equipment_id,
                'maintenance_type' => 'enforcement_unavailable',
                'maintenance_date' => now(),
                'description' => 'Automatically made unavailable due to maintenance overdue',
                'performed_by' => 'System', // System action
                'affected_instances' => [
                    [
                        'instance_id' => $instance->id,
                        'instance_code' => $instance->instance_code,
                        'old_condition' => $instance->getOriginal('condition'),
                        'new_condition' => 'needs_repair',
                        'location' => $instance->location ?? 'Not specified',
                        'notes' => 'Automatically made unavailable due to maintenance overdue'
                    ]
                ]
            ]);
        }
        
        $deactivatedCount++;
    }

    private function enforceSlightOverdue(EquipmentInstance $instance, bool $dryRun, int &$notifiedCount): void
    {
        $this->info("  📋 SLIGHTLY OVERDUE - Sending notification");
        
        if (!$dryRun) {
            // Send notification to maintenance staff
            try {
                NotificationService::notifyMaintenanceOverdue($instance);
                $notifiedCount++;
            } catch (\Exception $e) {
                Log::warning('Failed to send maintenance notification', [
                    'instance_id' => $instance->id,
                    'error' => $e->getMessage()
                ]);
            }
        } else {
            $notifiedCount++;
        }
    }
}
