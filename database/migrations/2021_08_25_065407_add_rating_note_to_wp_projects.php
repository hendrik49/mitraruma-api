<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRatingNoteToWpProjects extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wp_projects', function (Blueprint $table) {
            $table->text('rating_customer_note')->nullable(true);
            $table->text('rating_vendor_note')->nullable(true);
            $table->text('rating_admin_note')->nullable(true);       
            $table->json('rating_images')->nullable();     
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
            $table->dropColumn('rating_customer_note');
            $table->dropColumn('rating_vendor_note');
            $table->dropColumn('rating_admin_note');
            $table->dropColumn('rating_images');
        });
    }
}
