<?php

use Illuminate\Database\Seeder;

class DeliveriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('deliveries')->delete();
        
        \DB::table('deliveries')->insert(array (
            0 => 
            array (
                'delivery_id' => 1,
                'delivery_name' => '5 дней',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'delivery_id' => 2,
                'delivery_name' => '10 дней',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'delivery_id' => 3,
                'delivery_name' => '15 дней',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'delivery_id' => 4,
                'delivery_name' => '20 дней',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'delivery_id' => 5,
                'delivery_name' => '30 дней',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'delivery_id' => 6,
                'delivery_name' => '45 дней',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'delivery_id' => 7,
                'delivery_name' => '60 дней',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}