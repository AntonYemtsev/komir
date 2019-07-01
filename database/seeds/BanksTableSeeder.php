<?php

use Illuminate\Database\Seeder;

class BanksTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('banks')->delete();
        
        \DB::table('banks')->insert(array (
            0 => 
            array (
                'bank_id' => 1,
                'bank_bik' => 'ABNAKZKX',
                'bank_name' => 'АО "First Heartland Bank"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            1 => 
            array (
                'bank_id' => 2,
                'bank_bik' => 'ALFAKZKA',
                'bank_name' => 'АО "Дочерний Банк "АЛЬФА-БАНК"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            2 => 
            array (
                'bank_id' => 3,
                'bank_bik' => 'ALMNKZKA',
                'bank_name' => 'АО "АТФБанк"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            3 => 
            array (
                'bank_id' => 4,
                'bank_bik' => 'ASFBKZKA',
                'bank_name' => 'АО "Банк "Астаны"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            4 => 
            array (
                'bank_id' => 5,
                'bank_bik' => 'ATYNKZKA',
            'bank_name' => 'АО "Altyn Bank" (ДБ China Citic Bank Corporation Limited)',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            5 => 
            array (
                'bank_id' => 6,
                'bank_bik' => 'BKCHKZKA',
                'bank_name' => 'АО ДБ "БАНК КИТАЯ В КАЗАХСТАНЕ"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            6 => 
            array (
                'bank_id' => 7,
                'bank_bik' => 'CASPKZKA',
                'bank_name' => 'АО "KASPI BANK"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            7 => 
            array (
                'bank_id' => 8,
                'bank_bik' => 'CEDUKZKA',
                'bank_name' => 'АО "Центральный Депозитарий Ценных Бумаг"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            8 => 
            array (
                'bank_id' => 9,
                'bank_bik' => 'CITIKZKA',
                'bank_name' => 'АО "Ситибанк Казахстан"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            9 => 
            array (
                'bank_id' => 10,
                'bank_bik' => 'DVKAKZKA',
                'bank_name' => 'АО "Банк Развития Казахстана"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            10 => 
            array (
                'bank_id' => 11,
                'bank_bik' => 'EABRKZKA',
                'bank_name' => 'ЕВРАЗИЙСКИЙ БАНК РАЗВИТИЯ',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            11 => 
            array (
                'bank_id' => 12,
                'bank_bik' => 'EURIKZKA',
                'bank_name' => 'АО "Евразийский Банк"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            12 => 
            array (
                'bank_id' => 13,
                'bank_bik' => 'EXKAKZKA',
                'bank_name' => 'АО "ЭКСИМБАНК КАЗАХСТАН"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            13 => 
            array (
                'bank_id' => 14,
                'bank_bik' => 'GCVPKZ2A',
                'bank_name' => 'НАО Государственная корпорация "Правительство для граждан"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            14 => 
            array (
                'bank_id' => 15,
                'bank_bik' => 'HCSKKZKA',
                'bank_name' => 'АО "Жилстройсбербанк Казахстана"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            15 => 
            array (
                'bank_id' => 16,
                'bank_bik' => 'HLALKZKZ',
                'bank_name' => 'АО "Исламский Банк "Al Hilal"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            16 => 
            array (
                'bank_id' => 17,
                'bank_bik' => 'HSBKKZKX',
                'bank_name' => 'АО "Народный Банк Казахстана"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            17 => 
            array (
                'bank_id' => 18,
                'bank_bik' => 'ICBKKZKX',
                'bank_name' => 'АО "Торгово-промышленный Банк Китая в г. Алматы"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            18 => 
            array (
                'bank_id' => 19,
                'bank_bik' => 'INEARUMM',
                'bank_name' => 'г.Москва Межгосударственный Банк',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            19 => 
            array (
                'bank_id' => 20,
                'bank_bik' => 'INLMKZKA',
                'bank_name' => 'ДБ АО "Хоум Кредит энд Финанс Банк"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            20 => 
            array (
                'bank_id' => 21,
                'bank_bik' => 'IRTYKZKA',
                'bank_name' => 'АО "ForteBank"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            21 => 
            array (
                'bank_id' => 22,
                'bank_bik' => 'KCJBKZKX',
                'bank_name' => 'АО "Банк ЦентрКредит"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            22 => 
            array (
                'bank_id' => 23,
                'bank_bik' => 'KICEKZKX',
                'bank_name' => 'АО "Казахстанская фондовая биржа"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            23 => 
            array (
                'bank_id' => 24,
                'bank_bik' => 'KINCKZKA',
                'bank_name' => 'АО "Банк "Bank RBK"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            24 => 
            array (
                'bank_id' => 25,
                'bank_bik' => 'KISCKZKX',
                'bank_name' => 'РГП "Казахстанский центр межбанковских расчетов НБРК"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            25 => 
            array (
                'bank_id' => 26,
                'bank_bik' => 'KKMFKZ2A',
                'bank_name' => 'РГУ "Комитет казначейства Министерства финансов РК"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            26 => 
            array (
                'bank_id' => 27,
                'bank_bik' => 'KPSTKZKA',
                'bank_name' => 'АО "КАЗПОЧТА"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            27 => 
            array (
                'bank_id' => 28,
                'bank_bik' => 'KSNVKZKA',
                'bank_name' => 'АО "Банк Kassa Nova"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            28 => 
            array (
                'bank_id' => 29,
                'bank_bik' => 'KZIBKZKA',
                'bank_name' => 'АО "ДБ "КАЗАХСТАН-ЗИРААТ ИНТЕРНЕШНЛ БАНК"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            29 => 
            array (
                'bank_id' => 30,
                'bank_bik' => 'KZKOKZKX',
                'bank_name' => 'АО "КАЗКОММЕРЦБАНК"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            30 => 
            array (
                'bank_id' => 31,
                'bank_bik' => 'LARIKZKA',
            'bank_name' => 'АО "AsiaCredit Bank (АзияКредит Банк)"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            31 => 
            array (
                'bank_id' => 32,
                'bank_bik' => 'NBPAKZKA',
                'bank_name' => 'АО ДБ "Национальный Банк Пакистана" в Казахстане',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            32 => 
            array (
                'bank_id' => 33,
                'bank_bik' => 'NBPFKZKX',
                'bank_name' => '"Банк-кастодиан АО  "ЕНПФ"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            33 => 
            array (
                'bank_id' => 34,
                'bank_bik' => 'NBRKKZKX',
                'bank_name' => 'РГУ Национальный Банк Республики Казахстан',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            34 => 
            array (
                'bank_id' => 35,
                'bank_bik' => 'NURSKZKX',
                'bank_name' => 'АО "Нурбанк"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            35 => 
            array (
                'bank_id' => 36,
                'bank_bik' => 'SABRKZKA',
                'bank_name' => 'ДБ АО "Сбербанк"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            36 => 
            array (
                'bank_id' => 37,
                'bank_bik' => 'SENIKZKA',
                'bank_name' => 'АО "Qazaq Banki"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            37 => 
            array (
                'bank_id' => 38,
                'bank_bik' => 'SHBKKZKA',
                'bank_name' => 'АО "Шинхан Банк Казахстан"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            38 => 
            array (
                'bank_id' => 39,
                'bank_bik' => 'TBKBKZKA',
                'bank_name' => 'АО "Capital Bank Kazakhstan"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            39 => 
            array (
                'bank_id' => 40,
                'bank_bik' => 'TNGRKZKX',
                'bank_name' => 'АО "Tengri Bank"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            40 => 
            array (
                'bank_id' => 41,
                'bank_bik' => 'TSESKZKA',
                'bank_name' => 'АО "Цеснабанк"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            41 => 
            array (
                'bank_id' => 42,
                'bank_bik' => 'VTBAKZKZ',
            'bank_name' => 'ДО АО Банк ВТБ (Казахстан)',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
            42 => 
            array (
                'bank_id' => 43,
                'bank_bik' => 'ZAJSKZ22',
                'bank_name' => 'АО "Исламский банк "Заман-Банк"',
                'created_at' => NULL,
                'updated_at' => NULL,
            ),
        ));
        
        
    }
}