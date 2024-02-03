<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modules_employee_service', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('modules_employees')->onDelete('cascade');
            $table->foreignId('service_id')->constrained('modules_services')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modules_employee_service');
    }
};