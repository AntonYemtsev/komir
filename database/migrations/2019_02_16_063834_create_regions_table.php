<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('regions', function (Blueprint $table) {
            $table->increments('region_id');
            $table->string("region_name")->nullable();
            $table->double("region_price")->nullable();
            $table->double("region_price_nds")->nullable();
            $table->unsignedInteger("region_brand_id")->nullable();
            $table->foreign("region_brand_id")->references("brand_id")->on('brands');
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
        Schema::dropIfExists('regions');
    }
}
