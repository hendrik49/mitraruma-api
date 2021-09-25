<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUserEmailToWpProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wp_projects', function (Blueprint $table) {
            $table->string('customer_email')->nullable(true);
            $table->string('uniq_id')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wp_projects', function (Blueprint $table) {
            $table->dropColumn('customer_email');
            $table->dropColumn('uniq_id');
        });
    }
}
