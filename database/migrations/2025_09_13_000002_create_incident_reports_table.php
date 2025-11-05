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
        Schema::create('incident_reports', function (Blueprint $table) {
            $table->id();
            $table->string('incident_code')->unique();
            $table->foreignId('reservation_id')->constrained()->onDelete('cascade');
            $table->foreignId('equipment_id')->constrained()->onDelete('cascade');
            $table->foreignId('equipment_instance_id')->nullable()->constrained()->onDelete('set null');
            $table->json('equipment_instances')->nullable(); // Multiple equipment instances
            $table->json('equipment_severities')->nullable(); // Severity for each instance
            $table->foreignId('reported_by')->constrained('users')->onDelete('cascade');
            $table->enum('incident_type', ['damaged', 'lost', 'stolen', 'malfunction', 'other']);
            $table->string('severity')->default('medium'); // low, medium, high, critical
            $table->text('description');
            $table->text('student_involvement')->nullable(); // Details about student involvement
            $table->string('student_name')->nullable();
            $table->string('student_email')->nullable();
            $table->string('student_id')->nullable();
            $table->json('students')->nullable(); // Multiple students involvement
            $table->text('action_taken')->nullable(); // What was done immediately
            $table->text('preventive_measures')->nullable(); // How to prevent in future
            $table->enum('status', ['reported', 'investigating', 'resolved', 'closed'])->default('reported');
            $table->text('resolution_notes')->nullable();
            $table->foreignId('resolved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('resolved_at')->nullable();
            $table->json('attachments')->nullable(); // For photos or documents
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incident_reports');
    }
};
