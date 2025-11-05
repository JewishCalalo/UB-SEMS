<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maintenance_records', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained('equipment')->onDelete('cascade');
            $table->string('performed_by', 255);
            $table->date('maintenance_date');
            $table->enum('maintenance_type', ['routine', 'repair', 'upgrade', 'inspection', 'calibration', 'routine_maintenance_mode', 'emergency_enforcement']);
            $table->text('description')->nullable();
            $table->text('notes')->nullable();
            $table->json('affected_instances')->nullable(); // Store affected instance IDs and their condition changes
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maintenance_records');
    }
};
