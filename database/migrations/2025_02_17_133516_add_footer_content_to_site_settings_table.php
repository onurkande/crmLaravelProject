<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->text('footer_content')->nullable()->after('mail_from_name');
        });
    }

    public function down()
    {
        Schema::table('site_settings', function (Blueprint $table) {
            $table->dropColumn('footer_content');
        });
    }
}; 