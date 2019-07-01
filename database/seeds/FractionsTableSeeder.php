<?php

use Illuminate\Database\Seeder;

class FractionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('fractions')->delete();
        
        \DB::table('fractions')->insert(array (
            0 => 
            array (
                'fraction_id' => 1,
                'fraction_name' => '0-50 мм',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'fraction_id' => 2,
                'fraction_name' => '0-150 мм',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'fraction_id' => 3,
                'fraction_name' => '0-300 мм',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'fraction_id' => 4,
                'fraction_name' => '50-200 мм',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}