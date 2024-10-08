<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modules_products', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique()->index();
            $table->integer('price_in_cents');
            $table->integer('stock')->default(0);
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modules_products');
    }
};
