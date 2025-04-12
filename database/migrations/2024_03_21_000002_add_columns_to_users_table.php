<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->enum('user_type', ['admin', 'sales_consultant', 'agency', 'user'])->default('user')->after('password');
            $table->string('profile_image')->nullable()->after('user_type');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['user_type', 'profile_image']);
        });
    }
}; 