<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterWpUserNotificationsAddIsRead extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wp_user_notifications', function (Blueprint $table) {
            if(!Schema::hasColumn('wp_user_notifications','is_read'))
                $table->boolean('is_read')->nullable(true)->default(false);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wp_user_notifications', function (Blueprint $table) {
            if(!Schema::hasColumn('wp_user_notifications','is_read'))
                $table->dropColumn('is_read');
        });
    }
}
