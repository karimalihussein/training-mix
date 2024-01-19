<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modules_shipments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('modules_orders');
            $table->string('status');
            $table->string('provider');
            $table->string('provider_shipment_id');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modules_shipments');
    }
};
