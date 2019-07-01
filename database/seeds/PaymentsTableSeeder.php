<?php

use Illuminate\Database\Seeder;

class PaymentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('payments')->delete();
        
        \DB::table('payments')->insert(array (
            0 => 
            array (
                'payment_id' => 1,
                'payment_name' => '100%',
                'created_at' => NULL,
                'updated_at' => '2019-04-06 07:44:35',
                'is_postpay' => 0,
            ),
            1 => 
            array (
                'payment_id' => 2,
                'payment_name' => '50% / 50%',
                'created_at' => NULL,
                'updated_at' => NULL,
                'is_postpay' => 0,
            ),
            2 => 
            array (
                'payment_id' => 3,
                'payment_name' => '30% / 30% / 40%',
                'created_at' => NULL,
                'updated_at' => NULL,
                'is_postpay' => 0,
            ),
            3 => 
            array (
                'payment_id' => 4,
                'payment_name' => '30% / 40% / 30%',
                'created_at' => NULL,
                'updated_at' => NULL,
                'is_postpay' => 0,
            ),
            4 => 
            array (
                'payment_id' => 5,
                'payment_name' => '40% / 30% / 30%',
                'created_at' => NULL,
                'updated_at' => NULL,
                'is_postpay' => 0,
            ),
            5 => 
            array (
                'payment_id' => 6,
                'payment_name' => '100 Постоплата',
                'created_at' => '2019-04-06 07:44:44',
                'updated_at' => '2019-04-06 07:44:44',
                'is_postpay' => 1,
            ),
        ));
        
        
    }
}