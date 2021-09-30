<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWpPaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wp_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->nullable();
            $table->double('amount')->default(0);
            $table->string('activity',150)->nullable();
            $table->string('phase',50)->nullable();
            $table->string('link')->nullable();
            $table->string('consultation_id')->nullable();
            $table->string('room_id')->nullable();
            $table->string('uniq_id')->nullable();
            $table->string('status',50)->nullable();
            $table->integer('code')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('wp_otps');
    }
}
