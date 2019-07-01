<?php

use Illuminate\Database\Seeder;

class RegionsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('regions')->delete();
        
        \DB::table('regions')->insert(array (
            0 => 
            array (
                'region_id' => 1,
                'region_name' => 'Акмолинская',
                'region_price' => 5825.0,
                'region_price_nds' => 6524.0,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'region_id' => 2,
                'region_name' => 'Павлодарская',
                'region_price' => 5589.0,
                'region_price_nds' => 6259.68,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'region_id' => 3,
                'region_name' => 'Алматинская',
                'region_price' => 5178.0,
                'region_price_nds' => 5799.36,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'region_id' => 4,
                'region_name' => 'Жамбыльская',
                'region_price' => 5178.0,
                'region_price_nds' => 5799.36,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'region_id' => 5,
                'region_name' => 'Туркестанская',
                'region_price' => 5178.0,
                'region_price_nds' => 5799.36,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'region_id' => 6,
                'region_name' => 'Актюбинская',
                'region_price' => 5178.0,
                'region_price_nds' => 5799.36,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'region_id' => 7,
                'region_name' => 'Мангистауская',
                'region_price' => 5178.0,
                'region_price_nds' => 5799.36,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'region_id' => 8,
                'region_name' => 'Атырауская',
                'region_price' => 5178.0,
                'region_price_nds' => 5799.36,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'region_id' => 9,
                'region_name' => 'ЗКО',
                'region_price' => 5178.0,
                'region_price_nds' => 5799.36,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'region_id' => 10,
                'region_name' => 'Карагандинская',
                'region_price' => 4973.0,
                'region_price_nds' => 5569.76,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'region_id' => 11,
                'region_name' => 'Костанайская',
                'region_price' => 5396.0,
                'region_price_nds' => 6043.52,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'region_id' => 12,
                'region_name' => 'Кызылординская',
                'region_price' => 5396.0,
                'region_price_nds' => 6043.52,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'region_id' => 13,
                'region_name' => 'ВКО',
                'region_price' => 5179.0,
                'region_price_nds' => 5800.48,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'region_id' => 14,
                'region_name' => 'СКО',
                'region_price' => 5755.0,
                'region_price_nds' => 6445.6,
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}