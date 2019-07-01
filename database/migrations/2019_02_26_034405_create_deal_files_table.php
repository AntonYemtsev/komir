<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deal_files', function (Blueprint $table) {
            $table->increments('deal_file_id');
            $table->unsignedInteger("deal_file_deal_id")->nullable();
            $table->foreign("deal_file_deal_id")->references("deal_id")->on('deals');

            $table->unsignedInteger("deal_file_brand_id")->nullable();
            $table->foreign("deal_file_brand_id")->references("brand_id")->on('brands');

            $table->unsignedInteger("deal_file_mark_id")->nullable();
            $table->foreign("deal_file_mark_id")->references("mark_id")->on('marks');

            $table->unsignedInteger("deal_file_fraction_id")->nullable();
            $table->foreign("deal_file_fraction_id")->references("fraction_id")->on('fractions');

            $table->unsignedInteger("deal_file_region_id")->nullable();
            $table->foreign("deal_file_region_id")->references("region_id")->on('regions');

            $table->unsignedInteger("deal_file_station_id")->nullable();
            $table->foreign("deal_file_station_id")->references("station_id")->on('stations');

            $table->integer("deal_file_deal_kp_sum")->nullable()->default(0);

            $table->integer("deal_file_deal_volume")->nullable()->default(1);

            $table->string("deal_file_name")->nullable();
            $table->string("deal_file_src")->nullable();
            $table->string("deal_file_bill_num")->nullable();
            $table->integer("deal_bill_volume")->nullable();
//          Типы файлов deal_file_type
//          1 - КП, 2 - Счет на оплату, 3 - Договор, 4 - Заявка разразу, 5 - Доп. документы, 6 - Закрытие
            $table->integer("deal_file_type")->nullable();
            $table->timestamp("deal_file_date")->nullable();
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
        Schema::dropIfExists('deal_files');
    }
}
