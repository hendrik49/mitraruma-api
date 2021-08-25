<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddServiceTypeToWpProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wp_projects', function (Blueprint $table) {
            $table->string('service_type',50)->nullable(true);
            $table->bigInteger('admin_user_id')->nullable();
            $table->string('consultation_id')->nullable(true);
            $table->string('admin_name')->nullable(true);
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
            $table->dropColumn('service_type');
            $table->dropColumn('admin_user_id');
            $table->dropColumn('consultation_id');
            $table->dropColumn('admin_name');
        });
    }
}
