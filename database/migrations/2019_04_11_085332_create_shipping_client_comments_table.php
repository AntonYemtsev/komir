<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShippingClientCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_client_comments', function (Blueprint $table) {
            $table->increments('shipping_client_comment_id');
            $table->unsignedInteger("shipping_comment_deal_id")->nullable();
            $table->foreign("shipping_comment_deal_id")->references("deal_id")->on('deals');
            $table->unsignedInteger("shipping_comment_user_id")->nullable();
            $table->foreign("shipping_comment_user_id")->references("user_id")->on('users');
            $table->timestamp("shipping_comment_datetime")->nullable();
            $table->text("shipping_client_comment_text")->nullable();
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
        Schema::dropIfExists('shipping_client_comments');
    }
}
