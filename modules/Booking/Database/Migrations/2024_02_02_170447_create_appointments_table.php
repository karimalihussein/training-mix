<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modules_appointments', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->foreignId('service_id')->constrained('modules_services')->onDelete('cascade');
            $table->foreignId('employee_id')->constrained('modules_employees')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('modules_customers')->onDelete('cascade');
            $table->datetime('start_at');
            $table->datetime('end_at');
            $table->timestamp('cancelled_at')->nullable();
            $table->tinyInteger('status')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modules_appointments');
    }
};