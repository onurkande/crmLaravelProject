<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('advertisements', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->text('description');
            $table->string('deposit_status')->nullable();
            $table->string('sale_status')->nullable();
            $table->string('reserve_status')->nullable();
            $table->string('cover_image');
            $table->decimal('debt_amount', 10, 2)->nullable();
            $table->integer('square_meters');
            $table->string('apartment_number');
            $table->string('room_type');
            $table->text('map_location')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('advertisements');
    }
}; 