<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientAnswersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_answers', function (Blueprint $table) {
            $table->increments('client_answer_id');
            $table->unsignedInteger("client_answer_deal_id")->nullable();
            $table->foreign("client_answer_deal_id")->references("deal_id")->on('deals');
            $table->unsignedInteger("client_answer_user_id")->nullable();
            $table->foreign("client_answer_user_id")->references("user_id")->on('users');
            $table->timestamp("client_answer_datetime")->nullable();
            $table->text("client_answer_text")->nullable();
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
        Schema::dropIfExists('client_answers');
    }
}
