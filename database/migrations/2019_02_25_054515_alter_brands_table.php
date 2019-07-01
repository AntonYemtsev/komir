<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterBrandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brands', function (Blueprint $table) {
            $table->string('brand_email');
            $table->string('brand_company_name')->nullable();
            $table->string('brand_company_ceo_name')->nullable();
            $table->string('brand_dogovor_num')->nullable();
            $table->date('brand_dogovor_date')->nullable();
            $table->text('brand_props')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
