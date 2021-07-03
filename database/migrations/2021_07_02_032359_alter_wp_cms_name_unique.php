<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterWpCmsNameUnique extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wp_cms', function (Blueprint $table) {
            $table->unique('name');
            $table->json('value')->nullable(true)->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wp_cms', function (Blueprint $table) {
            $table->dropUnique('wp_cms_name_unique');
            $table->json('value')->nullable(false)->change();
        });
    }
}
