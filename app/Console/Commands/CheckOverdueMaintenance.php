<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EquipmentInstance;
use App\Models\Equipment;
use App\Models\MaintenanceRecord;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class CheckOverdueMaintenance extends Command
{
    protected $signature = 'maintenance:check-overdue {--format=console : Output format (console, json, csv)}';
    protected $description = 'Check for equipment instances that are overdue for maintenance';

    public function handle(): int
    {
        $this->info('🔍 Checking for overdue maintenance...');

        try {
            $overdueInstances = $this->getOverdueInstances();
            $maintenanceStats = $this->getMaintenanceStats();

            if ($overdueInstances->isEmpty()) {
                $this->info('✅ All equipment instances are up to date with maintenance');
                return Command::SUCCESS;
            }

            $this->displayResults($overdueInstances, $maintenanceStats);

            // Log the results
            Log::info('Maintenance overdue check completed', [
                'overdue_count' => $overdueInstances->count(),
                'total_instances' => $maintenanceStats['total_instances'],
                'overdue_percentage' => round(($overdueInstances->count() / $maintenanceStats['total_instances']) * 100, 2)
            ]);

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("❌ Error checking overdue maintenance: " . $e->getMessage());
            Log::error('Maintenance overdue check failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return Command::FAILURE;
        }
    }

    private function getOverdueInstances()
    {
        return EquipmentInstance::with(['equipment.category', 'maintenanceRecords' => function($query) {
                $query->latest('maintenance_date')->limit(1);
            }])
            ->where('is_active', true)
            ->whereHas('equipment', function($query) {
                $query->whereNotNull('maintenance_interval_days')
                      ->where('maintenance_interval_days', '>', 0);
            })
            ->get()
            ->filter(function($instance) {
                return $instance->needsMaintenance();
            })
            ->sortBy(function($instance) {
                return $this->calculateDaysOverdue($instance);
            });
    }

    private function getMaintenanceStats(): array
    {
        $totalInstances = EquipmentInstance::where('is_active', true)->count();
        $instancesWithMaintenance = EquipmentInstance::where('is_active', true)
            ->whereNotNull('last_maintenance_date')
            ->count();
        $instancesWithoutMaintenance = $totalInstances - $instancesWithMaintenance;

        return [
            'total_instances' => $totalInstances,
            'instances_with_maintenance' => $instancesWithMaintenance,
            'instances_without_maintenance' => $instancesWithoutMaintenance,
            'maintenance_coverage_percentage' => $totalInstances > 0 ? round(($instancesWithMaintenance / $totalInstances) * 100, 2) : 0
        ];
    }

    private function calculateDaysOverdue(EquipmentInstance $instance): int
    {
        if (!$instance->last_maintenance_date || !$instance->equipment->maintenance_interval_days) {
            return 0;
        }

        $nextMaintenanceDate = $instance->last_maintenance_date->addDays($instance->equipment->maintenance_interval_days);
        return max(0, now()->diffInDays($nextMaintenanceDate));
    }

    private function displayResults($overdueInstances, $maintenanceStats): void
    {
        $format = $this->option('format');

        switch ($format) {
            case 'json':
                $this->outputJson($overdueInstances, $maintenanceStats);
                break;
            case 'csv':
                $this->outputCsv($overdueInstances, $maintenanceStats);
                break;
            default:
                $this->outputConsole($overdueInstances, $maintenanceStats);
                break;
        }
    }

    private function outputConsole($overdueInstances, $maintenanceStats): void
    {
        $this->info("\n📊 MAINTENANCE STATISTICS:");
        $this->info("   - Total active instances: {$maintenanceStats['total_instances']}");
        $this->info("   - Instances with maintenance history: {$maintenanceStats['instances_with_maintenance']}");
        $this->info("   - Instances without maintenance history: {$maintenanceStats['instances_without_maintenance']}");
        $this->info("   - Maintenance coverage: {$maintenanceStats['maintenance_coverage_percentage']}%");

        $this->info("\n🚨 OVERDUE MAINTENANCE INSTANCES ({$overdueInstances->count()}):");
        $this->info(str_repeat('-', 80));

        foreach ($overdueInstances as $instance) {
            $daysOverdue = $this->calculateDaysOverdue($instance);
            $lastMaintenance = $instance->last_maintenance_date ? $instance->last_maintenance_date->format('Y-m-d') : 'Never';
            $nextMaintenance = $instance->last_maintenance_date ? 
                $instance->last_maintenance_date->addDays($instance->equipment->maintenance_interval_days)->format('Y-m-d') : 'N/A';

            $this->line("Equipment: {$instance->equipment->name}");
            $this->line("Instance: {$instance->instance_code}");
            $this->line("Category: {$instance->equipment->category->name}");
            $this->line("Last Maintenance: {$lastMaintenance}");
            $this->line("Next Maintenance: {$nextMaintenance}");
            $this->line("Days Overdue: {$daysOverdue}");
            $this->line("Current Status: " . ($instance->is_available ? 'Available' : 'Unavailable'));
            $this->line(str_repeat('-', 40));
        }

        $this->info("\n💡 RECOMMENDATIONS:");
        if ($overdueInstances->count() > 0) {
            $this->warn("   - Run 'php artisan maintenance:enforce-schedule' to automatically deactivate overdue instances");
            $this->warn("   - Run 'php artisan maintenance:send-reminders --days=7' to send proactive reminders");
        }
        if ($maintenanceStats['instances_without_maintenance'] > 0) {
            $this->warn("   - {$maintenanceStats['instances_without_maintenance']} instances have no maintenance history");
        }
    }

    private function outputJson($overdueInstances, $maintenanceStats): void
    {
        $data = [
            'timestamp' => now()->toISOString(),
            'statistics' => $maintenanceStats,
            'overdue_instances' => $overdueInstances->map(function($instance) {
                return [
                    'id' => $instance->id,
                    'instance_code' => $instance->instance_code,
                    'equipment_name' => $instance->equipment->name,
                    'category' => $instance->equipment->category->name,
                    'last_maintenance_date' => $instance->last_maintenance_date?->format('Y-m-d'),
                    'days_overdue' => $this->calculateDaysOverdue($instance),
                    'is_available' => $instance->is_available,
                    'condition' => $instance->condition
                ];
            })
        ];

        $this->output->write(json_encode($data, JSON_PRETTY_PRINT));
    }

    private function outputCsv($overdueInstances, $maintenanceStats): void
    {
        $this->output->write("Instance Code,Equipment Name,Category,Last Maintenance,Days Overdue,Status,Condition\n");
        
        foreach ($overdueInstances as $instance) {
            $daysOverdue = $this->calculateDaysOverdue($instance);
            $lastMaintenance = $instance->last_maintenance_date ? $instance->last_maintenance_date->format('Y-m-d') : 'Never';
            $status = $instance->is_available ? 'Available' : 'Unavailable';
            
            $this->output->write("\"{$instance->instance_code}\",\"{$instance->equipment->name}\",\"{$instance->equipment->category->name}\",\"{$lastMaintenance}\",{$daysOverdue},\"{$status}\",\"{$instance->condition}\"\n");
        }
    }
}
