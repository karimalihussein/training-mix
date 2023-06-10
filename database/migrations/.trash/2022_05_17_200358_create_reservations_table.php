<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('office_id');
            $table->integer('price');
            $table->tinyInteger('status')->default(1);
            $table->date('start_date');
            $table->date('end_date');
            $table->text('wifi_password')->nullable();

            $table->index(['user_id', 'status']);
            $table->index(['office_id', 'status']);
            $table->index(['office_id', 'status', 'start_date', 'end_date']);
            $table->timestamps();
        });

        \App\Models\Tag::create([
            'name' => 'has_ac',
        ]);
        \App\Models\Tag::create([
            'name' => 'has_wifi',
        ]);
        \App\Models\Tag::create([
            'name' => 'has_tv',
        ]);
        \App\Models\Tag::create([
            'name' => 'has_projector',
        ]);
        \App\Models\Tag::create([
            'name' => 'has_whiteboard',
        ]);
        \App\Models\Tag::create([
            'name' => 'has_air_conditioner',
        ]);
        \App\Models\Tag::create([
            'name' => 'has_heating',
        ]);
        \App\Models\Tag::create([
            'name' => 'has_kitchen',
        ]);
        \App\Models\Tag::create([
            'name' => 'has_bathroom',
        ]);
        \App\Models\Tag::create([
            'name' => 'has_shower',
        ]);
        \App\Models\Tag::create([
            'name' => 'has_bathtub',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
};
