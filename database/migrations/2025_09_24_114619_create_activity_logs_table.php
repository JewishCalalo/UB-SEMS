<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activity_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('action'); // created, updated, deleted, etc.
            $table->string('model_type'); // Equipment, EquipmentInstance, MaintenanceRecord, etc.
            $table->unsignedBigInteger('model_id')->nullable(); // ID of the affected model
            $table->string('model_name')->nullable(); // Human-readable name of the affected item
            $table->json('old_values')->nullable(); // Previous values for updates
            $table->json('new_values')->nullable(); // New values for updates
            $table->text('description'); // Human-readable description
            $table->timestamps();
            
            $table->index(['user_id', 'created_at']);
            $table->index(['model_type', 'model_id']);
            $table->index('action');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activity_logs');
    }
};