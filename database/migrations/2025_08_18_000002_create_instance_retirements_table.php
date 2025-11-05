<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('instance_retirements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipment_instance_id')->constrained('equipment_instances')->cascadeOnDelete();
            $table->string('reason'); // lost, stolen, end_of_life, restored
            $table->text('notes')->nullable();
            $table->foreignId('acted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('acted_at')->nullable();
            $table->timestamps();
            $table->index(['equipment_instance_id', 'reason']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('instance_retirements');
    }
};


