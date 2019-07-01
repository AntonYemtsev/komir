<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->increments('client_id');
            $table->string("client_name")->nullable();
            $table->string("client_surname")->nullable();
            $table->string("client_phone")->nullable();
            $table->string("client_email")->nullable();
            $table->unsignedInteger("client_region_id")->nullable();
            $table->foreign("client_region_id")->references("region_id")->on('regions');
            $table->unsignedInteger("client_station_id")->nullable();
            $table->foreign("client_station_id")->references("station_id")->on('stations');
            $table->integer("client_receiver_code")->nullable();
            $table->unsignedInteger("client_company_id")->nullable();
            $table->foreign("client_company_id")->references("company_id")->on('companies');
            $table->integer("is_discount")->nullable()->default(0);
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
        Schema::dropIfExists('clients');
    }
}
