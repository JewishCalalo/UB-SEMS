<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment_instances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_id')->constrained('equipment')->onDelete('cascade');
            $table->string('instance_code')->unique(); // Unique identifier for each physical item
            $table->enum('condition', ['excellent', 'good', 'fair', 'needs_repair', 'damaged', 'lost', 'retired', 'under_maintenance']);
            $table->text('condition_notes')->nullable();
            $table->string('location')->nullable();
            $table->boolean('is_available')->default(true);
            $table->boolean('is_active')->default(true);
            $table->date('last_maintenance_date')->nullable();
            $table->timestamps();
            
            // Add performance indexes
            $table->index(['equipment_id', 'is_active', 'is_available']);
            $table->index(['condition', 'is_active']);
            $table->index(['last_maintenance_date', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment_instances');
    }
};
