<?php

use Illuminate\Database\Seeder;

class DealFilesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('deal_files')->delete();
        
        \DB::table('deal_files')->insert(array (
            0 => 
            array (
                'deal_file_id' => 7,
                'deal_file_deal_id' => 2,
                'deal_file_name' => '15545357972_bill.pdf',
                'deal_file_src' => '15545357972_bill.pdf',
                'deal_file_type' => 2,
                'deal_file_date' => '2019-04-06 13:29:58',
                'created_at' => '2019-04-06 07:29:58',
                'updated_at' => '2019-04-06 07:29:58',
            ),
            1 => 
            array (
                'deal_file_id' => 8,
                'deal_file_deal_id' => 2,
                'deal_file_name' => 'кп_komir_kz_06042019_133813_2.pdf',
                'deal_file_src' => 'кп_komir_kz_06042019_133813_2.pdf',
                'deal_file_type' => 1,
                'deal_file_date' => '2019-04-06 13:38:14',
                'created_at' => '2019-04-06 07:38:14',
                'updated_at' => '2019-04-06 07:38:14',
            ),
            2 => 
            array (
                'deal_file_id' => 10,
                'deal_file_deal_id' => 1,
                'deal_file_name' => '15545385971_bill.pdf',
                'deal_file_src' => '15545385971_bill.pdf',
                'deal_file_type' => 2,
                'deal_file_date' => '2019-04-06 14:16:37',
                'created_at' => '2019-04-06 08:16:37',
                'updated_at' => '2019-04-06 08:16:37',
            ),
            3 => 
            array (
                'deal_file_id' => 14,
                'deal_file_deal_id' => 1,
                'deal_file_name' => 'кп_komir_kz_07042019_011233_1.pdf',
                'deal_file_src' => 'кп_komir_kz_07042019_011233_1.pdf',
                'deal_file_type' => 1,
                'deal_file_date' => '2019-04-07 01:12:33',
                'created_at' => '2019-04-06 19:12:33',
                'updated_at' => '2019-04-06 19:12:33',
            ),
            4 => 
            array (
                'deal_file_id' => 15,
                'deal_file_deal_id' => 1,
                'deal_file_name' => 'кп_komir_kz_07042019_011243_1.pdf',
                'deal_file_src' => 'кп_komir_kz_07042019_011243_1.pdf',
                'deal_file_type' => 1,
                'deal_file_date' => '2019-04-07 01:12:43',
                'created_at' => '2019-04-06 19:12:43',
                'updated_at' => '2019-04-06 19:12:43',
            ),
        ));
        
        
    }
}