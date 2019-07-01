<?php

use Illuminate\Database\Seeder;

class MarksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('marks')->delete();
        
        \DB::table('marks')->insert(array (
            0 => 
            array (
                'mark_id' => 1,
                'mark_name' => 'Бурый уголь',
                'mark_code' => 'Б-3',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'mark_id' => 2,
                'mark_name' => 'Каменный уголь',
                'mark_code' => 'Д',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}