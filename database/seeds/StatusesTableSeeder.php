<?php

use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('statuses')->delete();
        
        \DB::table('statuses')->insert(array (
            0 => 
            array (
                'status_id' => 1,
                'status_name' => 'Заявка',
                'status_color' => '#EA5876',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'status_id' => 2,
                'status_name' => 'Расчет КП',
                'status_color' => '#00B8D8',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'status_id' => 3,
                'status_name' => 'Переговоры',
                'status_color' => '#313541',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'status_id' => 4,
                'status_name' => 'Договор',
                'status_color' => '#674EEC',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'status_id' => 5,
                'status_name' => 'Счет на оплату',
                'status_color' => '#17C671',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'status_id' => 6,
                'status_name' => 'Заявка разрезу',
                'status_color' => '#C4183C',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'status_id' => 7,
                'status_name' => 'Оплата разрезу',
                'status_color' => '#F7B422',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'status_id' => 8,
                'status_name' => 'Отгрузка',
                'status_color' => '#A8AEB4',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'status_id' => 9,
                'status_name' => 'Доставка',
                'status_color' => '#B3D7FF',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'status_id' => 10,
                'status_name' => 'Закрытие',
                'status_color' => '#B3D7FF',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}