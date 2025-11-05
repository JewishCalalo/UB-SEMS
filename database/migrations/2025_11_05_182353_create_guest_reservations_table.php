<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('guest_reservations', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('email');
        $table->string('contact_number');
        $table->string('department');
        $table->string('department_other')->nullable();
        $table->date('borrow_date');
        $table->date('return_date');
        $table->string('borrow_time')->nullable();
        $table->string('return_time')->nullable();
        $table->string('reason_type')->nullable();
        $table->text('reason');
        $table->text('additional_details')->nullable();
        $table->text('cart_data');
        $table->string('token')->unique();
        $table->string('verification_code');
        $table->boolean('is_verified')->default(false);
        $table->timestamp('expires_at')->nullable();
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_reservations');
    }
};
