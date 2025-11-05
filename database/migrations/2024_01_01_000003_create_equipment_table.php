<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipment', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('equipment_categories')->onDelete('cascade');
            $table->foreignId('equipment_type_id')->nullable()->after('category_id')->constrained('equipment_types')->onDelete('set null');
            $table->text('description')->nullable();
            $table->string('brand');
            $table->string('model');
            $table->integer('quantity_total')->default(0);
            $table->integer('quantity_available')->default(0);
            $table->enum('condition', ['excellent', 'good', 'fair', 'needs_repair', 'damaged', 'lost', 'under_maintenance'])->default('good');
            $table->string('location')->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('last_maintenance_date')->nullable();
            $table->date('next_maintenance_date')->nullable();
            $table->integer('wishlist_count')->default(0);
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade');
            $table->timestamps();
            
            // Add performance indexes
            $table->index(['is_active', 'category_id']);
            $table->index(['condition', 'is_active']);
        });
        
        // Equipment quantities will be calculated by the Equipment model's recalculateCounts() method
        // This is called after equipment instances are created
    }

    public function down(): void
    {
        Schema::dropIfExists('equipment');
    }
};
