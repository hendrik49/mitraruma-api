<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddProjectValueToWpProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wp_projects', function (Blueprint $table) {
            $table->double('termin_customer_count')->nullable(true);
            $table->double('termin_vendor_count')->nullable(true);
            
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
            $table->dropColumn('termin_customer_count');
            $table->dropColumn('termin_vendor_count');
        });
    }
}
