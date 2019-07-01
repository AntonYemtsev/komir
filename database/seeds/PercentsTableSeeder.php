<?php

use Illuminate\Database\Seeder;

class PercentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('percents')->delete();
        
        \DB::table('percents')->insert(array (
            0 => 
            array (
                'percent_id' => 1,
                'percent_brand_id' => 1,
                'percent_rate' => 30.0,
                'created_at' => NULL,
                'updated_at' => NULL,
                'percent_sum_rate' => 0.0,
            ),
        ));
        
        
    }
}