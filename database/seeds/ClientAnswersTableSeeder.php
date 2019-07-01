<?php

use Illuminate\Database\Seeder;

class ClientAnswersTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('client_answers')->delete();
        
        \DB::table('client_answers')->insert(array (
            0 => 
            array (
                'client_answer_id' => 1,
                'client_answer_deal_id' => 1,
                'client_answer_user_id' => 1,
                'client_answer_datetime' => '2019-03-27 10:42:33',
                'client_answer_text' => 'тест ответ',
                'created_at' => '2019-03-27 04:42:33',
                'updated_at' => '2019-03-27 04:42:33',
            ),
        ));
        
        
    }
}