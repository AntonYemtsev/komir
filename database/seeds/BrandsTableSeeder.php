<?php

use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('brands')->delete();
        
        \DB::table('brands')->insert(array (
            0 => 
            array (
                'brand_id' => 1,
                'brand_name' => 'Майкубен',
                'created_at' => NULL,
                'updated_at' => NULL,
                'brand_email' => '',
                'brand_company_name' => NULL,
                'brand_company_ceo_name' => NULL,
            ),
        ));
        
        
    }
}