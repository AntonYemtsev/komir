<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('roles')->delete();
        
        \DB::table('roles')->insert(array (
            0 => 
            array (
                'role_id' => 1,
                'role_name' => 'Администратор',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'role_id' => 2,
                'role_name' => 'Менеджер',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'role_id' => 3,
                'role_name' => 'Бухгалтер',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'role_id' => 4,
                'role_name' => 'Владелец',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}