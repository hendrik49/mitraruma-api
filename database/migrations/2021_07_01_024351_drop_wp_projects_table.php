<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropWpProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('wp_projects');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('wp_projects', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('vendor_user_id')->nullable(true);
            $table->text('description');
            $table->json('images');
            $table->double('estimated_budget');
            $table->string('customer_name');
            $table->string('customer_contact');
            $table->string('province')->nullable(true);
            $table->string('city')->nullable(true);
            $table->string('district')->nullable(true);
            $table->string('sub_district')->nullable(true);
            $table->string('zipcode')->nullable(true);
            $table->string('street');
            $table->string('status');
            $table->string('sub_status');
            $table->timestamps();
            $table->softDeletes();
        });
    }
}
