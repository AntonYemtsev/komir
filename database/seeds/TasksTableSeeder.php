<?php

use Illuminate\Database\Seeder;

class TasksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('tasks')->delete();
        
        \DB::table('tasks')->insert(array (
            0 => 
            array (
                'task_id' => 1,
                'task_name' => 'В процессе',
                'task_color' => '#007BFF',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'task_id' => 2,
                'task_name' => 'Просрочено',
                'task_color' => '#C4183C',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'task_id' => 3,
                'task_name' => 'Выполнено в срок',
                'task_color' => '#17C671',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'task_id' => 4,
                'task_name' => 'Выполнено с просрочкой',
                'task_color' => '#FFD012',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}