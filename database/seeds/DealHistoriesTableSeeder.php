<?php

use Illuminate\Database\Seeder;

class DealHistoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('deal_histories')->delete();
        
        \DB::table('deal_histories')->insert(array (
            0 => 
            array (
                'deal_history_id' => 1,
                'deal_history_deal_id' => 1,
                'deal_history_user_id' => 1,
                'deal_history_datetime' => '2019-03-27 10:41:54',
                'deal_history_text' => '<b>Клиент:</b>  <br><b>Ответственный:</b> Админов Админ<br>',
                'created_at' => '2019-03-27 04:41:54',
                'updated_at' => '2019-03-27 04:41:54',
            ),
            1 => 
            array (
                'deal_history_id' => 2,
                'deal_history_deal_id' => 1,
                'deal_history_user_id' => 1,
                'deal_history_datetime' => '2019-03-27 10:42:08',
                'deal_history_text' => '<b>Разрез:</b> Майкубен<br><b>Марка:</b> Бурый уголь<br><b>Фракция:</b> 0-50 мм<br><b>Объем в тоннах:</b> 1000<br><b>Область:</b> Павлодарская<br><b>Станция:</b> Акыр-Тобе<br><b>Цена за 1 тонну + доставка + НДС:</b> 14035684<br>',
                'created_at' => '2019-03-27 04:42:08',
                'updated_at' => '2019-03-27 04:42:08',
            ),
            2 => 
            array (
                'deal_history_id' => 6,
                'deal_history_deal_id' => 1,
                'deal_history_user_id' => 1,
                'deal_history_datetime' => '2019-03-27 12:04:27',
                'deal_history_text' => '<b>Ответственный:</b> Админов Админ<br><b>Причина отказа:</b> asdasdasd',
                'created_at' => '2019-03-27 06:04:27',
                'updated_at' => '2019-03-27 06:04:27',
            ),
            3 => 
            array (
                'deal_history_id' => 7,
                'deal_history_deal_id' => 2,
                'deal_history_user_id' => 1,
                'deal_history_datetime' => '2019-04-06 12:43:06',
                'deal_history_text' => '<b>Клиент:</b>  <br><b>Ответственный:</b> Админов Админ<br>',
                'created_at' => '2019-04-06 06:43:06',
                'updated_at' => '2019-04-06 06:43:06',
            ),
            4 => 
            array (
                'deal_history_id' => 8,
                'deal_history_deal_id' => 1,
                'deal_history_user_id' => NULL,
                'deal_history_datetime' => '2019-04-06 13:50:22',
                'deal_history_text' => '<b>Тип оплаты:</b> 100 Постоплата<br><b>Срок доставки:</b> 10 дней<br><b>Код получателя:</b> 123<br>',
                'created_at' => '2019-04-06 07:50:22',
                'updated_at' => '2019-04-06 07:50:22',
            ),
            5 => 
            array (
                'deal_history_id' => 9,
                'deal_history_deal_id' => 1,
                'deal_history_user_id' => 1,
                'deal_history_datetime' => '2019-04-06 13:52:43',
                'deal_history_text' => '<b>Цена за 1 тонну + доставка + НДС:</b> 14035684<br>',
                'created_at' => '2019-04-06 07:52:43',
                'updated_at' => '2019-04-06 07:52:43',
            ),
            6 => 
            array (
                'deal_history_id' => 10,
                'deal_history_deal_id' => 1,
                'deal_history_user_id' => NULL,
                'deal_history_datetime' => '2019-04-06 13:57:25',
                'deal_history_text' => '<b>Тип оплаты:</b> 100%<br>',
                'created_at' => '2019-04-06 07:57:25',
                'updated_at' => '2019-04-06 07:57:25',
            ),
            7 => 
            array (
                'deal_history_id' => 11,
                'deal_history_deal_id' => 1,
                'deal_history_user_id' => NULL,
                'deal_history_datetime' => '2019-04-06 13:57:32',
                'deal_history_text' => '<b>Ответственный:</b> Админов Админ<br>',
                'created_at' => '2019-04-06 07:57:32',
                'updated_at' => '2019-04-06 07:57:32',
            ),
            8 => 
            array (
                'deal_history_id' => 12,
                'deal_history_deal_id' => 1,
                'deal_history_user_id' => NULL,
                'deal_history_datetime' => '2019-04-06 13:57:37',
                'deal_history_text' => '<b>Ответственный:</b> Админов Админ<br>',
                'created_at' => '2019-04-06 07:57:37',
                'updated_at' => '2019-04-06 07:57:37',
            ),
            9 => 
            array (
                'deal_history_id' => 13,
                'deal_history_deal_id' => 1,
                'deal_history_user_id' => NULL,
                'deal_history_datetime' => '2019-04-06 14:10:18',
                'deal_history_text' => '<b>Сумма оплаты:</b> 50000<br><b>Ответственный:</b> Админов Админ<br>',
                'created_at' => '2019-04-06 08:10:18',
                'updated_at' => '2019-04-06 08:10:18',
            ),
            10 => 
            array (
                'deal_history_id' => 14,
                'deal_history_deal_id' => 1,
                'deal_history_user_id' => NULL,
                'deal_history_datetime' => '2019-04-06 14:10:31',
                'deal_history_text' => '<b>Дата отгрузки:</b> 03.04.2019<br><b>Время отгрузки:</b> 10:40<br><b>Ответственный:</b> Админов Админ<br>',
                'created_at' => '2019-04-06 08:10:31',
                'updated_at' => '2019-04-06 08:10:31',
            ),
            11 => 
            array (
                'deal_history_id' => 15,
                'deal_history_deal_id' => 1,
                'deal_history_user_id' => NULL,
                'deal_history_datetime' => '2019-04-06 14:11:38',
                'deal_history_text' => '<b>Дата доставки:</b> 22.04.2019<br><b>Время доставки:</b> 10:40<br><b>Ответственный:</b> Админов Админ<br>',
                'created_at' => '2019-04-06 08:11:38',
                'updated_at' => '2019-04-06 08:11:38',
            ),
            12 => 
            array (
                'deal_history_id' => 16,
                'deal_history_deal_id' => 1,
                'deal_history_user_id' => NULL,
                'deal_history_datetime' => '2019-04-06 14:13:23',
                'deal_history_text' => '<b>Ответственный:</b> Админов Админ<br>',
                'created_at' => '2019-04-06 08:13:23',
                'updated_at' => '2019-04-06 08:13:23',
            ),
            13 => 
            array (
                'deal_history_id' => 17,
                'deal_history_deal_id' => 1,
                'deal_history_user_id' => NULL,
                'deal_history_datetime' => '2019-04-06 15:44:11',
                'deal_history_text' => '<b>Дата отгрузки:</b> 04.03.2019<br>',
                'created_at' => '2019-04-06 09:44:11',
                'updated_at' => '2019-04-06 09:44:11',
            ),
            14 => 
            array (
                'deal_history_id' => 18,
                'deal_history_deal_id' => 1,
                'deal_history_user_id' => NULL,
                'deal_history_datetime' => '2019-04-06 15:45:04',
                'deal_history_text' => '<b>Дата отгрузки:</b> 03.04.2019<br>',
                'created_at' => '2019-04-06 09:45:04',
                'updated_at' => '2019-04-06 09:45:04',
            ),
            15 => 
            array (
                'deal_history_id' => 19,
                'deal_history_deal_id' => 1,
                'deal_history_user_id' => NULL,
                'deal_history_datetime' => '2019-04-06 15:46:15',
                'deal_history_text' => '<b>Дата отгрузки:</b> 04.03.2019<br>',
                'created_at' => '2019-04-06 09:46:15',
                'updated_at' => '2019-04-06 09:46:15',
            ),
            16 => 
            array (
                'deal_history_id' => 20,
                'deal_history_deal_id' => 1,
                'deal_history_user_id' => NULL,
                'deal_history_datetime' => '2019-04-06 15:46:46',
                'deal_history_text' => '<b>Дата отгрузки:</b> 03.04.2019<br>',
                'created_at' => '2019-04-06 09:46:46',
                'updated_at' => '2019-04-06 09:46:46',
            ),
            17 => 
            array (
                'deal_history_id' => 21,
                'deal_history_deal_id' => 1,
                'deal_history_user_id' => NULL,
                'deal_history_datetime' => '2019-04-06 15:49:36',
                'deal_history_text' => '<b>Дата отгрузки:</b> 04.03.2019<br>',
                'created_at' => '2019-04-06 09:49:36',
                'updated_at' => '2019-04-06 09:49:36',
            ),
            18 => 
            array (
                'deal_history_id' => 22,
                'deal_history_deal_id' => 1,
                'deal_history_user_id' => NULL,
                'deal_history_datetime' => '2019-04-06 15:50:42',
                'deal_history_text' => '<b>Дата отгрузки:</b> 03.04.2019<br>',
                'created_at' => '2019-04-06 09:50:42',
                'updated_at' => '2019-04-06 09:50:42',
            ),
            19 => 
            array (
                'deal_history_id' => 23,
                'deal_history_deal_id' => 1,
                'deal_history_user_id' => 1,
                'deal_history_datetime' => '2019-04-07 01:22:26',
                'deal_history_text' => '<b>Станция:</b> Маралды<br><b>Цена за 1 тонну + доставка + НДС:</b> 10164284<br>',
                'created_at' => '2019-04-06 19:22:26',
                'updated_at' => '2019-04-06 19:22:26',
            ),
            20 => 
            array (
                'deal_history_id' => 24,
                'deal_history_deal_id' => 1,
                'deal_history_user_id' => 1,
                'deal_history_datetime' => '2019-04-07 01:29:42',
                'deal_history_text' => '<b>Область:</b> Атырауская<br><b>Станция:</b> Макат<br><b>Цена за 1 тонну + доставка + НДС:</b> 14930968<br>',
                'created_at' => '2019-04-06 19:29:42',
                'updated_at' => '2019-04-06 19:29:42',
            ),
            21 => 
            array (
                'deal_history_id' => 25,
                'deal_history_deal_id' => 1,
                'deal_history_user_id' => 1,
                'deal_history_datetime' => '2019-04-07 10:39:15',
                'deal_history_text' => '<b>Ответственный:</b> Админов Админ<br><b>Причина отказа:</b> asdsadsa',
                'created_at' => '2019-04-07 04:39:15',
                'updated_at' => '2019-04-07 04:39:15',
            ),
        ));
        
        
    }
}