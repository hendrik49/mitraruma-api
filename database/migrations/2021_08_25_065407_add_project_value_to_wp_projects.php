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
            $table->double('project_value')->nullable(true);
            $table->double('amount_spk_vendor_net')->nullable(true);
            
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
            $table->dropColumn('project_value');
            $table->dropColumn('amount_spk_vendor_net');
        });
    }
}
