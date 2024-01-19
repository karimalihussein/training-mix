<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modules_orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('status');
            $table->integer('total_in_cents');
            $table->string('payment_gateway');
            // $table->foreignId('payment_id')->nullable()->constrained('modules_payments');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modules_orders');
    }
};
