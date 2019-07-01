<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->increments('deal_id');
            $table->unsignedInteger("deal_client_id")->nullable();
            $table->foreign("deal_client_id")->references("client_id")->on('clients');

            $table->timestamp("deal_datetime1")->nullable();
            $table->timestamp("deal_datetime2")->nullable();
            $table->timestamp("deal_datetime3")->nullable();
            $table->timestamp("deal_datetime4")->nullable();
            $table->timestamp("deal_datetime5")->nullable();
            $table->timestamp("deal_datetime6")->nullable();
            $table->timestamp("deal_datetime7")->nullable();
            $table->timestamp("deal_datetime8")->nullable();
            $table->timestamp("deal_datetime9")->nullable();
            $table->timestamp("deal_datetime10")->nullable();

            $table->unsignedInteger("deal_user_id1")->nullable();
            $table->foreign("deal_user_id1")->references("user_id")->on('users');

            $table->unsignedInteger("deal_user_id2")->nullable();
            $table->foreign("deal_user_id2")->references("user_id")->on('users');

            $table->unsignedInteger("deal_user_id3")->nullable();
            $table->foreign("deal_user_id3")->references("user_id")->on('users');

            $table->unsignedInteger("deal_user_id4")->nullable();
            $table->foreign("deal_user_id4")->references("user_id")->on('users');

            $table->unsignedInteger("deal_user_id5")->nullable();
            $table->foreign("deal_user_id5")->references("user_id")->on('users');

            $table->unsignedInteger("deal_user_id6")->nullable();
            $table->foreign("deal_user_id6")->references("user_id")->on('users');

            $table->unsignedInteger("deal_user_id7")->nullable();
            $table->foreign("deal_user_id7")->references("user_id")->on('users');

            $table->unsignedInteger("deal_user_id8")->nullable();
            $table->foreign("deal_user_id8")->references("user_id")->on('users');

            $table->unsignedInteger("deal_user_id9")->nullable();
            $table->foreign("deal_user_id9")->references("user_id")->on('users');


            $table->unsignedInteger("deal_user_id10")->nullable();
            $table->foreign("deal_user_id10")->references("user_id")->on('users');

            $table->unsignedInteger("deal_status_id")->nullable()->default(0);
            $table->foreign("deal_status_id")->references("status_id")->on('statuses');

            $table->unsignedInteger("deal_brand_id")->nullable();
            $table->foreign("deal_brand_id")->references("brand_id")->on('brands');

            $table->unsignedInteger("deal_mark_id")->nullable();
            $table->foreign("deal_mark_id")->references("mark_id")->on('marks');

            $table->unsignedInteger("deal_fraction_id")->nullable();
            $table->foreign("deal_fraction_id")->references("fraction_id")->on('fractions');

            $table->unsignedInteger("deal_region_id")->nullable();
            $table->foreign("deal_region_id")->references("region_id")->on('regions');

            $table->unsignedInteger("deal_station_id")->nullable();
            $table->foreign("deal_station_id")->references("station_id")->on('stations');

            $table->unsignedInteger("deal_payment_id")->nullable();
            $table->foreign("deal_payment_id")->references("payment_id")->on('payments');

            $table->integer("deal_volume")->default(1);
            $table->integer("deal_fact_volume")->nullable()->default(0);
            $table->integer("deal_rest_volume")->nullable()->default(0);
            $table->integer("deal_rest_volume_in_sum")->nullable()->default(0);
            $table->integer("deal_discount_type")->nullable()->default(0);
            $table->string("deal_discount")->nullable()->default(0);

            $table->unsignedInteger("deal_delivery_id")->nullable();
            $table->foreign("deal_delivery_id")->references("delivery_id")->on('deliveries');

            $table->integer("deal_receiver_code")->nullable();
            $table->integer("deal_brand_sum")->nullable()->default(0);
            $table->integer("deal_kp_sum")->nullable()->default(0);
            $table->date("deal_shipping_date")->nullable();
            $table->string("deal_shipping_time")->nullable();
            $table->date("deal_delivery_date")->nullable();
            $table->string("deal_delivery_time")->nullable();
            $table->integer("deal_type_id")->nullable()->default(0);
            $table->integer("file_order_num")->nullable()->default(0);

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
        Schema::dropIfExists('deals');
    }
}
