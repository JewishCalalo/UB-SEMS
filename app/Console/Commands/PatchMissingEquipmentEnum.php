<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class PatchMissingEquipmentEnum extends Command
{
    protected $signature = 'db:patch-missing-enum';
    protected $description = 'Rebuild missing_equipment table to include damaged in incident_type (SQLite)';

    public function handle(): int
    {
        try {
            DB::beginTransaction();

            // Create new table with updated CHECK constraint
            DB::statement('CREATE TABLE missing_equipment_new (
                id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL,
                equipment_instance_id INTEGER NOT NULL,
                reservation_id INTEGER NULL,
                borrower_name VARCHAR NOT NULL,
                borrower_email VARCHAR NOT NULL,
                borrower_contact_number VARCHAR NULL,
                borrower_department VARCHAR NULL,
                incident_date DATE NOT NULL,
                incident_type VARCHAR NOT NULL CHECK (incident_type IN ("stolen","lost","damaged","not_returned")),
                incident_description TEXT NULL,
                replacement_status VARCHAR NOT NULL DEFAULT "pending" CHECK (replacement_status IN ("pending","replaced","not_replaced")),
                replacement_date DATE NULL,
                acted_by INTEGER NULL,
                acted_at DATETIME NULL,
                created_at DATETIME NULL,
                updated_at DATETIME NULL
            );');

            // Copy data; map any invalid values safely
            DB::statement('INSERT INTO missing_equipment_new (
                id, equipment_instance_id, reservation_id, borrower_name, borrower_email,
                borrower_contact_number, borrower_department, incident_date, incident_type,
                incident_description, replacement_status, replacement_date, acted_by, acted_at,
                created_at, updated_at
            )
            SELECT id, equipment_instance_id, reservation_id, borrower_name, borrower_email,
                   borrower_contact_number, borrower_department, incident_date,
                   CASE WHEN incident_type IN ("stolen","lost","damaged","not_returned") THEN incident_type ELSE "lost" END AS incident_type,
                   incident_description, replacement_status, replacement_date, acted_by, acted_at,
                   created_at, updated_at
            FROM missing_equipment;');

            // Drop old and rename new
            DB::statement('DROP TABLE missing_equipment;');
            DB::statement('ALTER TABLE missing_equipment_new RENAME TO missing_equipment;');

            // Recreate indexes
            DB::statement('CREATE INDEX idx_me_instance_type ON missing_equipment (equipment_instance_id, incident_type);');
            DB::statement('CREATE INDEX idx_me_status_date ON missing_equipment (replacement_status, incident_date);');
            DB::statement('CREATE INDEX idx_me_email_date ON missing_equipment (borrower_email, incident_date);');

            DB::commit();
            $this->info('missing_equipment table updated to include damaged in incident_type.');
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            DB::rollBack();
            $this->error('Failed to patch table: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}


