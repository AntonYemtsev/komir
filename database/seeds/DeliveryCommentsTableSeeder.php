<?php

use Illuminate\Database\Seeder;

class DeliveryCommentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('delivery_comments')->delete();
        
        \DB::table('delivery_comments')->insert(array (
            0 => 
            array (
                'delivery_comment_id' => 3,
                'delivery_comment_deal_id' => 1,
                'delivery_comment_user_id' => 1,
                'delivery_comment_datetime' => '2019-04-06 14:33:30',
                'delivery_comment_text' => 'фывфывфыв',
                'created_at' => '2019-04-06 08:33:30',
                'updated_at' => '2019-04-06 08:33:30',
                'delivery_client_comment_text' => 'йцуцйуцйу',
            ),
        ));
        
        
    }
}