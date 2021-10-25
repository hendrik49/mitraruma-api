<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddBankToWpUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('wp_users', function (Blueprint $table) {
            $table->string('bank',30)->nullable(true);
            $table->string('bank_account',50)->nullable(true);
            $table->string('file_bank')->nullable(true);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('wp_users', function (Blueprint $table) {
            $table->dropColumn('bank');
            $table->dropColumn('bank_account');
            $table->dropColumn('file_bank');
        });
    }
}
