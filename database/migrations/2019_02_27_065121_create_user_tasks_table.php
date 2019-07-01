<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_tasks', function (Blueprint $table) {
            $table->increments('user_task_id');
            $table->unsignedInteger("user_task_deal_id")->nullable();
            $table->foreign("user_task_deal_id")->references("deal_id")->on('deals');
            $table->unsignedInteger("user_task_user_id")->nullable();
            $table->foreign("user_task_user_id")->references("user_id")->on('users');
            $table->text("user_task_text")->nullable();
            $table->date("user_task_start_date")->nullable();
            $table->string("user_task_start_time")->nullable();
            $table->date("user_task_end_date")->nullable();
            $table->string("user_task_end_time")->nullable();
            $table->unsignedInteger("user_task_task_id")->nullable();
            $table->foreign("user_task_task_id")->references("task_id")->on('tasks');
            $table->integer("user_task_is_auto")->nullable()->default(0);
            $table->text("user_task_comment")->nullable();
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
        Schema::dropIfExists('user_tasks');
    }
}
