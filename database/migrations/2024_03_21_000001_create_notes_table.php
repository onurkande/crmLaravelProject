<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->string('image_path')->nullable();
            $table->boolean('status')->default(true); // Notun aktif/pasif durumu
            $table->timestamps();
            $table->softDeletes(); // Silinen notları geri getirmek için
        });
    }

    public function down()
    {
        Schema::dropIfExists('notes');
    }
}; 