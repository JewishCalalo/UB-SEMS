<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('missing_equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_instance_id')->constrained('equipment_instances')->cascadeOnDelete();
            $table->foreignId('reservation_id')->nullable()->constrained('reservations')->nullOnDelete();
            $table->foreignId('incident_id')->nullable()->constrained('incident_reports')->onDelete('set null');
            $table->string('borrower_name');
            $table->string('borrower_email');
            $table->string('borrower_contact_number')->nullable();
            $table->string('borrower_department')->nullable();
            $table->date('incident_date');
            $table->enum('incident_type', ['stolen', 'lost', 'damaged', 'not_returned']);
            $table->text('incident_description')->nullable();
            $table->enum('replacement_status', ['pending', 'replaced', 'not_replaced'])->default('pending');
            $table->date('replacement_date')->nullable();
            $table->foreignId('acted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('acted_at')->nullable();
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['equipment_instance_id', 'incident_type']);
            $table->index(['replacement_status', 'incident_date']);
            $table->index(['borrower_email', 'incident_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('missing_equipment');
    }
};
