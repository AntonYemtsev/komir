@extends('admin.layout')

@section('content')
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                {{--<h3 class="page-title">@if($row['deal_template_file_id'] > 0) {{$row['deal_template_file_id']}} @else Добавление нового шаблона файла @endif </h3>--}}
            </div>
        </div>
        <!-- End Page Header -->
        <!-- Default Light Table -->
        <div class="row">
            <div class="col-lg-12 d-flex">
                <div class="col-lg-12 pl-0">
                    <div class="card card-small mb-4 pt-1">
                        <div class="card-header border-bottom text-left">
                            <h5 class="mb-0">Данные</h5>
                        </div>
                        <div class="card-body">
                            @if(isset($result['status']))
                                <p style="color: red; font-size: 14px; text-align: center;">
                                    @if(@count($result['value']) > 0)
                                        @foreach($result['value'] as $key => $error_item)
                                            {{ $error_item }} <br>
                                        @endforeach
                                    @endif
                                </p>
                            @endif

                            <form id="client-contact-form" method="post" enctype="multipart/form-data" action="/admin/deal-template-file-edit/{{$row->deal_template_file_id}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="deal_template_file_id" value="{{$row->deal_template_file_id}}">
                                <div class="form-group">
                                    <label>Тип шаблона файла</label>
                                    <select class="form-control" name="deal_template_type_id">
                                        <option value="0">Выберите тип шаблона файла</option>
                                        <option value="1" @if($row->deal_template_type_id == 1) selected @endif>Коммерческое предложение</option>
                                        <option value="2" @if($row->deal_template_type_id == 2) selected @endif>Счет на оплату</option>
                                        <option value="3" @if($row->deal_template_type_id == 3) selected @endif>Приложение №3</option>
                                        <option value="9" @if($row->deal_template_type_id == 9) selected @endif>Счет на закрытие</option>
                                        <option value="4" @if($row->deal_template_type_id == 4) selected @endif>Email "КП"</option>
                                        <option value="5" @if($row->deal_template_type_id == 5) selected @endif>Email "Счет на оплату"</option>
                                        <option value="10" @if($row->deal_template_type_id == 10) selected @endif>Email "Счет на закрытие"</option>
                                        <option value="6" @if($row->deal_template_type_id == 6) selected @endif>Email "Заявка разрезу"</option>
                                        <option value="7" @if($row->deal_template_type_id == 7) selected @endif>Email "Комментарии по отгрузке"</option>
                                        <option value="8" @if($row->deal_template_type_id == 8) selected @endif>Email "Комментарии по доставке"</option>
                                        <option value="11" @if($row->deal_template_type_id == 11) selected @endif>Email "Договор"</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Тема письма (ТОЛЬКО ДЛЯ EMAIL)</label>
                                    <input type="text" name="deal_template_mail_title" placeholder="" class="form-control" value="{{$row['deal_template_mail_title']}}">
                                </div>

                                <div class="form-group">
                                    <label>HTML шаблон файла</label>
                                    <textarea class="form-control" id="editor1_new" rows="10" name="deal_template_text">{{$row->deal_template_text}}</textarea>
                                </div>

                                <button type="submit" name="submit" id="client-contact-form-submit" class="mb-2 btn btn-primary mr-2">@if($row->deal_template_file_id > 0) Сохранить @else Добавить @endif</button>
                            </form>

                                <p style="margin-top: 30px;">Справочник по коду</p>
                                <table class="table mb-0 clients-table">
                                    <thead class="bg-light">
                                    <tr>
                                        <th scope="col" class="border-0">Наименование</th>
                                        <th scope="col" class="border-0">Код в шаблон</th>
                                    </tr>
                                    </thead>

                                    <tbody>
                                    <?
                                    $code_list = [
                                        ['Имя клиента','client_name'],
                                        ['Фамилия клиента','client_surname'],
                                        ['Телефон клиента','client_phone'],
                                        ['Email клиента','client_email'],
                                        ['Фамилия клиента','client_surname'],
                                        ['Дата и время каждого этапа сделки','deal_datetime1 по deal_datetime10'],
                                        ['Дата и время каждого этапа сделки прописью','deal_datetime1_str по deal_datetime10_str'],
                                        ['Имя ответсвенного каждого этапа','user_name1 по user_name10'],
                                        ['Фамилия ответственного каждого этапа','user_surname1 по user_surname10'],
                                        ['Телефон ответственного','user_phone'],
                                        ['Email ответственного','email'],
                                        ['Разрез','brand_name'],
                                        ['Марка угля','mark_name'],
                                        ['Фракция','fraction_name'],
                                        ['Область','region_name'],
                                        ['Станция','station_name'],
                                        ['Код станции','station_code'],
                                        ['Условия оплаты','payment_name'],
                                        ['Объем в тоннах','deal_volume'],
                                        ['Количество полувагонов','deal_wagon_count'],
                                        ['Фактический объем при отгрузке в тоннах','deal_fact_volume'],
                                        ['Остаток объема в тоннах','deal_rest_volume'],
                                        ['Остаток объема в сумме','deal_rest_volume_in_sum'],
                                        ['Тип скидки (число/процент)','deal_discount_type'],
                                        ['Скидка (в каком размере)','deal_discount'],
                                        ['Срок доставки','delivery_name'],
                                        ['Код получателя','deal_receiver_code'],
                                        ['Сумма в КП','deal_kp_sum'],
                                        ['Сумма в КП прописью','deal_kp_sum_str'],
                                        ['Сумма за 1 тонну','deal_one_tonn_sum'],
                                        ['Дата отгрузки','deal_shipping_date'],
                                        ['Дата отгрузки прописью','deal_shipping_date_str'],
                                        ['Время отгрузки','deal_shipping_time'],
                                        ['Дата доставки','deal_delivery_date'],
                                        ['Дата доставки прописью','deal_delivery_date_str'],
                                        ['Время доставки','deal_delivery_time'],
                                        ['Статус заявки','status_name'],
                                        ['ФИО руководителя','company_ceo_name'],
                                        ['Должность руководителя','company_ceo_position'],
                                        ['Наименование компании','company_name'],
                                        ['Юридический адрес','company_address'],
                                        ['Адрес доставки','company_delivery_address'],
                                        ['ОКПО компании','company_okpo'],
                                        ['Наименование банка компании','company_bank_name'],
                                        ['ИИК','company_bank_iik'],
                                        ['БИН','company_bank_bin'],
                                        ['Номер счета','deal_file_bill_num'],
                                        ['Дата счета','deal_file_date'],
                                        ['Цена за 1 тонну','deal_bill_tonn_sum'],
                                        ['Количество тонн в счете на оплату','deal_bill_volume'],
                                        ['Сумма счета','deal_bill_sum'],
                                        ['Сумма счета прописью','deal_bill_sum_str'],
                                        ['Дата и время комментарии отгрузки','shipping_comment_datetime'],
                                        ['Текси комментарии отгрузки','shipping_client_comment_text'],
                                        ['Фамилия автора комментарии отгрузки','shipping_user_surname'],
                                        ['Имя автора комментарии отгрузки','shipping_user_name'],
                                        ['Дата и время комментарии доставки','delivery_comment_datetime'],
                                        ['Текси комментарии доставки','delivery_client_comment_text'],
                                        ['Фамилия автора комментарии доставки','delivery_user_surname'],
                                        ['Имя автора комментарии доставки','delivery_user_name'],
                                        ['Сумма оплаты разрезу','deal_brand_sum'],
                                        ["ФИО владельца системы","system_info_fio"],
                                        ["Название компании владельца системы","system_info_company_name"],
                                        ["Название банка владельца системы","system_info_bank_name"],
                                        ["ИИК банка владельца системы", "system_info_bank_iik"],
                                        ["БИН банка владельца системы","system_info_bank_bin"],
                                        ["КБЕ банка владельца системы","system_info_bank_kbe"],
                                        ["Код назначения владельца системы","system_info_bank_code"],
                                        ["Юридический адрес владельца системы","system_info_address"],
                                        ["Подпись владельца системы (в виде картинки)","system_info_img"],
                                        ["Комментарии по доставке для клиента","delivery_client_comment_text"],
                                        ["Комментарии по отгрузке для клиента","shipping_client_comment_text"],
                                        ["Наименование компании разреза","brand_company_name"],
                                        ["ФИО руководителя разреза","brand_company_ceo_name"],
                                        ["Номер договора поставки разреза","brand_dogovor_num"],
                                        ["Дата договора поставки разреза","brand_dogovor_date"],
                                        ["Email разреза","brand_email"],
                                        ["Реквизиты разреза","brand_props"]
                                        ];
                                    ?>

                                    @foreach($code_list as $key => $code_item)
                                        <tr>
                                            <td>{{$code_item[0]}}</td>
                                            <td>${<?=$code_item[1]?>}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- End Default Light Table -->
    </div>

    <script>
        editor = CKEDITOR.replace( 'editor1_new', {
            toolbar: [
                { name: 'document', groups: [ 'mode', 'document', 'doctools' ], items: [ 'Source'] },
                { name: 'basicstyles', items : [ 'Bold','Italic','Underline','Strike','-', 'Maximize' ] },
            ],
            forcePasteAsPlainText: true,
            allowedContent: {
                script: true,
                div: true,
                $1: {
                    // This will set the default set of elements
                    attributes: true,
                    styles: true,
                    classes: true
                }
            }
        });
    </script>
@endsection
