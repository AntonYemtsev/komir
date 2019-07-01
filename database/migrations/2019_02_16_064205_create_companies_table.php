<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->increments('company_id');
            $table->string("company_name")->nullable();
            $table->string("company_ceo_position")->nullable();
            $table->string("company_ceo_name")->nullable();
            $table->text("company_address")->nullable();
            $table->unsignedInteger("company_bank_id")->nullable();
            $table->foreign("company_bank_id")->references("bank_id")->on('banks');
            $table->string("company_bank_iik")->nullable();
            $table->string("company_bank_bin")->nullable();
            $table->integer("company_is_discount")->nullable()->default(0);
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
        Schema::dropIfExists('companies');
    }
}
