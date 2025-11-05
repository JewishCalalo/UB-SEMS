<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class CreateDatabaseBackup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'backup:create {--encrypt : Encrypt the backup file} {--description= : Description for the backup}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new database backup';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $this->info('Starting database backup...');

            $filename = 'backup_' . now()->format('Y-m-d_H-i-s') . '.sql';
            $description = $this->option('description') ?: 'Automated backup';
            $encrypt = $this->option('encrypt');

            // Create backup directory if it doesn't exist
            $backupPath = storage_path('app/backups');
            if (!file_exists($backupPath)) {
                mkdir($backupPath, 0755, true);
            }

            $fullPath = $backupPath . '/' . $filename;

            // Get database configuration
            $connection = config('database.default');
            $config = config("database.connections.{$connection}");

            if ($connection === 'mysql') {
                $this->createMySQLBackup($config, $fullPath);
            } elseif ($connection === 'pgsql') {
                $this->createPostgreSQLBackup($config, $fullPath);
            } else {
                $this->error('Unsupported database type for backup');
                return 1;
            }

            // Encrypt the backup if requested
            if ($encrypt) {
                $this->encryptBackup($fullPath);
                $filename = $filename . '.encrypted';
                $this->info('Backup encrypted successfully');
            }

            // Store backup metadata
            $this->storeBackupMetadata($filename, $description, $encrypt);

            // Clean up old backups based on retention policy
            $this->cleanupOldBackups();

            $this->info('Database backup created successfully: ' . $filename);
            $this->info('Backup size: ' . $this->formatBytes(filesize($fullPath)));

            Log::info('Automated database backup created successfully', [
                'filename' => $filename,
                'size' => filesize($fullPath),
                'encrypted' => $encrypt,
            ]);

            return 0;

        } catch (\Exception $e) {
            $this->error('Backup failed: ' . $e->getMessage());
            
            Log::error('Automated database backup failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);

            return 1;
        }
    }

    /**
     * Create MySQL backup
     */
    private function createMySQLBackup($config, $path)
    {
        $this->info('Creating MySQL backup...');

        $command = [
            'mysqldump',
            '--host=' . $config['host'],
            '--port=' . $config['port'],
            '--user=' . $config['username'],
            '--password=' . $config['password'],
            '--single-transaction',
            '--routines',
            '--triggers',
            $config['database']
        ];

        $process = new Process($command);
        $process->setTimeout(300); // 5 minutes timeout
        
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        file_put_contents($path, $process->getOutput());
        $this->info('MySQL backup completed');
    }

    /**
     * Create PostgreSQL backup
     */
    private function createPostgreSQLBackup($config, $path)
    {
        $this->info('Creating PostgreSQL backup...');

        $command = [
            'pg_dump',
            '--host=' . $config['host'],
            '--port=' . $config['port'],
            '--username=' . $config['username'],
            '--dbname=' . $config['database'],
            '--no-password',
            '--verbose',
            '--format=custom'
        ];

        $process = new Process($command);
        $process->setTimeout(300);
        
        // Set environment variable for password
        $process->setEnv(['PGPASSWORD' => $config['password']]);
        
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        file_put_contents($path, $process->getOutput());
        $this->info('PostgreSQL backup completed');
    }

    /**
     * Encrypt backup file
     */
    private function encryptBackup($path)
    {
        $content = file_get_contents($path);
        $encrypted = Crypt::encryptString($content);
        file_put_contents($path . '.encrypted', $encrypted);
        unlink($path); // Remove original unencrypted file
    }

    /**
     * Store backup metadata
     */
    private function storeBackupMetadata($filename, $description, $encrypted)
    {
        $metadata = [
            'filename' => $filename,
            'description' => $description,
            'encrypted' => $encrypted,
            'size' => filesize(storage_path('app/backups/' . $filename)),
            'created_at' => now()->toISOString(),
            'created_by' => 'system',
            'type' => 'automated',
        ];

        $metadataPath = storage_path('app/backups/metadata.json');
        $existingMetadata = [];
        
        if (file_exists($metadataPath)) {
            $existingMetadata = json_decode(file_get_contents($metadataPath), true) ?? [];
        }

        $existingMetadata[] = $metadata;
        file_put_contents($metadataPath, json_encode($existingMetadata, JSON_PRETTY_PRINT));
    }

    /**
     * Clean up old backups based on retention policy
     */
    private function cleanupOldBackups()
    {
        $retentionDays = config('sems.backup_retention_days', 30);
        $cutoffDate = now()->subDays($retentionDays);
        
        $metadataPath = storage_path('app/backups/metadata.json');
        
        if (!file_exists($metadataPath)) {
            return;
        }

        $existingMetadata = json_decode(file_get_contents($metadataPath), true) ?? [];
        $deletedCount = 0;
        
        foreach ($existingMetadata as $index => $backup) {
            $createdAt = \Carbon\Carbon::parse($backup['created_at']);
            
            if ($createdAt->lt($cutoffDate)) {
                $backupPath = storage_path('app/backups/' . $backup['filename']);
                
                if (file_exists($backupPath)) {
                    unlink($backupPath);
                    $deletedCount++;
                }
                
                // Remove from metadata
                unset($existingMetadata[$index]);
            }
        }
        
        if ($deletedCount > 0) {
            // Reindex array and save
            file_put_contents($metadataPath, json_encode(array_values($existingMetadata), JSON_PRETTY_PRINT));
            
            $this->info("Cleaned up {$deletedCount} old backup files");
            Log::info("Cleaned up {$deletedCount} old backup files");
        }
    }

    /**
     * Format bytes to human readable format
     */
    private function formatBytes($bytes, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
