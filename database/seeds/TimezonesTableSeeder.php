<?php

use Illuminate\Database\Seeder;

class TimezonesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('timezones')->delete();
        
        \DB::table('timezones')->insert(array (
            0 => 
            array (
                'timezone_id' => 1,
                'timezone_name' => '+6 часов',
                'timezone_value' => '+6',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'timezone_id' => 2,
                'timezone_name' => '+5 часов',
                'timezone_value' => '+5',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}