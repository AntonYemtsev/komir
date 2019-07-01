<?php

use Illuminate\Database\Seeder;

class UserTasksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('user_tasks')->delete();
        
        \DB::table('user_tasks')->insert(array (
            0 => 
            array (
                'user_task_id' => 1,
                'user_task_deal_id' => 1,
                'user_task_user_id' => 1,
                'user_task_text' => 'asdasdasd',
                'user_task_start_date' => '2019-03-01',
                'user_task_start_time' => '12:00',
                'user_task_end_date' => '2019-03-11',
                'user_task_end_time' => '13:00',
                'user_task_task_id' => 4,
                'user_task_is_auto' => 0,
                'created_at' => '2019-03-27 06:05:56',
                'updated_at' => '2019-03-27 06:16:27',
                'user_task_comment' => 'asdasdasdasd',
            ),
            1 => 
            array (
                'user_task_id' => 2,
                'user_task_deal_id' => 1,
                'user_task_user_id' => 1,
                'user_task_text' => 'фывфыв фыв фыв',
                'user_task_start_date' => '2019-03-01',
                'user_task_start_time' => '13:00',
                'user_task_end_date' => '2019-03-04',
                'user_task_end_time' => '14:00',
                'user_task_task_id' => 4,
                'user_task_is_auto' => 0,
                'created_at' => '2019-03-27 06:17:06',
                'updated_at' => '2019-03-27 06:17:16',
                'user_task_comment' => 'фывфывыфвфыв',
            ),
            2 => 
            array (
                'user_task_id' => 4,
                'user_task_deal_id' => 1,
                'user_task_user_id' => 1,
                'user_task_text' => 'фывфывфыв',
                'user_task_start_date' => '2019-03-04',
                'user_task_start_time' => '15:00',
                'user_task_end_date' => '2019-03-07',
                'user_task_end_time' => '15:00',
                'user_task_task_id' => 4,
                'user_task_is_auto' => 0,
                'created_at' => '2019-03-27 06:18:22',
                'updated_at' => '2019-03-27 06:24:24',
                'user_task_comment' => 'фывфывыфвячсяч ячс ячс ячс',
            ),
        ));
        
        
    }
}