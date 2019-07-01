<?php

use Illuminate\Database\Seeder;

class DealsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('deals')->delete();
        
        \DB::table('deals')->insert(array (
            0 => 
            array (
                'deal_id' => 1,
                'deal_client_id' => 1,
                'deal_datetime1' => '2019-03-27 10:41:54',
                'deal_datetime2' => '2019-04-07 01:29:42',
                'deal_datetime3' => '2019-04-06 13:53:38',
                'deal_datetime4' => '2019-04-06 13:57:25',
                'deal_datetime5' => '2019-04-06 13:57:32',
                'deal_datetime6' => '2019-04-06 14:41:34',
                'deal_datetime7' => '2019-04-06 14:10:18',
                'deal_datetime8' => '2019-04-06 15:50:42',
                'deal_datetime9' => '2019-04-06 14:11:38',
                'deal_datetime10' => '2019-04-07 01:48:29',
                'deal_user_id1' => 1,
                'deal_user_id2' => 1,
                'deal_user_id3' => 1,
                'deal_user_id4' => 1,
                'deal_user_id5' => 1,
                'deal_user_id6' => 1,
                'deal_user_id7' => 1,
                'deal_user_id8' => 1,
                'deal_user_id9' => 1,
                'deal_user_id10' => 1,
                'deal_status_id' => 10,
                'deal_brand_id' => 1,
                'deal_mark_id' => 1,
                'deal_fraction_id' => 1,
                'deal_region_id' => 8,
                'deal_station_id' => 349,
                'deal_payment_id' => 1,
                'deal_volume' => 1000,
                'deal_fact_volume' => 998,
                'deal_discount_type' => 0,
                'deal_discount' => '0',
                'deal_delivery_id' => 2,
                'deal_receiver_code' => 123,
                'deal_brand_sum' => 50000,
                'deal_kp_sum' => 14930968,
                'deal_shipping_date' => '2019-04-03',
                'deal_shipping_time' => '10:40',
                'deal_delivery_date' => '2019-04-22',
                'deal_delivery_time' => '10:40',
                'deal_type_id' => 2,
                'created_at' => '2019-03-27 04:41:54',
                'updated_at' => '2019-04-07 04:39:15',
                'deal_rest_volume_in_sum' => 28071,
                'deal_rest_volume' => 2,
            ),
            1 => 
            array (
                'deal_id' => 2,
                'deal_client_id' => 1,
                'deal_datetime1' => '2019-04-06 12:43:05',
                'deal_datetime2' => NULL,
                'deal_datetime3' => NULL,
                'deal_datetime4' => NULL,
                'deal_datetime5' => NULL,
                'deal_datetime6' => NULL,
                'deal_datetime7' => NULL,
                'deal_datetime8' => NULL,
                'deal_datetime9' => NULL,
                'deal_datetime10' => '0000-00-00 00:00:00',
                'deal_user_id1' => 1,
                'deal_user_id2' => 1,
                'deal_user_id3' => 1,
                'deal_user_id4' => 1,
                'deal_user_id5' => NULL,
                'deal_user_id6' => NULL,
                'deal_user_id7' => NULL,
                'deal_user_id8' => NULL,
                'deal_user_id9' => NULL,
                'deal_user_id10' => NULL,
                'deal_status_id' => 2,
                'deal_brand_id' => NULL,
                'deal_mark_id' => NULL,
                'deal_fraction_id' => NULL,
                'deal_region_id' => NULL,
                'deal_station_id' => NULL,
                'deal_payment_id' => NULL,
                'deal_volume' => 0,
                'deal_fact_volume' => 0,
                'deal_discount_type' => 0,
                'deal_discount' => '0',
                'deal_delivery_id' => NULL,
                'deal_receiver_code' => NULL,
                'deal_brand_sum' => 0,
                'deal_kp_sum' => 0,
                'deal_shipping_date' => NULL,
                'deal_shipping_time' => NULL,
                'deal_delivery_date' => NULL,
                'deal_delivery_time' => NULL,
                'deal_type_id' => 0,
                'created_at' => '2019-04-06 06:43:05',
                'updated_at' => '2019-04-06 06:43:05',
                'deal_rest_volume_in_sum' => NULL,
                'deal_rest_volume' => NULL,
            ),
        ));
        
        
    }
}