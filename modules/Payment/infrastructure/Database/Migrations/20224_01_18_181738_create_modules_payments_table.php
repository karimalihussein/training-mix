<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('modules_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('modules_orders');
            $table->foreignId('user_id')->constrained('users');
            $table->string('status');
            $table->string('payment_gateway');
            $table->string('payment_id');
            $table->integer('total_in_cents');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('modules_payments');
    }
};