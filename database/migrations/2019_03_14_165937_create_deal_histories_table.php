<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deal_histories', function (Blueprint $table) {
            $table->increments('deal_history_id');
            $table->unsignedInteger("deal_history_deal_id")->nullable();
            $table->foreign("deal_history_deal_id")->references("deal_id")->on('deals');
            $table->unsignedInteger("deal_history_user_id")->nullable();
            $table->foreign("deal_history_user_id")->references("user_id")->on('users');
            $table->timestamp("deal_history_datetime")->nullable();
            $table->text("deal_history_text")->nullable();
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
        Schema::dropIfExists('deal_histories');
    }
}
