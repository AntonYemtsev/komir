<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('users')->delete();
        
        \DB::table('users')->insert(array (
            0 => 
            array (
                'user_id' => 1,
                'user_name' => 'Админ',
                'user_surname' => 'Админов',
                'email' => 'admin@admin.com',
                'user_phone' => '+777777777',
                'password' => '$2y$10$UBfiXLOzuJvI40c.VKNgge9GsAixUOf7R5vCbgZxKx3.4DD8vhvha',
                'user_role_id' => 1,
                'is_blocked' => 0,
                'date_last_login' => '2019-04-07 09:58:37',
                'password_changed_time' => NULL,
                'image' => NULL,
                'reset_token' => NULL,
                'remember_token' => 'UNmuzwo83chBiAwb8c2gsHO8dyQwhi4cGDOEwOrqHfruzi46nq5Wz1PZ0cBw',
                'created_at' => NULL,
                'updated_at' => '2019-04-07 03:58:37',
            ),
        ));
        
        
    }
}