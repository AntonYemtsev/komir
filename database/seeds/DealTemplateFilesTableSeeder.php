<?php

use Illuminate\Database\Seeder;

class DealTemplateFilesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('deal_template_files')->delete();
        
        \DB::table('deal_template_files')->insert(array (
            0 => 
            array (
                'deal_template_file_id' => 1,
                'deal_template_type_id' => 1,
                'deal_template_text' => '<style type="text/css">@page { size: 655pt 842pt; }
html,body{margin: 15px 0}
</style>
<div style="background-color:white; box-sizing:border-box; font-family:Roboto; font-size:12pt; padding:.7cm .7cm .7cm 1.5cm; width:100%">
<div style="font-size:0; width:100%">
<div style="display:inline-block; text-align:left; width:55%">
<p style="font-size:14px">ТОО &laquo;IBR Trade&raquo;<br />
БИН: 181040018486<br />
050043, г.Алматы, ул.Жандосова, 204<br />
+7 (727) 258-10-64, +7 (701) 266-47-77<br />
info@komir.kz<br />
www.komir.kz</p>
</div>

<div style="display:inline-block; font-size:0; padding-top:50px; text-align:right; width:40%"><img src="http://localhost:7777/admin/images/ezgif.com-gif-maker.png" /></div>
</div>

<p style="display:inline-block; padding:0px 0 20px; width:100%"><strong>&laquo;14&raquo; февраля 2019 г.</strong></p>

<p style="font-size:18pt; text-align:center"><strong>Коммерческое предложение</strong></p>

<table style="width: 100%; border-collapse: collapse; border: 1px solid black; margin-bottom: .5cm">
<tbody>
<tr style="border: 1px solid black; border: 0">
<td style="border:1px solid black; padding:0.2cm 0.5cm; width:25%">
<p><strong>Заказчик</strong></p>
</td>
<td style="border:1px solid black; padding:0.2cm 0.5cm; width:75%">
<p>${client_surname}&nbsp;${client_name}</p>
</td>
</tr>
<tr style="border: 1px solid black; border: 0; border-top: 0">
<td style="border:1px solid black; padding:0.2cm 0.5cm; width:25%">
<p><strong>Предмет</strong></p>
</td>
<td style="border:1px solid black; padding:0.2cm 0.5cm; width:75%">
<p>Предложение по закупу угля</p>
</td>
</tr>
<tr style="border: 1px solid black; border: 0; border-top: 0">
<td style="border:1px solid black; padding:0.2cm 0.5cm; width:25%">
<p><strong>Цена (тг/тонна)</strong></p>
</td>
<td style="border:1px solid black; padding:0.2cm 0.5cm; width:75%">
<p>12 500 с НДС</p>
</td>
</tr>
</tbody>
</table>

<table style="width: 100%; border-collapse: collapse; border: 1px solid black">
<tbody>
<tr style="border: 1px solid black; border: 0">
<td style="border:1px solid black; padding:0.2cm 0.5cm; width:25%">
<p><strong>Уголь</strong></p>
</td>
<td style="border:1px solid black; padding:0.2cm 0.5cm; width:75%">
<p>Марка Б класса майкубенский</p>
</td>
</tr>
<tr style="border: 1px solid black; border: 0; border-top: 0">
<td style="border:1px solid black; padding:0.2cm 0.5cm; width:25%">
<p><strong>Крупность</strong></p>
</td>
<td style="border:1px solid black; padding:0.2cm 0.5cm; width:75%">
<p>50-200 (сорт)</p>
</td>
</tr>
<tr style="border: 1px solid black; border: 0; border-top: 0">
<td style="border:1px solid black; padding:0.2cm 0.5cm; width:25%">
<p><strong>Доставка</strong></p>
</td>
<td style="border:1px solid black; padding:0.2cm 0.5cm; width:75%">
<p>Самовывоз (Павлодарский Речной Порт)</p>

<p>г. Павлодар, Северная промзона, строение 197</p>
</td>
</tr>
</tbody>
</table>

<div style="margin-top:30px; width:100%">
<div style="display:inline-block; text-align:left; width:45%">
<p><strong>С уважением,</strong></p>

<p><strong>Генеральный директор</strong></p>
</div>

<div style="display:inline-block; text-align:right; width:45%">
<p><strong>&nbsp;</strong></p>

<p><strong>Какимжанов И.З</strong></p>
</div>
</div>
</div>',
                'created_at' => '2019-03-14 12:07:23',
                'updated_at' => '2019-03-26 06:00:56',
            ),
            1 => 
            array (
                'deal_template_file_id' => 2,
                'deal_template_type_id' => 2,
                'deal_template_text' => '<style type="text/css">@page { size: 655pt 842pt; }
html,body{margin: 15px 0}
</style>
<div style="background-color:white; box-sizing:border-box; font-family:Roboto; font-size:11pt; padding:.7cm .7cm .7cm 1.5cm; width:100%">
<div style="font-size:9pt; text-align:right">
<p>Внимание! Оплата данного счета означает согласие с условиями поставки товара. Уведомление об оплате<br />
обязательно, в противном случае не гарантируется наличие товара на складе. Товар отпускается по факту<br />
прихода денег на р/с Поставщика, самовывозом, при наличии доверенности и документов удостоверяющих<br />
личность.</p>
</div>

<p>&nbsp;</p>

<p><strong>Образец платежного поручения</strong></p>

<table style="width: 100%; border-collapse: collapse; ">
<tbody>
<tr style="border: 2px solid black; border: 0; vertical-align: text-top;">
<td style="border:2px solid black; padding:0.05cm; width:50%">
<p><strong>Бенефециар: </strong></p>

<p>${company_name}</p>

<p>БИН: ${company_bank_bin}</p>
</td>
<td style="border:2px solid black; padding:0.05cm; width:25%">
<p><strong>ИИК</strong></p>

<p>KZ7196502F0009922251</p>
</td>
<td style="border:2px solid black; padding:0.05cm; width:25%">
<p><strong>Кбе</strong></p>

<p>17</p>
</td>
</tr>
<tr style="border: 2px solid black; border: 0; border-top: 0; vertical-align: text-top;">
<td style="border:2px solid black; padding:0.05cm; width:50%">
<p><strong>Банк бенефициара: </strong></p>

<p>АО &quot;Forte Bank&quot;</p>
</td>
<td style="border:2px solid black; padding:0.05cm; width:25%">
<p><strong>БИК</strong></p>

<p>IRTYKZKA</p>
</td>
<td style="border:2px solid black; padding:0.05cm; width:25%">
<p><strong>Код назначения платежа</strong></p>

<p>710</p>
</td>
</tr>
</tbody>
</table>

<p>&nbsp;</p>

<div style="border-bottom:2px solid black">
<p style="font-size:16pt"><strong>Счет на оплату № 04 от 18 февраля 2019 г.</strong></p>
</div>

<p style="margin-bottom:15px; margin-left:0.5cm; margin-right:0.5cm; margin-top:15px"><strong>Поставщик: </strong>БИН: ${company_bank_bin}, ТОО &quot;IBR Trade&quot;, г. Алматы, ул. Жандосова дом,204</p>

<p><strong>Покупатель: </strong>БИН: 130340000702, ТОО Заказчика, Юр.адрес заказчика</p>

<p><strong>Основание:</strong></p>

<table style="width: 100%; border-collapse: collapse; border: 2px solid black">
<tbody>
<tr style="border: 2px solid black; border: 0; text-align: center;">
<td style="border:2px solid black; padding:0.2cm">
<p><strong>№</strong></p>
</td>
<td style="border:2px solid black; padding:0.2cm">
<p><strong>Код</strong></p>
</td>
<td style="border:2px solid black; padding:0.2cm; width:35%">
<p><strong>Наименование</strong></p>
</td>
<td style="border:2px solid black; padding:0.2cm">
<p><strong>Кол-во</strong></p>
</td>
<td style="border:2px solid black; padding:0.2cm">
<p><strong>Ед.</strong></p>
</td>
<td style="border:2px solid black; padding:0.2cm; width:18%">
<p><strong>Цена</strong></p>
</td>
<td style="border:2px solid black; padding:0.2cm; width:18%">
<p><strong>Сумма</strong></p>
</td>
</tr>
<tr style="border: 2px solid black; border: 0; border-top: 0">
<td style="border:2px solid black; padding:0.2cm">
<p>1</p>
</td>
<td style="border:2px solid black; padding:0.2cm">
<p>&nbsp;</p>
</td>
<td style="border:2px solid black; padding:0.2cm; width:35%">
<p>Уголь марки Б фракции 50-200</p>
</td>
<td style="border:2px solid black; padding:0.2cm; text-align:right">
<p>300,000</p>
</td>
<td style="border:2px solid black; padding:0.2cm">
<p>тн</p>
</td>
<td style="border:2px solid black; padding:0.2cm; text-align:right; width:18%">
<p>11 000,00</p>
</td>
<td style="border:2px solid black; padding:0.2cm; text-align:right; width:18%">
<p>3 300 000,00</p>
</td>
</tr>
</tbody>
</table>

<div style="text-align:right">
<p><strong>Итого: &nbsp;&nbsp;&nbsp;3 300 000,00</strong></p>
</div>

<div style="border-bottom:2px solid black; margin-top:.5cm">
<p>Всего наименований 1, на сумму 3 300 000,00 KZT</p>

<p><strong>Всего к оплате: Три миллиона триста тысяч тенге 00 тиын</strong></p>
</div>

<p style="margin-top:.5cm"><strong>Исполнитель</strong> &nbsp;&nbsp; ________________________&nbsp;/бухгалтер/</p>
</div>',
                'created_at' => NULL,
                'updated_at' => '2019-03-25 01:20:22',
            ),
            2 => 
            array (
                'deal_template_file_id' => 3,
                'deal_template_type_id' => 3,
                'deal_template_text' => '<style type="text/css">@page { size:  842pt 655pt; }
html,body{margin: 15px 0}
</style>
<div style="background-color:white; box-sizing:border-box; font-size:12pt; padding:.7cm .7cm .7cm 1.5cm; width:100%">
<div style="text-align:right">
<p>Приложение № 3</p>

<p>к договору поставки № ______________</p>

<p>от &laquo;____&raquo;_______________ 2018 года</p>
</div>

<p>&nbsp;</p>

<p style="text-indent:1.5cm">Кому: Директору ТОО &laquo;Maikuben company&raquo; ${client_surname}&nbsp;${client_name}</p>

<p style="text-indent:1.5cm">От кого: Генерального директора ТОО &ldquo;IBR Trade&rdquo; Какимжанова И.З</p>

<p style="text-indent:1.5cm">Дата: <u>14/01/2018</u></p>

<p>&nbsp;</p>

<p style="text-align:center"><strong>Заявка на отгрузку</strong></p>

<p style="text-indent:1.5cm">На основании заключенного договора просим Вас произвести отгрузку продукции по нижеуказанным реквизитам.</p>

<p>&nbsp;</p>

<table style="width: 100%; border-collapse: collapse;">
<tbody>
<tr style="border: 1px solid black; border-right: 0">
<td style="border:1px solid black; padding:0.2cm">
<p>Грузополучатель (наименование, БИН (ИИН)(особые отметки)</p>
</td>
<td style="border:1px solid black; padding:0.2cm">
<p>Станция</p>
</td>
<td style="border:1px solid black; padding:0.2cm">
<p>Код станции</p>
</td>
<td style="border:1px solid black; padding:0.2cm">
<p>Адрес</p>
</td>
<td style="border:1px solid black; padding:0.2cm">
<p>Код получателя (4-хзначный или 12-тизначный)</p>
</td>
<td style="border:1px solid black; padding:0.2cm">
<p>ОКПО</p>
</td>
<td style="border:1px solid black; padding:0.2cm">
<p>Кол-во п/в</p>
</td>
<td style="border:1px solid black; padding:0.2cm">
<p>Фракция</p>
</td>
</tr>
<tr style="border: 1px solid black; border-right: 0; border-top: 0">
<td style="border:1px solid black; padding:0.2cm">
<p><strong>АО &laquo;Павлодарский речной порт&raquo;</strong></p>

<p><strong>БИН 940140001393</strong></p>
</td>
<td style="border:1px solid black; padding:0.2cm">
<p><strong>Павлодар Порт, Павлодарская область</strong></p>
</td>
<td style="border:1px solid black; padding:0.2cm">
<p><strong>696403</strong></p>
</td>
<td style="border:1px solid black; padding:0.2cm">
<p><strong>140004 г.Павлодар, Северная промзона, Строение 197</strong></p>
</td>
<td style="border:1px solid black; padding:0.2cm">
<p>4-хзначный:</p>

<p>6621</p>
</td>
<td style="border:1px solid black; padding:0.2cm">
<p><strong>03150869</strong></p>
</td>
<td style="border:1px solid black; padding:0.2cm">
<p><strong>5 </strong></p>
</td>
<td style="border:1px solid black; padding:0.2cm">
<p><strong>Уголь Марки Б класса крупности 0-300мм (ковш)</strong></p>
</td>
</tr>
<tr style="border: 1px solid black; border-right: 0; border-top: 0">
<td style="border:1px solid black; padding:0.2cm">
<p><strong>АО &laquo;Павлодарский речной порт&raquo;</strong></p>

<p><strong>БИН 940140001393</strong></p>
</td>
<td style="border:1px solid black; padding:0.2cm">
<p><strong>Павлодар Порт, Павлодарская область</strong></p>
</td>
<td style="border:1px solid black; padding:0.2cm">
<p><strong>696403</strong></p>
</td>
<td style="border:1px solid black; padding:0.2cm">
<p><strong>140004 г.Павлодар, Северная промзона, Строение 197</strong></p>
</td>
<td style="border:1px solid black; padding:0.2cm">
<p>4-хзначный:</p>

<p>6621</p>
</td>
<td style="border:1px solid black; padding:0.2cm">
<p><strong>03150869</strong></p>
</td>
<td style="border:1px solid black; padding:0.2cm">
<p><strong>5 </strong></p>
</td>
<td style="border:1px solid black; padding:0.2cm">
<p><strong>Уголь Марки Б класса крупности 0-300мм (ковш)</strong></p>
</td>
</tr>
</tbody>
</table>

<p>&nbsp;</p>

<p style="text-indent:1.5cm">В удостоверение полного согласия с содержанием Приложения 3 Договора его подписал:</p>

<p>&nbsp;</p>

<p style="text-indent:2.5cm">От Покупателя:</p>

<p style="text-indent:2.5cm">________________________</p>

<p>&nbsp;</p>

<p style="text-indent:1.5cm">М.п.</p>
</div>',
                'created_at' => NULL,
                'updated_at' => '2019-03-18 02:45:29',
            ),
        ));
        
        
    }
}