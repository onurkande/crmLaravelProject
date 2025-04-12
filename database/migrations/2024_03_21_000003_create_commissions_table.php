<?php

namespace Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('commissions', function (Blueprint $table) {
            $table->id();
            $table->decimal('price', 10, 2); // Fiyat
            $table->foreignId('consultant_id')->constrained('users'); // Danışman ID
            $table->decimal('percentage', 5, 2); // Yüzde
            $table->decimal('commission_amount', 10, 2); // Hesaplanan komisyon tutarı
            $table->foreignId('calculated_by')->constrained('users'); // Hesaplayan admin
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('commissions');
    }
}; 