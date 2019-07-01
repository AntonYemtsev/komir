<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAutoTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auto_tasks', function (Blueprint $table) {
            $table->increments('auto_task_id');
            $table->unsignedInteger("auto_task_status_id")->nullable();
            $table->foreign("auto_task_status_id")->references("status_id")->on('statuses');
            $table->text("auto_task_text")->nullable();
            $table->integer("auto_task_days")->nullable()->default(0);
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
        Schema::dropIfExists('auto_tasks');
    }
}
