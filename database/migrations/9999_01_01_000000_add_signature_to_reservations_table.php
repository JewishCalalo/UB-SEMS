<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Add the column if it doesn't exist
        if (!Schema::hasColumn('reservations', 'signature')) {
            Schema::table('reservations', function (Blueprint $table) {
                $table->string('signature', 128)->nullable();
            });
        }

        // Add the unique index only if it's not present (SQLite-safe)
        $hasIndex = false;
        try {
            $indexes = DB::select("PRAGMA index_list('reservations')");
            foreach ($indexes as $idx) {
                if (isset($idx->name) && $idx->name === 'reservations_signature_unique') {
                    $hasIndex = true; break;
                }
            }
        } catch (\Throwable $e) {
            // Fallback: best-effort, will attempt create and ignore if exists
        }
        if (!$hasIndex) {
            try {
                Schema::table('reservations', function (Blueprint $table) {
                    $table->unique('signature', 'reservations_signature_unique');
                });
            } catch (\Throwable $e) {
                // Ignore if the index already exists
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('reservations', 'signature')) {
            try {
                Schema::table('reservations', function (Blueprint $table) {
                    $table->dropUnique('reservations_signature_unique');
                });
            } catch (\Throwable $e) {
                // Index might not exist; continue
            }
            Schema::table('reservations', function (Blueprint $table) {
                $table->dropColumn('signature');
            });
        }
    }
};
