<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
	public function up(): void
	{
		Schema::create('reservation_item_instances', function (Blueprint $table) {
			$table->id();
			$table->foreignId('reservation_item_id')->constrained('reservation_items')->cascadeOnDelete();
			$table->foreignId('equipment_instance_id')->constrained('equipment_instances')->cascadeOnDelete();
			$table->string('status')->default('picked_up'); // picked_up, returned
			$table->timestamp('picked_up_at')->nullable();
			$table->timestamp('returned_at')->nullable();
			
			// Added fields from separate migration
			$table->enum('pickup_condition', ['excellent', 'good', 'fair', 'needs_repair', 'damaged'])->nullable()->after('picked_up_at');
			$table->text('pickup_notes')->nullable()->after('pickup_condition');
			
			// Return condition and notes
			$table->enum('returned_condition', ['excellent', 'good', 'fair', 'needs_repair', 'damaged', 'lost'])->nullable()->after('returned_at');
			$table->text('returned_notes')->nullable()->after('returned_condition');
			
			$table->timestamps();
			$table->unique(['reservation_item_id', 'equipment_instance_id'], 'res_item_instance_unique');
		});
	}

	public function down(): void
	{
		Schema::dropIfExists('reservation_item_instances');
	}
};


