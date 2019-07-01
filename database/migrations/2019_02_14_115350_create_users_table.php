<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('user_id');
            $table->string("user_name")->nullable();
            $table->string("user_surname")->nullable();
            $table->string("email")->nullable();
            $table->string("user_phone")->nullable();
            $table->string("password")->nullable();
            $table->unsignedInteger("user_role_id")->default(0);
            $table->foreign("user_role_id")->references("role_id")->on('roles');
            $table->integer("is_blocked")->default(0);
            $table->timestamp("date_last_login")->nullable();
            $table->timestamp("password_changed_time")->nullable();
            $table->string("image")->nullable();
            $table->string("reset_token")->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
