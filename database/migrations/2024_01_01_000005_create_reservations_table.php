<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('reservation_code')->unique();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('name')->nullable(); // Guest name
            $table->string('email')->nullable(); // Guest email
            $table->string('contact_number')->nullable(); // Guest contact
            $table->string('department')->nullable(); // Guest department
            $table->date('borrow_date');
            $table->date('return_date');
            $table->time('borrow_time')->nullable();
            $table->time('return_time')->nullable();
            $table->enum('status', ['pending', 'approved', 'denied', 'picked_up', 'returned', 'overdue', 'cancelled', 'completed']);
            $table->text('reason')->nullable();
            $table->text('additional_details')->nullable();
            $table->longText('id_image_path')->nullable();
            $table->text('remarks')->nullable();
            $table->foreignId('approved_by')->nullable()->constrained('users')->onDelete('set null');
            $table->timestamp('approved_at')->nullable();
            $table->date('pickup_date')->nullable();
            $table->timestamp('picked_up_at')->nullable();
            $table->timestamp('returned_at')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            // Deterministic duplicate detection
            $table->string('signature', 128)->nullable()->unique();
            
            // Added fields from separate migrations
            $table->foreignId('created_by')->nullable()->constrained('users')->onDelete('set null')->after('user_id');
            $table->enum('pickup_condition', ['excellent', 'good', 'fair', 'needs_repair', 'damaged'])->nullable()->after('picked_up_at');
            $table->text('pickup_notes')->nullable()->after('pickup_condition');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
