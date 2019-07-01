<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSystemInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('system_info', function (Blueprint $table) {
            $table->increments('system_info_id');
            $table->string("system_info_company_name")->nullable();
            $table->unsignedInteger("system_info_bank_id")->nullable();
            $table->foreign("system_info_bank_id")->references("bank_id")->on('banks');
            $table->string("system_info_bank_iik")->nullable();
            $table->string("system_info_bank_bin")->nullable();
            $table->string("system_info_bank_kbe")->nullable();
            $table->string("system_info_bank_code")->nullable();
            $table->string("system_info_address")->nullable();
            $table->string("system_info_img")->nullable();
            $table->string("system_info_fio")->nullable();
            $table->integer("system_info_bill_num")->nullable()->default(0);
            $table->string("system_info_bill_year")->nullable();
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
        Schema::dropIfExists('system_info');
    }
}
