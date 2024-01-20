<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modules_order_lines', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('modules_orders');
            $table->foreignId('product_id')->constrained('modules_products');
            $table->integer('quantity');
            $table->integer('price_in_cents');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modules_order_lines');
    }
};
