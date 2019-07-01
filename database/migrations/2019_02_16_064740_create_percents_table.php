<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePercentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('percents', function (Blueprint $table) {
            $table->increments('percent_id');
            $table->unsignedInteger("percent_brand_id")->nullable();
            $table->foreign("percent_brand_id")->references("brand_id")->on('brands');
            $table->double("percent_rate")->nullable();
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
        Schema::dropIfExists('percents');
    }
}
