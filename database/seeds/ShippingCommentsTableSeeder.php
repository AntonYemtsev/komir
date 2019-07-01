<?php

use Illuminate\Database\Seeder;

class ShippingCommentsTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('shipping_comments')->delete();
        
        \DB::table('shipping_comments')->insert(array (
            0 => 
            array (
                'shipping_comment_id' => 7,
                'shipping_comment_deal_id' => 1,
                'shipping_comment_user_id' => 1,
                'shipping_comment_datetime' => '2019-04-06 15:53:43',
                'shipping_comment_text' => 'фывфыввыцй',
                'created_at' => '2019-04-06 09:53:43',
                'updated_at' => '2019-04-06 09:53:43',
                'shipping_client_comment_text' => 'уйцуцйу',
            ),
        ));
        
        
    }
}