<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blacklisted_emails', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->foreignId('missing_equipment_id')->nullable()->constrained('missing_equipment')->nullOnDelete();
            $table->string('reason')->nullable();
            $table->foreignId('added_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('added_at')->nullable();
            $table->timestamps();
            $table->index(['email']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blacklisted_emails');
    }
};


