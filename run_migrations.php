<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use Illuminate\Support\Facades\Artisan;

try {
    echo "Running migrations...\n";
    Artisan::call('migrate', ['--force' => true]);
    echo "Migrations completed successfully!\n";
    echo Artisan::output();
} catch (Exception $e) {
    echo "Migration failed: " . $e->getMessage() . "\n";
}
