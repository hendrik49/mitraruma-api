<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNikToWpUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wp_users', function (Blueprint $table) {
            $table->string('nik',50)->nullable(true);
            $table->string('npwp',50)->nullable(true);
            $table->string('file_nik')->nullable(true);
            $table->string('file_npwp')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wp_users', function (Blueprint $table) {
            $table->dropColumn('nik');
            $table->dropColumn('npwp');
            $table->dropColumn('file_nik');
            $table->dropColumn('file_npwp');
        });
    }
}
