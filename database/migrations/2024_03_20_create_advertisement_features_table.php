<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('advertisement_features', function (Blueprint $table) {
            $table->id();
            $table->foreignId('advertisement_id')->constrained()->onDelete('cascade');
            $table->boolean('supermarket')->default(false);
            $table->boolean('spa_sauna_massage')->default(false);
            $table->boolean('exchange_office')->default(false);
            $table->boolean('cafe_bar')->default(false);
            $table->boolean('gift_shop')->default(false);
            $table->boolean('pharmacy')->default(false);
            $table->boolean('bank')->default(false);
            $table->boolean('bicycle_path')->default(false);
            $table->boolean('green_areas')->default(false);
            $table->boolean('restaurant')->default(false);
            $table->boolean('playground')->default(false);
            $table->boolean('water_slides')->default(false);
            $table->boolean('walking_track')->default(false);
            $table->boolean('fitness_gym')->default(false);
            $table->boolean('football_field')->default(false);
            $table->boolean('pool')->default(false);
            $table->boolean('security')->default(false);
            $table->boolean('parking')->default(false);
            $table->boolean('ev_charging')->default(false);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('advertisement_features');
    }
}; 