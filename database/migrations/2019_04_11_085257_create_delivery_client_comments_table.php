<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDeliveryClientCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('delivery_client_comments', function (Blueprint $table) {
            $table->increments('delivery_client_comment_id');
            $table->unsignedInteger("delivery_comment_deal_id")->nullable();
            $table->foreign("delivery_comment_deal_id")->references("deal_id")->on('deals');
            $table->unsignedInteger("delivery_comment_user_id")->nullable();
            $table->foreign("delivery_comment_user_id")->references("user_id")->on('users');
            $table->timestamp("delivery_comment_datetime")->nullable();
            $table->text("delivery_client_comment_text")->nullable();
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
        Schema::dropIfExists('delivery_client_comments');
    }
}
