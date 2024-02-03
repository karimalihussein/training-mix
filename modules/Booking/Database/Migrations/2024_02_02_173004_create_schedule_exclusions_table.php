<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modules_schedule_exclusions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('modules_employees')->onDelete('cascade');
            $table->timestamp('starts_at');
            $table->timestamp('ends_at');
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('modules_schedule_exclusions');
    }
};