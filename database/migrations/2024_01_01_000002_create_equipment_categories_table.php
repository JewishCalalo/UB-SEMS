<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            // Add performance index
            $table->index(['name']);
        });

        // Create equipment_types table
        Schema::create('equipment_types', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('equipment_categories')->onDelete('cascade');
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
            
            // Ensure unique names within the same category
            $table->unique(['category_id', 'name']);
            
            // Add performance indexes
            $table->index(['category_id']);
            $table->index(['name']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment_types');
        Schema::dropIfExists('equipment_categories');
    }
};
