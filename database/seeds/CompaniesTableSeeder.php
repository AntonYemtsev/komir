<?php

use Illuminate\Database\Seeder;

class CompaniesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('companies')->delete();
        
        \DB::table('companies')->insert(array (
            0 => 
            array (
                'company_id' => 1,
                'company_name' => 'Komir Ko',
                'company_ceo_position' => 'Должность Komir Ko',
                'company_ceo_name' => 'ФИО Komir Ko',
                'company_address' => 'Юр Komir Ko',
                'company_bank_id' => 31,
                'company_bank_iik' => 'IIKKOMIRKO',
                'company_bank_bin' => 'BINKOMIRKO',
                'created_at' => '2019-03-27 04:37:21',
                'updated_at' => '2019-03-27 04:39:31',
                'company_delivery_address' => 'Доставка адрес Komir Ko',
                'company_okpo' => 'ОКПО Komir Ko',
                'company_is_discount' => 1,
            ),
        ));
        
        
    }
}