<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRatingToWpProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wp_projects', function (Blueprint $table) {
            $table->double('rating_admin')->nullable(true);
            $table->double('rating_vendor')->nullable(true);
            $table->double('rating_customer')->nullable(true);            
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
            $table->dropColumn('rating_admin');
            $table->dropColumn('rating_vendor');
            $table->dropColumn('rating_customer');
        });
    }
}
