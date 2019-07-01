<?php

use Illuminate\Database\Seeder;

class ClientsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('clients')->delete();
        
        \DB::table('clients')->insert(array (
            0 => 
            array (
                'client_id' => 1,
                'client_name' => 'Адильбек',
                'client_surname' => 'Халихов',
                'client_phone' => '+7015533120',
                'client_email' => 'adik.khalikhov@mail.ru',
                'client_region_id' => 3,
                'client_station_id' => 161,
                'client_receiver_code' => 7580,
                'client_company_id' => 1,
                'is_discount' => 0,
                'created_at' => '2019-03-27 04:41:39',
                'updated_at' => '2019-03-27 04:41:39',
            ),
        ));
        
        
    }
}