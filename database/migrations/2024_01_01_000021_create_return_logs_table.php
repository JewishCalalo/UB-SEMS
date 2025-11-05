<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('return_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reservation_id')->constrained('reservations')->onDelete('cascade');
            $table->foreignId('equipment_instance_id')->constrained('equipment_instances')->onDelete('cascade');
            $table->enum('returned_condition', ['excellent', 'good', 'fair', 'needs_repair', 'damaged', 'lost', 'retired', 'under_maintenance']);
            $table->text('condition_notes')->nullable();
            $table->integer('quantity_returned');
            $table->integer('quantity_damaged')->default(0);
            $table->integer('quantity_lost')->default(0);
            $table->text('damage_description')->nullable();

            $table->foreignId('processed_by')->constrained('users')->onDelete('cascade');
            $table->timestamp('returned_at');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('return_logs');
    }
};
