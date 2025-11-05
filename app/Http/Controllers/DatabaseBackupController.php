<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

class DatabaseBackupController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->middleware('can:admin');
    }

    /**
     * Display backup download page
     */
    public function index()
    {
        return view('admin.database-backup.index');
    }

    /**
     * Create a database backup and save to server storage
     */
    public function createBackup(Request $request)
    {
        try {
            $request->validate([
                'custom_filename' => 'nullable|string|max:255|regex:/^[a-zA-Z0-9_-]+$/',
                'description' => 'nullable|string|max:255',
                'encrypt' => 'boolean',
            ]);

            // Use custom filename if provided, otherwise generate automatic one
            $customFilename = $request->input('custom_filename');
            if ($customFilename) {
                $filename = $customFilename . '.sql';
            } else {
                $filename = 'sems_backup_' . now()->format('Y-m-d_H-i-s') . '.sql';
            }
            
            $description = $request->input('description', 'Manual backup');
            $encrypt = $request->boolean('encrypt', false);

            // Create backup directory if it doesn't exist
            $backupDir = storage_path('app/backups');
            if (!file_exists($backupDir)) {
                mkdir($backupDir, 0755, true);
            }

            $backupPath = $backupDir . '/' . $filename;

            // Get database configuration
            $connection = config('database.default');
            $config = config("database.connections.{$connection}");

            if ($connection === 'sqlite') {
                $this->createSQLiteBackup($config, $backupPath);
            } elseif ($connection === 'mysql') {
                $this->createMySQLBackup($config, $backupPath);
            } elseif ($connection === 'pgsql') {
                $this->createPostgreSQLBackup($config, $backupPath);
            } else {
                return back()->withErrors(['error' => 'Unsupported database type for backup']);
            }

            // Encrypt the backup if requested
            if ($encrypt) {
                $this->encryptBackup($backupPath);
                $filename = $filename . '.encrypted';
            }

            // Store backup metadata
            $this->storeBackupMetadata($filename, $description, $encrypt);

            Log::info('Database backup created successfully', [
                'filename' => $filename,
                'size' => filesize($backupPath),
                'user_id' => auth()->id(),
            ]);

            return back()->with('success', 'Backup created successfully: ' . $filename);

        } catch (\Exception $e) {
            Log::error('Database backup failed', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);

            return back()->withErrors(['error' => 'Backup failed: ' . $e->getMessage()]);
        }
    }


    /**
     * Restore database from backup
     */
    public function restoreBackup(Request $request, $filename)
    {
        try {
            $request->validate([
                'confirm_restore' => 'required|accepted',
            ]);

            $backupPath = storage_path('app/backups/' . $filename);
            
            if (!file_exists($backupPath)) {
                return back()->withErrors(['error' => 'Backup file not found']);
            }

            // Check if file is encrypted
            $isEncrypted = Str::endsWith($filename, '.encrypted');
            
            if ($isEncrypted) {
                $decryptedContent = $this->decryptBackup($backupPath);
                $tempFilename = 'temp_restore_' . Str::random(10) . '.sql';
                $tempPath = storage_path('app/backups/' . $tempFilename);
                file_put_contents($tempPath, $decryptedContent);
                $backupPath = $tempPath;
            }

            // Get database configuration
            $connection = config('database.default');
            $config = config("database.connections.{$connection}");

            if ($connection === 'sqlite') {
                $this->restoreSQLiteBackup($config, $backupPath);
            } elseif ($connection === 'mysql') {
                $this->restoreMySQLBackup($config, $backupPath);
            } elseif ($connection === 'pgsql') {
                $this->restorePostgreSQLBackup($config, $backupPath);
            } else {
                return back()->withErrors(['error' => 'Unsupported database type for restore']);
            }

            // Clean up temp file if it was created
            if ($isEncrypted && file_exists($tempPath)) {
                unlink($tempPath);
            }

            Log::info('Database restored successfully', [
                'filename' => $filename,
                'user_id' => auth()->id(),
            ]);

            // Keep the admin logged in: regenerate session and re-auth to avoid any side effects
            if (auth()->check()) {
                request()->session()->regenerate();
                // Optionally re-login the same user to refresh guards after restore
                // auth()->loginUsingId(auth()->id()); // no-op but safe in case guard state changed
            }

            return back()->with('success', 'Database restored successfully from backup: ' . $filename);

        } catch (\Exception $e) {
            Log::error('Database restore failed', [
                'filename' => $filename,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);

            return back()->withErrors(['error' => 'Restore failed: ' . $e->getMessage()]);
        }
    }

    /**
     * Delete a backup file
     */
    public function deleteBackup(Request $request, $filename)
    {
        try {
            // Validate admin password
            $request->validate([
                'admin_password' => 'required|string',
            ]);

            $adminPassword = $request->input('admin_password');
            $currentUser = auth()->user();

            // Check if the provided password matches the current admin's password
            if (!Hash::check($adminPassword, $currentUser->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Incorrect admin password. Please try again.'
                ], 400);
            }

            $backupPath = storage_path('app/backups/' . $filename);
            
            if (file_exists($backupPath)) {
                unlink($backupPath);
                
                // Remove metadata
                $this->removeBackupMetadata($filename);
                
                Log::info('Backup deleted', [
                    'filename' => $filename,
                    'user_id' => auth()->id(),
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Backup deleted successfully'
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Backup file not found'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Backup deletion failed', [
                'filename' => $filename,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Deletion failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Create SQLite backup
     */
    private function createSQLiteBackup($config, $path)
    {
        // For SQLite, we can simply copy the database file
        $databasePath = $config['database'];
        
        if (!file_exists($databasePath)) {
            throw new \Exception('SQLite database file not found: ' . $databasePath);
        }
        
        // Copy the database file
        if (!copy($databasePath, $path)) {
            throw new \Exception('Failed to copy SQLite database file');
        }
    }

    /**
     * Create MySQL backup
     */
    private function createMySQLBackup($config, $path)
    {
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
    }

    /**
     * Create PostgreSQL backup
     */
    private function createPostgreSQLBackup($config, $path)
    {
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
    }



    /**
     * Restore SQLite backup
     */
    private function restoreSQLiteBackup($config, $path)
    {
        $databasePath = $config['database'];
        
        // Create backup of current database before restore
        $backupPath = $databasePath . '.backup_' . now()->format('Y-m-d_H-i-s');
        if (file_exists($databasePath)) {
            copy($databasePath, $backupPath);
        }
        
        // Copy the backup file to replace the current database
        if (!copy($path, $databasePath)) {
            throw new \Exception('Failed to restore SQLite database');
        }
    }

    /**
     * Restore MySQL backup
     */
    private function restoreMySQLBackup($config, $path)
    {
        $command = [
            'mysql',
            '--host=' . $config['host'],
            '--port=' . $config['port'],
            '--user=' . $config['username'],
            '--password=' . $config['password'],
            $config['database']
        ];

        $process = new Process($command);
        $process->setTimeout(600); // 10 minutes timeout
        $process->setInput(file_get_contents($path));
        
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    }

    /**
     * Restore PostgreSQL backup
     */
    private function restorePostgreSQLBackup($config, $path)
    {
        $command = [
            'pg_restore',
            '--host=' . $config['host'],
            '--port=' . $config['port'],
            '--username=' . $config['username'],
            '--dbname=' . $config['database'],
            '--no-password',
            '--verbose',
            '--clean',
            '--if-exists'
        ];

        $process = new Process($command);
        $process->setTimeout(600);
        $process->setInput(file_get_contents($path));
        
        // Set environment variable for password
        $process->setEnv(['PGPASSWORD' => $config['password']]);
        
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
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
     * Decrypt backup file
     */
    private function decryptBackup($path)
    {
        $encrypted = file_get_contents($path);
        return Crypt::decryptString($encrypted);
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
            'created_by' => auth()->id(),
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
     * Remove backup metadata
     */
    private function removeBackupMetadata($filename = null, $cutoffDate = null)
    {
        $metadataPath = storage_path('app/backups/metadata.json');
        
        if (file_exists($metadataPath)) {
            $existingMetadata = json_decode(file_get_contents($metadataPath), true) ?? [];
            
            if ($filename) {
                // Remove specific backup metadata
                $existingMetadata = array_filter($existingMetadata, function($item) use ($filename) {
                    return $item['filename'] !== $filename;
                });
            } elseif ($cutoffDate) {
                // Remove old backup metadata
                $existingMetadata = array_filter($existingMetadata, function($item) use ($cutoffDate) {
                    $createdAt = \Carbon\Carbon::parse($item['created_at']);
                    return $createdAt->gte($cutoffDate);
                });
            }
            
            file_put_contents($metadataPath, json_encode(array_values($existingMetadata), JSON_PRETTY_PRINT));
        }
    }

    /**
     * Get list of backup files
     */
    private function getBackupFiles()
    {
        $backupPath = storage_path('app/backups');
        $metadataPath = $backupPath . '/metadata.json';
        
        if (!file_exists($metadataPath)) {
            return [];
        }

        $metadata = json_decode(file_get_contents($metadataPath), true) ?? [];
        
        // Sort by creation date (newest first)
        usort($metadata, function($a, $b) {
            return strtotime($b['created_at']) - strtotime($a['created_at']);
        });

        return $metadata;
    }

    /**
     * Get backup statistics
     */
    private function getBackupStats()
    {
        $backups = $this->getBackupFiles();
        
        $totalSize = 0;
        $encryptedCount = 0;
        $totalCount = count($backups);
        
        foreach ($backups as $backup) {
            $totalSize += $backup['size'] ?? 0;
            if ($backup['encrypted'] ?? false) {
                $encryptedCount++;
            }
        }

        return [
            'total_count' => $totalCount,
            'encrypted_count' => $encryptedCount,
            'total_size' => $this->formatBytes($totalSize),
            'oldest_backup' => $totalCount > 0 ? $backups[$totalCount - 1]['created_at'] : null,
            'newest_backup' => $totalCount > 0 ? $backups[0]['created_at'] : null,
        ];
    }

    /**
     * Clean up old backups based on retention policy
     */
    private function cleanupOldBackups()
    {
        $retentionDays = config('sems.backup_retention_days', 30);
        $cutoffDate = now()->subDays($retentionDays);
        
        $backups = $this->getBackupFiles();
        $deletedCount = 0;
        
        foreach ($backups as $backup) {
            $createdAt = \Carbon\Carbon::parse($backup['created_at']);
            
            if ($createdAt->lt($cutoffDate)) {
                $backupPath = storage_path('app/backups/' . $backup['filename']);
                
                if (file_exists($backupPath)) {
                    unlink($backupPath);
                    $deletedCount++;
                }
            }
        }
        
        if ($deletedCount > 0) {
            // Remove metadata for deleted backups
            $this->removeBackupMetadata(null, $cutoffDate);
            
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
