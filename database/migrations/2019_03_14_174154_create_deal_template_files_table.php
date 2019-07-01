<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealTemplateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deal_template_files', function (Blueprint $table) {
            $table->increments('deal_template_file_id');
            $table->integer("deal_template_type_id")->nullable()->default(0);
            $table->longText("deal_template_text")->nullable();
            $table->string("deal_template_mail_title")->nullable();
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
        Schema::dropIfExists('deal_template_files');
    }
}
