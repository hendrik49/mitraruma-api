<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWpProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wp_projects', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('vendor_user_id')->nullable(true);
            $table->string('order_number');
            $table->string('room_id');
            $table->text('description');
            $table->json('images')->nullable();
            $table->double('estimated_budget');
            $table->double('amount_spk_customer_gross')->nullable();
            $table->double('amount_spk_customer')->nullable();
            $table->double('amount_spk_vendor')->nullable();
            $table->double('discount')->nullable();
            $table->double('commision')->nullable();

            $table->double('termin_customer_1')->nullable();
            $table->double('termin_customer_2')->nullable();
            $table->double('termin_customer_3')->nullable();
            $table->double('termin_customer_4')->nullable();
            $table->double('termin_customer_5')->nullable();

            $table->double('termin_vendor_1')->nullable();
            $table->double('termin_vendor_2')->nullable();
            $table->double('termin_vendor_3')->nullable();
            $table->double('termin_vendor_4')->nullable();
            $table->double('termin_vendor_5')->nullable();

            $table->string('vendor_name')->nullable();
            $table->string('vendor_contact')->nullable();
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

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wp_projects');
    }
}
