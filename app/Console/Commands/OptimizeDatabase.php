<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class OptimizeDatabase extends Command
{
    protected $signature = 'db:optimize {--analyze : Analyze tables for better query planning}';
    protected $description = 'Optimize database tables for better performance';

    public function handle(): int
    {
        $this->info('🔧 Starting database optimization...');
        
        $analyze = $this->option('analyze');
        $driver = DB::getDriverName();
        
        try {
            $tables = $this->getTablesToOptimize();
            
            foreach ($tables as $table) {
                $this->line("Optimizing table: {$table}");
                
                if ($driver === 'sqlite') {
                    // SQLite optimization
                    DB::statement("VACUUM");
                    DB::statement("ANALYZE");
                } elseif ($driver === 'mysql') {
                    // MySQL optimization
                    DB::statement("OPTIMIZE TABLE {$table}");
                    
                    if ($analyze) {
                        $this->line("Analyzing table: {$table}");
                        DB::statement("ANALYZE TABLE {$table}");
                    }
                } elseif ($driver === 'pgsql') {
                    // PostgreSQL optimization
                    DB::statement("VACUUM ANALYZE {$table}");
                }
            }
            
            // Clear query cache for MySQL
            if ($driver === 'mysql') {
                $this->line('Clearing query cache...');
                DB::statement('FLUSH QUERY CACHE');
            }
            
            $this->info('✅ Database optimization completed successfully');
            return Command::SUCCESS;
            
        } catch (\Exception $e) {
            $this->error("❌ Database optimization failed: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
    
    private function getTablesToOptimize(): array
    {
        return [
            'equipment',
            'equipment_instances',
            'reservations',
            'reservation_items',
            'maintenance_records',
            'users',
            'equipment_categories',
            'equipment_types',
            'equipment_images',
            'wishlists',
            'return_logs',
            'instance_retirements'
        ];
    }
}
