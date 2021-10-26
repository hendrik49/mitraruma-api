<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWpVendorExtensionAttributesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wp_vendor_extension_attributes', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->integer('quality')->nullable();
            $table->integer('responsiveness_to_customer')->nullable();
            $table->integer('responsiveness_to_mitraruma')->nullable();
            $table->integer('behaviour')->nullable();
            $table->integer('helpful')->nullable();
            $table->integer('commitment')->nullable();
            $table->integer('activeness')->nullable();
            $table->double('overall_score')->nullable();
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
        Schema::dropIfExists('wp_user_extension_attributes');
    }
}
