<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stations', function (Blueprint $table) {
            $table->increments('station_id');
            $table->string("station_name")->nullable();
            $table->string("station_code")->nullable();
            $table->integer("station_km")->nullable();
            $table->unsignedInteger("station_region_id")->nullable();
            $table->foreign("station_region_id")->references("region_id")->on('regions');
            $table->integer("station_rate")->nullable();
            $table->integer("station_rate_nds")->nullable();
            $table->unsignedInteger("station_brand_id")->nullable();
            $table->foreign("station_brand_id")->references("brand_id")->on('brands');
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
        Schema::dropIfExists('stations');
    }
}
