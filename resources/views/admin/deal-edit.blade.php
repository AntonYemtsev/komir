@extends('admin.layout')

@section('content')
    <style>
        label.error, input.error, textarea.error, select.error{height: auto;}
        input.error, textarea.error, select.error{height: auto; border: 1px solid red;}
    </style>
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <!--Timeline-->
        <ul class="timeline pl-0 mt-3 mb-0" id="timeline">
            <li class="li deal-status deal-status-li1 @if($row['deal_status_id'] > 1 && $row['deal_status_id'] != 12) complete @elseif($row['deal_status_id'] == 1) current @endif" data-deal-stage="deal-card-1">
                <div class="timestamp">
                </div>
                <div class="status" id="status1">
                    <p>Заявка</p>
                </div>
            </li>
            <li class="li deal-status deal-status-li2 @if($row['deal_status_id'] > 2 && $row['deal_status_id'] != 12) complete @elseif($row['deal_status_id'] == 2) current @endif" data-deal-stage="deal-card-2">
                <div class="timestamp">
                </div>
                <div class="status" id="status2">
                    <p>Расчет КП</p>
                </div>
            </li>
            <li class="li deal-status deal-status-li3 @if($row['deal_status_id'] > 3 && $row['deal_status_id'] != 12) complete @elseif($row['deal_status_id'] == 3) current @endif" data-deal-stage="deal-card-3">
                <div class="timestamp">
                </div>
                <div class="status" id="status3">
                    <p>Переговоры</p>
                </div>
            </li>
            <li class="li deal-status deal-status-li4 @if($row['deal_status_id'] > 4 && $row['deal_status_id'] != 12) complete @elseif($row['deal_status_id'] == 4) current @endif" data-deal-stage="deal-card-4">
                <div class="timestamp">
                </div>
                <div class="status" id="status4">
                    <p>Договор</p>
                </div>
            </li>
            <li class="li deal-status deal-status-li5 @if($row['deal_status_id'] > 5 && $row['deal_status_id'] != 12) complete @elseif($row['deal_status_id'] == 5) current @endif" data-deal-stage="deal-card-5">
                <div class="timestamp">
                </div>
                <div class="status" id="status5">
                    <p>Счет на оплату</p>
                </div>
            </li>
            <li class="li deal-status deal-status-li6 @if($row['deal_status_id'] > 6 && $row['deal_status_id'] != 12) complete @elseif($row['deal_status_id'] == 6) current @endif" data-deal-stage="deal-card-6">
                <div class="timestamp">
                </div>
                <div class="status" id="status6">
                    <p>Заявка разрезу</p>
                </div>
            </li>
            <li class="li deal-status deal-status-li7 @if($row['deal_status_id'] > 7 && $row['deal_status_id'] != 12) complete @elseif($row['deal_status_id'] == 7) current @endif" data-deal-stage="deal-card-7">
                <div class="timestamp">
                </div>
                <div class="status" id="status7">
                    <p>Оплата разрезу</p>
                </div>
            </li>
            <li class="li deal-status deal-status-li8 @if($row['deal_status_id'] > 8 && $row['deal_status_id'] != 12) complete @elseif($row['deal_status_id'] == 8) current @endif" data-deal-stage="deal-card-8">
                <div class="timestamp">
                </div>
                <div class="status" id="status8">
                    <p>Отгрузка</p>
                </div>
            </li>
            <li class="li deal-status deal-status-li9 @if($row['deal_status_id'] > 9 && $row['deal_status_id'] != 12) complete @elseif($row['deal_status_id'] == 9) current @endif" data-deal-stage="deal-card-9">
                <div class="timestamp">
                </div>
                <div class="status" id="status9">
                    <p>Доставка</p>
                </div>
            </li>
            <li class="li deal-status deal-status-li10 @if($row['deal_status_id'] > 10 && $row['deal_status_id'] != 12) complete @elseif($row['deal_status_id'] == 10) current @endif" data-deal-stage="deal-card-10">
                <div class="timestamp">
                </div>
                <div class="status" id="status10">
                    <p>Закрытие</p>
                </div>
            </li>
        </ul>
        <!--/Timeline-->
        <!--Main content-->
        <div class="deal-card-wrapper dragscroll scroller">
            <div class="d-flex" style="width: auto; position: relative;">
                <div class="deal-card-single-wrapper" id="deal-card-1">
                    <div class="deal-card-single card card-small mb-4 pt-1 @if($row['deal_status_id'] == 1) current @endif">
                        <form id="deal-card-1-form" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" value="{{$row['deal_id']}}" name="deal_id" class="deal-id-hidden">
                            <input type="hidden" value="1" name="deal_status_id">
                            <div class="card-header text-left">
                                <h5 class="mb-0">Заявка</h5>
                                <div class="d-flex flex-wrap no-gutters mt-2">
                                    <div class="col-12">
                                        <span>ОТВЕТСТВЕННЫЙ</span>
                                        <select name="deal_user_id1" class="form-control select2-search">
                                            <option value="0">Выберите ответственного</option>
                                            @if(@count($user_list) > 0)
                                                @foreach($user_list as $key => $user_item)
                                                    <option value="{{$user_item['user_id']}}" @if($user_item['user_id'] == $row['deal_user_id1']) selected @endif>{{$user_item['user_surname']}} {{$user_item['user_name']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p id="deal-card-1-responsible"></p>
                                    </div>
                                    <div class="col-12">
                                        <span>ДАТА СОЗДАНИЯ</span>
                                        <p id="deal-card-1-date">{{$row['deal_datetime1_format']}}</p>
                                    </div>
                                </div>
                                <div class="rounded col-12 mt-3 py-2" style="background-color: #EA5876"></div>
                            </div>
                            <div class="card-body">
                                <span style="color: #007bff;border-bottom: 1px dotted #007bff;cursor: pointer;font-size:14px;" onclick="addNewClient()">+ Добавить</span>
                                <span style="color: #007bff;border-bottom: 1px dotted #007bff;cursor: pointer;font-size:14px;float: right;" onclick="showClientSelectBlock()">Выбрать из списка</span>
                                <div class="form-group flex-wrap align-items-center justify-content-between client-select-block" style="display: none;">
                                    <label for="deal-card-1-form-name">ФИО Клиента *</label>
                                    <select class="form-control select2-search" id="client_id_list" onchange="setClientInfo(this)">
                                        <option value="0">Выберите клиента</option>
                                        @if(@count($client_list) > 0)
                                            @foreach($client_list as $key => $client_item)
                                                <option value="{{$client_item['client_id']}}" data-client-id="{{$client_item['client_id']}}" data-client-email="{{$client_item['client_email']}}" data-client-phone="{{$client_item['client_phone']}}" data-client-fio="{{$client_item['client_surname']}} {{$client_item['client_name']}}">{{$client_item['client_surname']}} {{$client_item['client_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group d-flex flex-wrap align-items-center justify-content-between mt-2">
                                    <input type="hidden" name="deal_client_id" value="{{$row['deal_client_id']}}" id="deal_client_id">
                                    <label for="deal-card-1-form-name">Имя *</label>
                                    <input type="text" name="client_fio" id="deal-card-1-form-name" placeholder="" class="form-control deal-client-input" value="{{$row['client_surname']}} {{$row['client_name']}}">
                                </div>
                                <div class="form-group">
                                    <label for="deal-card-1-form-phone">Телефон *</label>
                                    <input type="text" name="client_phone" id="deal-card-1-form-phone" placeholder="" class="form-control deal-client-input" value="{{$row['client_phone']}}">
                                </div>
                                <div class="form-group">
                                    <label for="deal-card-1-form-email">Email</label>
                                    <input type="text" name="client_email" id="deal-card-1-form-email" placeholder="" class="form-control deal-client-input" value="{{$row['client_email']}}">
                                </div>
                                <button type="button" onclick="sendDealForm(1)" name="submit" id="deal-card-1-form-submit" class="mb-2 mt-2 btn btn-primary mr-2">Далее</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="deal-card-single-wrapper" id="deal-card-2">
                    <div class="deal-card-single card card-small mb-4 pt-1 @if($row['deal_status_id'] == 2) current @endif">
                        <form id="deal-card-2-form" class="deal-card-2-kp-form" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" value="{{$row['deal_id']}}" name="deal_id" class="deal-id-hidden">
                            <input type="hidden" value="2" name="deal_status_id">
                            <div class="card-header text-left">
                                <h5 class="mb-0">Расчет КП</h5>
                                <div class="d-flex flex-wrap no-gutters mt-2">
                                    <div class="col-12">
                                        <span>ОТВЕТСТВЕННЫЙ</span>
                                        <select name="deal_user_id2" class="form-control select2-search" id="deal_user_id2">
                                            <option value="0">Выберите ответственного</option>
                                            @if(@count($user_list) > 0)
                                                @foreach($user_list as $key => $user_item)
                                                    <option value="{{$user_item['user_id']}}" @if($user_item['user_id'] == $row['deal_user_id2']) selected @endif>{{$user_item['user_surname']}} {{$user_item['user_name']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p id="deal-card-2-responsible"></p>
                                    </div>
                                    <div class="col-12">
                                        <span>ДАТА РАСЧЕТА</span>
                                        <p id="deal-card-2-date">{{$row['deal_datetime2_format']}}</p>
                                    </div>
                                </div>
                                <div class="rounded col-12 mt-3 py-2" style="background-color: #00B8D8"></div>
                            </div>
                            <div class="card-body">

                                <div class="form-group">
                                    <label for="deal-card-2-form-brand">Разрез</label>
                                    <select id="deal-card-2-form-brand" class="form-control select2-search" name="deal_brand_id" onchange="setMarkFractionRegionStationList(this)">
                                        <option value="0">Выберите разрез</option>
                                        @if(@count($brand_list) > 0)
                                            @foreach($brand_list as $key => $brand_item)
                                                <option value="{{$brand_item['brand_id']}}" @if($brand_item['brand_id'] == $row['deal_brand_id']) selected @endif>{{$brand_item['brand_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="deal-card-2-form-mark">Марка</label>
                                    <select id="deal-card-2-form-mark" class="form-control select2-search" name="deal_mark_id">
                                        <option value="0">Выберите марку</option>
                                        @if(@count($mark_list) > 0)
                                            @foreach($mark_list as $key => $mark_item)
                                                <option class="mark-option" value="{{$mark_item['mark_id']}}" @if($mark_item['mark_id'] == $row['deal_mark_id']) selected @endif>{{$mark_item['mark_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="deal-card-2-form-fraction">Фракция</label>
                                    <select id="deal-card-2-form-fraction" class="form-control select2-search" name="deal_fraction_id">
                                        <option value="0">Выберите фракцию</option>
                                        @if(@count($fraction_list) > 0)
                                            @foreach($fraction_list as $key => $fraction_item)
                                                <option class="fraction-option" value="{{$fraction_item['fraction_id']}}" @if($fraction_item['fraction_id'] == $row['deal_fraction_id']) selected @endif>{{$fraction_item['fraction_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="deal-card-2-form-volume">Объём в тоннах</label>
                                    <input type="text" name="deal_volume" id="deal-card-1-form-volume" placeholder="" class="form-control" value="{{$row['deal_volume']}}">
                                </div>
                                <div class="form-group">
                                    <label for="deal-card-2-form-region">Область</label>
                                    <select id="deal-card-2-form-region" class="form-control select2-search" name="deal_region_id" onchange="showStationByRegion(this,0,0)">
                                        <option value="0">Выберите регион</option>
                                        @if(@count($region_list) > 0)
                                            @foreach($region_list as $key => $region_item)
                                                <option class="region-option" value="{{$region_item['region_id']}}" @if($region_item['region_id'] == $row['deal_region_id']) selected @endif>{{$region_item['region_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="deal-card-2-form-station">Станция</label>
                                    <select id="deal-card-2-form-station" class="form-control select2-search" name="deal_station_id">
                                        <option value="0">Выберите станцию</option>
                                        @if(@count($station_list) > 0)
                                            @foreach($station_list as $key => $station_item)
                                                <option class="station-option" value="{{$station_item['station_id']}}" @if($station_item['station_id'] == $row['deal_station_id']) selected @endif>{{$station_item['station_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <button type="button" onclick="calculateDealSum()" name="submit" id="deal-card-2-form-submit" class="mb-2 mt-2 btn btn-outline-primary mr-2">Рассчитать</button>

                                <div class="form-group">
                                    <label for="deal-card-2-price">Цена за 1 тонну + доставка + НДС</label>
                                    <input type="text" id="deal-card-2-price" placeholder="" class="form-control" value="{{$row['deal_kp_sum']}}" name="deal_kp_sum">
                                </div>

                                <button type="button" onclick="formulateDealKp()" class="mb-2 mt-2 btn btn-primary mr-2">Формировать КП</button>
                                <div class="d-flex flex-wrap my-2 deal-kp-file-block"></div>

                                <button type="button" onclick="sendDealForm(2)" name="submit" id="deal-card-1-form-submit" class="mb-2 mt-2 btn btn-primary mr-2 process2-btn" @if($row['deal_kp_sum'] < 1) style="display: none;" @endif>Далее</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="deal-card-single-wrapper" id="deal-card-3">
                    <div class="deal-card-single card card-small mb-4 pt-1  @if($row['deal_status_id'] == 3) current @endif">
                        <form id="deal-card-3-form" class="mt-0" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" value="{{$row['deal_id']}}" name="deal_id" class="deal-id-hidden">
                            <input type="hidden" value="3" name="deal_status_id">
                            <div class="card-header text-left">
                                <h5 class="mb-0">Переговоры</h5>
                                <div class="d-flex flex-wrap no-gutters mt-2">
                                    <div class="col-12">
                                        <span>ОТВЕТСТВЕННЫЙ</span>
                                        <select name="deal_user_id3" class="form-control select2-search" id="deal_user_id3">
                                            <option value="0">Выберите ответственного</option>
                                            @if(@count($user_list) > 0)
                                                @foreach($user_list as $key => $user_item)
                                                    <option value="{{$user_item['user_id']}}" @if($user_item['user_id'] == $row['deal_user_id3']) selected @endif>{{$user_item['user_surname']}} {{$user_item['user_name']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p id="deal-card-3-responsible"></p>
                                    </div>
                                    <div class="col-12">
                                        <span>ДАТА ОТПРАВЛЕНИЯ</span>
                                        <p id="deal-card-3-date">{{$row['deal_datetime3_format']}}</p>
                                    </div>
                                </div>
                                <div class="rounded col-12 mt-3 py-2" style="background-color: #313541"></div>
                            </div>
                            <div class="card-body">
                                <div class="deal-card-3-filebox">
                                    <label>Коммерческое предложение № 1</label>
                                    <div class="col-12 d-flex rounded border no-gutters py-2">
                                        <div class="col-9">
                                            <span id="deal-card-3-filebox-description">
                                              <strong>Разрез:</strong> <span class="brand-span-new">{{$row['brand_name']}}</span><br>
                                                <strong>Марка:</strong> <span class="mark-span-new">{{$row['mark_name']}}</span><br>
                                                <strong>Фракция:</strong> <span class="fraction-span-new">{{$row['fraction_name']}}</span><br>
                                                <strong>Объем:</strong> <span class="deal-volume-span-new">{{$row['deal_volume']}} </span> тонн<br>
                                                <strong>Область:</strong> <span class="region-span-new">{{$row['region_name']}}</span><br>
                                                <strong>Станция:</strong> <span class="station-span-new">{{$row['station_name']}}</span><br>
                                                <strong>Цена:</strong> <span class="price-span-new"><?=preg_replace('/(\d)(?=((\d{3})+)(\D|$))/', '$1 ', $row['deal_kp_sum']);?></span>
                                            </span>
                                        </div>
                                        <div class="col-3">
                                            <img src="/admin/images/pdffile.svg">
                                        </div>
                                    </div>
                                    <div class="col-12 px-0 d-flex justify-content-between">
                                        <button type="button" id="deal-card-3-sendOffer" class="btn btn-outline-primary my-2" onclick="sendKpMail()">Отправить Email</button>
                                        <span style=" font-size: 12px; margin-left: 13px; margin-top: 10px; line-height: 1.2; color: green; text-align: center;" class="sendkp-result-span"></span>
                                    </div>
                                </div>

                                <div class="form-group d-flex flex-wrap align-items-center justify-content-between">
                                    <label for="deal-card-3-form-answer">Ответ клиента</label>
                                    <span class="text-right" id="deal-card-3-form-date">22.10.2019 15:16</span>
                                    <textarea class="form-control" id="deal-card-3-form-answer" name="client_answer_text" rows="7"></textarea>
                                    <button type="button" onclick="addClientAnswer()" name="submit" class="mb-2 mt-2 btn btn-outline-primary">Сохранить</button>
                                    <div class="client-answers-block"></div>
                                </div>
                                <div class="form-group d-flex flex-wrap align-items-center justify-content-between">
                                    <label for="deal-card-3-form-discount">Скидка</label>
                                    <div class="custom-control custom-toggle custom-toggle-sm mb-2">
                                        <input type="checkbox" id="deal-card-3-form-percents" name="deal_discount_type" class="custom-control-input" @if($row['deal_discount_type'] == 1) checked="checked" @endif>
                                        <label class="custom-control-label" for="deal-card-3-form-percents">
                                            <font id="number" @if($row['deal_discount_type'] != 1) style="font-weight: bold; color: #007bff;" @endif>Число</font><font> / </font><font id="percent" @if($row['deal_discount_type'] == 1) style="font-weight: bold; color: #007bff;" @endif>Процент</font>
                                        </label>
                                    </div>
                                    <input type="text" id="deal-card-3-form-discount" name="deal_discount" placeholder="" class="form-control" value="{{$row['deal_discount']}}">
                                </div>
                                <div class="col-12 px-0 d-flex justify-content-between">
                                    <button type="button" onclick="sendDealForm(3)" name="submit" id="deal-card-3-form-submit" class="mb-2 mt-2 btn btn-primary">Далее</button>
                                    <button type="button" onclick="showDealRejectForm()" id="deal-card-3-form-reject" class="btn btn-danger my-2">Отказ клиента</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="deal-card-single-wrapper" id="deal-card-4">
                    <div class="deal-card-single card card-small mb-4 pt-1  @if($row['deal_status_id'] == 4) current @endif">
                        <form id="deal-card-4-form" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" value="{{$row['deal_id']}}" name="deal_id" class="deal-id-hidden">
                            <input type="hidden" value="4" name="deal_status_id">
                            <div class="card-header text-left">
                                <h5 class="mb-0">Договор</h5>
                                <div class="d-flex flex-wrap no-gutters mt-2">
                                    <div class="col-12">
                                        <span>ОТВЕТСТВЕННЫЙ</span>
                                        <select name="deal_user_id4" class="form-control select2-search" id="deal_user_id4">
                                            <option value="0">Выберите ответственного</option>
                                            @if(@count($user_list) > 0)
                                                @foreach($user_list as $key => $user_item)
                                                    <option value="{{$user_item['user_id']}}" @if($user_item['user_id'] == $row['deal_user_id4']) selected @endif>{{$user_item['user_surname']}} {{$user_item['user_name']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p id="deal-card-4-responsible"></p>
                                    </div>
                                    <div class="col-12">
                                        <span>ДАТА ОТПРАВЛЕНИЯ</span>
                                        <p id="deal-card-4-date">{{$row['deal_datetime4_format']}}</p>
                                    </div>
                                </div>
                                <div class="rounded col-12 mt-3 py-2" style="background-color: #674EEC"></div>
                            </div>
                            <div class="card-body">
                                <label class="deal-dogovor-sum">
                                    @if($row['deal_status_id'] == 4)
                                        <?
                                        $discount_sum = $row['deal_discount'];
                                        if($row['deal_discount_type'] == 1){
                                            $discount_sum = $row['deal_kp_sum']*$row['deal_discount']/100;
                                        }
                                        ?>
                                        Сумма договора: <?=preg_replace('/(\d)(?=((\d{3})+)(\D|$))/', '$1 ', $row['deal_kp_sum']-$discount_sum);?>
                                    @endif
                                </label>
                                <div class="d-flex no-gutters">
                                    <div class="form-group col-6 pr-2">
                                        <label for="deal-card-4-form-paymentCond">Условия оплаты</label>
                                        <select name="deal_payment_id" id="deal-card-4-form-payment" class="form-control">
                                            <option value="0">Выберите условию оплаты</option>
                                            @if(@count($payment_list) > 0)
                                                @foreach($payment_list as $key => $payment_item)
                                                    <option value="{{$payment_item['payment_id']}}" @if($payment_item['payment_id'] == $row['deal_payment_id']) selected @endif>{{$payment_item['payment_name']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group col-6">
                                        <label for="deal-card-4-form-deliveryTime">Срок доставки</label>
                                        <select id="deal-card-4-form-deliveryTime" class="form-control" name="deal_delivery_id">
                                            <option value="0">Выберите срок доставки</option>
                                            @if(@count($delivery_list) > 0)
                                                @foreach($delivery_list as $key => $delivery_item)
                                                    <option value="{{$delivery_item['delivery_id']}}" @if($delivery_item['delivery_id'] == $row['deal_delivery_id']) selected @endif>{{$delivery_item['delivery_name']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <span style="color: #007bff;border-bottom: 1px dotted #007bff;cursor: pointer;font-size:14px;" onclick="addNewCompany()">+ Добавить</span>
                                <span style="color: #007bff;border-bottom: 1px dotted #007bff;cursor: pointer;font-size:14px;float: right;" onclick="showCompanySelectBlock()">Выбрать из списка</span>
                                <div class="form-group company-select-block" style="display: none;">
                                    <label for="deal-card-1-form-name">Компания *</label>
                                    <select class="form-control select2-search" id="company_id_list" onchange="setCompanyInfo()">
                                        <option value="0">Выберите компанию</option>
                                        <?
                                        use App\Models\Company;
                                        $company_list = Company::orderBy("company_name","asc")->get();
                                        ?>
                                        @if(@count($company_list) > 0)
                                            @foreach($company_list as $key => $company_item)
                                                <option value="{{$company_item['company_id']}}" data-company-id="{{$company_item['company_id']}}" data-company-name="{{$company_item['company_name']}}" data-company-address="{{$company_item['company_address']}}" data-company-bin="{{$company_item['company_bank_bin']}}"
                                                        data-company-bank-id="{{$company_item['company_bank_id']}}" data-company-iik="{{$company_item['company_bank_iik']}}" data-company-ceo-position="{{$company_item['company_ceo_position']}}"
                                                        data-company-ceo-name="{{$company_item['company_ceo_name']}}" data-company-delivery-address="{{$company_item['company_delivery_address']}}" data-company-okpo="{{$company_item['company_okpo']}}">{{$company_item['company_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group mt-2">
                                    <input type="hidden" name="company_id" value="{{$row['company_id']}}" id="company_id">
                                    <label for="deal-card-4-form-companyName">Наименование компании</label>
                                    <input type="text" name="company_name" id="deal-card-4-form-companyName" placeholder="" class="form-control deal-company-input ui-autocomplete-input" autocomplete="off" value="{{$row['company_name']}}">
                                </div>
                                <div class="form-group">
                                    <label for="deal-card-4-form-companyAddress">Юридический адрес</label>
                                    <input type="text" name="company_address" id="deal-card-4-form-companyAddress" placeholder="" class="form-control deal-company-input" value="{{$row['company_address']}}">
                                </div>
                                <div class="form-group">
                                    <label for="deal-card-4-form-companyAddress">Адрес доставки</label>
                                    <input type="text" name="company_delivery_address" id="deal-card-4-form-companyDeliveryAddress" placeholder="" class="form-control deal-company-input" value="{{$row['company_delivery_address']}}">
                                </div>
                                <div class="form-group">
                                    <label for="deal-card-4-form-companyAddress">ОКПО</label>
                                    <input type="text" name="company_okpo" id="deal-card-4-form-companyOkpo" placeholder="" class="form-control deal-company-input" value="{{$row['company_okpo']}}">
                                </div>
                                <div class="form-group">
                                    <label for="deal-card-4-form-bankBIN">БИН</label>
                                    <input type="text" name="company_bank_bin" id="deal-card-4-form-bankBIN" placeholder="" class="form-control deal-company-input" value="{{$row['company_bank_bin']}}" maxlength="12">
                                </div>
                                <div class="form-group">
                                    <label for="deal-card-4-form-bank">Банк</label>
                                    <select id="deal-card-4-form-bank" class="form-control deal-company-input select2-search" name="company_bank_id">
                                        <option value="0">Выберите банк</option>
                                        @if(@count($bank_list) > 0)
                                            @foreach($bank_list as $key => $bank_item)
                                                <option value="{{$bank_item['bank_id']}}" @if($bank_item['bank_id'] == $row['company_bank_id']) selected @endif>{{$bank_item['bank_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label for="deal-card-4-form-bankIIK">ИИК</label>
                                    <input type="text" name="company_bank_iik" id="deal-card-4-form-bankIIK" placeholder="" class="form-control deal-company-input" value="{{$row['company_bank_iik']}}" maxlength="20">
                                </div>
                                <div class="form-group">
                                    <label for="deal-card-4-form-companyCEOPosition">Должность руководителя</label>
                                    <input type="text" name="company_ceo_position" id="deal-card-4-form-companyCEOPosition" placeholder="" class="form-control deal-company-input" value="{{$row['company_ceo_position']}}">
                                </div>
                                <div class="form-group">
                                    <label for="deal-card-4-form-companyCEOName">ФИО руководителя</label>
                                    <input type="text" name="company_ceo_name" id="deal-card-4-form-companyCEOName" placeholder="" class="form-control deal-company-input" value="{{$row['company_ceo_name']}}">
                                </div>
                                <div class="form-group d-flex flex-wrap align-items-center justify-content-between">
                                    <label for="deal-card-3-form-discount">Код получателя</label>
                                    <input type="text" id="deal-card-4-form-receiverCode" name="deal_receiver_code" placeholder="" class="form-control" value="{{$row['deal_receiver_code']}}">
                                </div>
                                <div class="col-12 px-0 d-flex justify-content-between">
                                    <button onclick="downloadDogovor()" type="button" id="deal-card-4-downloadContract" class="mb-2 mt-2 btn btn-outline-primary">Скачать договор</button>
                                    <button onclick="sendDogovor()" type="button" id="deal-card-4-sendContract" class="btn btn-outline-primary my-2">Отправить</button>
                                </div>
                                <button type="button" onclick="sendDealForm(4)" name="submit" id="deal-card-4-form-submit" class="mb-2 mt-2 btn btn-primary mr-2">Далее</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="deal-card-single-wrapper" id="deal-card-5">
                    <div class="deal-card-single card card-small mb-4 pt-1 @if($row['deal_status_id'] == 5) current @endif">
                        <div class="card-header text-left">
                            <h5 class="mb-0">Счет на оплату</h5>
                            <div class="d-flex flex-wrap no-gutters mt-2">
                                <div class="col-12">
                                    <span>ОТВЕТСТВЕННЫЙ</span>
                                    <select class="form-control select2-search" onchange="setDealUser(5,this)">
                                        <option value="0">Выберите ответственного</option>
                                        @if(@count($user_list) > 0)
                                            @foreach($user_list as $key => $user_item)
                                                <option value="{{$user_item['user_id']}}" @if($user_item['user_id'] == $row['deal_user_id5']) selected @endif>{{$user_item['user_surname']}} {{$user_item['user_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p id="deal-card-5-responsible"></p>
                                </div>
                                <div class="col-12">
                                    <span>ДАТА ОТПРАВЛЕНИЯ</span>
                                    <p id="deal-card-5-date">{{$row['deal_datetime5_format']}}</p>
                                </div>
                            </div>
                            <div class="rounded col-12 mt-3 py-2" style="background-color: #17C671"></div>
                        </div>
                        <div class="card-body">
                            <form id="deal-bill-form" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{$row['deal_id']}}" name="deal_id" class="deal-id-hidden">
                                <div class="d-flex no-gutters">
                                    <div class="form-group col-6">
                                        <label for="deal-card-5-form-sum">Количество тонн</label>
                                        <input type="text" name="deal_bill_volume" id="deal-card-5-form-sum" placeholder="" class="form-control" value="">
                                    </div>
                                </div>

                                <label>Цена за 1 тонну:</label>
                                <input type="text" id="deal_bill_tonn_sum" name="deal_bill_tonn_sum" placeholder="" class="form-control" value="{{$deal_bill_tonn_sum}}" readonly>
                                <label>Общая сумма:</label>
                                <input type="text" id="deal_bill_total_sum" name="deal_bill_total_sum" placeholder="" class="form-control" value="" readonly>

                                <button onclick="createDealBill()" type="button" name="submit" id="deal-card-5-form-submit" class="mb-2 mt-2 btn btn-outline-primary mr-2">Создать счет</button>
                            </form>

                            <form id="deal-card-5-form" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{$row['deal_id']}}" name="deal_id" class="deal-id-hidden">
                                <input type="hidden" value="5" name="deal_status_id">
                                <input type="hidden" value="{{$row['deal_user_id5']}}" id="deal_user_id5" name="deal_user_id5">
                                <div class="d-flex flex-wrap my-2 deal-bill-file-block"></div>
                                <button type="button" onclick="sendDealForm(5)" id="deal-card-5-next" class="mb-2 mt-2 btn btn-primary mr-2">Далее</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="deal-card-single-wrapper" id="deal-card-6">
                    <div class="deal-card-single card card-small mb-4 pt-1 @if($row['deal_status_id'] == 6) current @endif">
                        <form id="deal-card-6-form" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" value="{{$row['deal_id']}}" name="deal_id" class="deal-id-hidden">
                            <input type="hidden" value="6" name="deal_status_id">
                            <div class="card-header text-left">
                                <h5 class="mb-0">Заявка разрезу</h5>
                                <div class="d-flex flex-wrap no-gutters mt-2">
                                    <div class="col-12">
                                        <span>ОТВЕТСТВЕННЫЙ</span>
                                        <select name="deal_user_id6" class="form-control select2-search">
                                            <option value="0">Выберите ответственного</option>
                                            @if(@count($user_list) > 0)
                                                @foreach($user_list as $key => $user_item)
                                                    <option value="{{$user_item['user_id']}}" @if($user_item['user_id'] == $row['deal_user_id6']) selected @endif>{{$user_item['user_surname']}} {{$user_item['user_name']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p id="deal-card-6-responsible"></p>
                                    </div>
                                    <div class="col-12">
                                        <span>ДАТА ОТПРАВЛЕНИЯ</span>
                                        <p id="deal-card-6-date">{{$row['deal_datetime6_format']}}</p>
                                    </div>
                                </div>
                                <div class="rounded col-12 mt-3 py-2" style="background-color: #C4183C"></div>
                            </div>
                            <div class="card-body">
                                <div id="deal-card-6-consignee-block">
                                    <p class="deal-card-6-line-name">
                                        Грузополучатель
                                    </p>
                                    <p class="deal-card-6-line-value" id="deal-card-6-consignee">
                                        {{$row['company_name']}}
                                    </p>
                                </div>
                                <div id="deal-card-6-BIN-block">
                                    <p class="deal-card-6-line-name">
                                        БИН
                                    </p>
                                    <p class="deal-card-6-line-value" id="deal-card-6-BIN">
                                        {{$row['company_bank_bin']}}
                                    </p>
                                </div>
                                <div id="deal-card-6-station-block">
                                    <p class="deal-card-6-line-name">
                                        Станция
                                    </p>
                                    <p class="deal-card-6-line-value" id="deal-card-6-station">
                                        {{$row['station_name']}}
                                    </p>
                                </div>
                                <div id="deal-card-6-stationCode-block">
                                    <p class="deal-card-6-line-name">
                                        Код станции
                                    </p>
                                    <p class="deal-card-6-line-value" id="deal-card-6-stationCode">
                                        {{$row['station_code']}}
                                    </p>
                                </div>
                                <div id="deal-card-6-address-block">
                                    <p class="deal-card-6-line-name">
                                        Адрес
                                    </p>
                                    <p class="deal-card-6-line-value" id="deal-card-6-address">
                                        {{$row['company_delivery_address']}}
                                    </p>
                                </div>
                                <div id="deal-card-6-address-block">
                                    <p class="deal-card-6-line-name">
                                        ОКПО
                                    </p>
                                    <p class="deal-card-6-line-value" id="deal-card-6-okpo">
                                        {{$row['company_okpo']}}
                                    </p>
                                </div>
                                <div id="deal-card-6-receiverCode-block">
                                    <p class="deal-card-6-line-name">
                                        Код получателя (4-х значный)
                                    </p>
                                    <p class="deal-card-6-line-value" id="deal-card-6-receiverCode">
                                        {{$row['deal_receiver_code']}}
                                    </p>
                                </div>
                                <div id="deal-card-6-OKPO-block">
                                    <p class="deal-card-6-line-name">
                                        ОКПО
                                    </p>
                                    <p class="deal-card-6-line-value" id="deal-card-6-OKPO">
                                        03150869
                                    </p>
                                </div>
                                <div id="deal-card-6-quantity-block">
                                    <p class="deal-card-6-line-name">
                                        Количество п/в
                                    </p>
                                    <p class="deal-card-6-line-value" id="deal-card-6-quantity">
                                        {{ceil($row['deal_volume']/70)}}
                                    </p>
                                </div>
                                <div id="deal-card-6-fraction-block">
                                    <p class="deal-card-6-line-name">
                                        Фракция
                                    </p>
                                    <p class="deal-card-6-line-value" id="deal-card-6-fraction">
                                        {{$row['fraction_name']}}
                                    </p>
                                </div>
                                <button type="button" onclick="sendDealForm(6)" id="deal-card-6-next" class="mb-2 mt-4 btn btn-primary mr-2">Отправить разрезу</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="deal-card-single-wrapper" id="deal-card-7">
                    <div class="deal-card-single card card-small mb-4 pt-1 @if($row['deal_status_id'] == 7) current @endif">
                        <div class="card-header text-left">
                            <h5 class="mb-0">Оплата разрезу</h5>
                            <div class="d-flex flex-wrap no-gutters mt-2">
                                <div class="col-12">
                                    <span>ОТВЕТСТВЕННЫЙ</span>
                                    <select class="form-control select2-search" onchange="setDealUser(7,this)">
                                        <option value="0">Выберите ответственного</option>
                                        @if(@count($user_list) > 0)
                                            @foreach($user_list as $key => $user_item)
                                                <option value="{{$user_item['user_id']}}" @if($user_item['user_id'] == $row['deal_user_id7']) selected @endif>{{$user_item['user_surname']}} {{$user_item['user_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p id="deal-card-7-responsible"></p>
                                </div>
                                <div class="col-12">
                                    <span>ДАТА ОТПРАВЛЕНИЯ</span>
                                    <p id="deal-card-7-date">{{$row['deal_datetime7_format']}}</p>
                                </div>
                            </div>
                            <div class="rounded col-12 mt-3 py-2" style="background-color: #F7B422"></div>
                        </div>
                        <div class="card-body">
                            <form id="deal-card-7-file-form" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{$row['deal_id']}}" name="deal_id" class="deal-id-hidden">
                                <input type="hidden" value="4" name="deal_file_type">
                                <div class="d-flex no-gutters">
                                    <div class="form-group col-12">
                                        <div class="custom-file my-2">
                                            <input type="file" class="custom-file-input" id="brand_deal_file_src" name="brand_deal_file_src">
                                            <label class="custom-file-label" for="deal-card-7-file"></label>
                                        </div>
                                    </div>
                                </div>
                                <div class="deal-brand-files-block">
                                    @if(@count($deal_brand_files) > 0 )
                                        @foreach($deal_brand_files as $key => $deal_brand_item)
                                            <div class="d-flex flex-wrap no-gutters align-items-center justify-content-between deal-brand-file-item" id="deal-card-7-bill1">
                                                <div class="col-2">
                                                    <img src="/admin/images/file-icon.svg">
                                                </div>
                                                <div class="col-10">
                                                    <a href="/deal_files/{{$deal_brand_item['deal_file_src']}}" target="_blank">
                                                        <p class="deal-card-5-bill-name" id="deal-card-7-bill1-name">{{$deal_brand_item['deal_file_name']}}</p>
                                                        <p class="deal-card-5-bill-date" id="deal-card-7-bill1-date">{{$deal_brand_item['deal_file_date_format']}}</p>
                                                    </a>
                                                    <button onclick="deleteDealBrandFile({{$deal_brand_item['deal_file_id']}},{{$deal_brand_item['deal_file_deal_id']}},this)" type="button" class="mb-2 btn btn-sm btn-file mr-1 delete-btn"><i class="fas fa-times text-danger mr-2"></i><span class="text-danger border-danger">Удалить</span></button>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                            </form>
                            <form id="deal-card-7-form" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{$row['deal_id']}}" name="deal_id" class="deal-id-hidden">
                                <input type="hidden" value="7" name="deal_status_id">
                                <input type="hidden" value="{{$row['deal_user_id7']}}" id="deal_user_id7" name="deal_user_id7">
                                <div class="form-group">
                                    <label for="deal-card-7-form-sum">Сумма оплаты</label>
                                    <input type="text" name="deal_brand_sum" id="deal-card-7-form-sum" placeholder="" class="form-control" value="{{$row['deal_brand_sum']}}">
                                </div>
                                <button type="button" onclick="sendDealForm(7)" name="submit" id="deal-card-7-form-submit" class="mb-2 mt-2 btn btn-primary mr-2">Далее</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="deal-card-single-wrapper" id="deal-card-8">
                    <div class="deal-card-single card card-small mb-4 pt-1 @if($row['deal_status_id'] == 8) current @endif">
                        <form id="deal-card-8-form" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" value="{{$row['deal_id']}}" name="deal_id" class="deal-id-hidden">
                            <input type="hidden" value="8" name="deal_status_id">
                            <div class="card-header text-left">
                                <h5 class="mb-0">Отгрузка</h5>
                                <div class="d-flex flex-wrap no-gutters mt-2">
                                    <div class="col-12">
                                        <span>ОТВЕТСТВЕННЫЙ</span>
                                        <select name="deal_user_id8" class="form-control select2-search" id="deal_user_id8">
                                            <option value="0">Выберите ответственного</option>
                                            @if(@count($user_list) > 0)
                                                @foreach($user_list as $key => $user_item)
                                                    <option value="{{$user_item['user_id']}}" @if($user_item['user_id'] == $row['deal_user_id8']) selected @endif>{{$user_item['user_surname']}} {{$user_item['user_name']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p id="deal-card-8-responsible"></p>
                                    </div>
                                    <div class="col-12">
                                        <span>ДАТА ОТПРАВЛЕНИЯ</span>
                                        <p id="deal-card-8-date">{{$row['deal_datetime8_format']}}</p>
                                    </div>
                                </div>
                                <div class="rounded col-12 mt-3 py-2" style="background-color: #A8AEB4"></div>
                            </div>
                            <div class="card-body">
                                <div class="form-group">
                                    <input type="hidden" class="plan-deal-volume" value="{{$row['deal_volume']}}">
                                    <label>Планируется: <label class="plan-deal-volume">{{$row['deal_volume']}}</label> тонн</label>
                                    <br>
                                    <label>Фактически:</label>
                                    <input type="text" id="deal_fact_volume" name="deal_fact_volume" placeholder="" class="form-control" value="{{$row['deal_fact_volume']}}">
                                    <label>Остаток (тонн):</label>
                                    <input type="text" id="deal_rest_volume" name="deal_rest_volume" placeholder="" class="form-control" value="{{$row['deal_rest_volume']}}" readonly>
                                    <label>Остаток (сумма):</label>
                                    <input type="text" id="deal_rest_volume_in_sum" name="deal_rest_volume_in_sum" placeholder="" class="form-control" value="{{$row['deal_rest_volume_in_sum']}}" readonly>
                                </div>
                                <div class="d-flex no-gutters">
                                    <div class="form-group col-12">
                                        <div id="blog-overview-date-range" class="input-daterange input-group input-group-sm my-auto ml-auto mr-auto ml-sm-auto mr-sm-0" style="max-width: 350px;">
                                            <label for="blog-overview-date-range-1" class="col-12 pl-0">Дата отгрузки</label>
                                            <input type="text" class="input-sm form-control rounded datepicker-here" data-timepicker="true" name="deal_shipping_date" placeholder="01.01.2019 09:00" value="{{$row['deal_shipping_date']}} {{$row['deal_shipping_time']}}" id="blog-overview-date-range-1" style="height: calc(2.09375rem + 2px)">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="deal-card-8-form-comment">Комментарий от разреза</label>
                                    <textarea class="form-control" id="deal-card-8-form-comment" name="shipping_comment_text" rows="7"></textarea>
                                    <button type="button" onclick="addShippingComment()" name="submit" class="mb-2 mt-2 btn btn-outline-primary">Сохранить</button>
                                    <div class="shipping-comment-block"></div>
                                </div>
                                <div class="form-group">
                                    <label for="deal-card-8-form-client-comment">Комментарий для клиента</label>
                                    <textarea class="form-control" id="deal-card-8-form-client-comment" name="shipping_client_comment_text" rows="7"></textarea>
                                    <button type="button" onclick="addShippingClientComment()" name="submit" class="mb-2 mt-2 btn btn-primary">Сохранить</button>
                                    <div class="shipping-client-comment-block"></div>
                                </div>
                                <button type="button" onclick="sendDealForm(8)" name="submit" id="deal-card-8-form-submit" class="mb-2 mt-2 btn btn-primary mr-2">Далее</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="deal-card-single-wrapper" id="deal-card-9">
                    <div class="deal-card-single card card-small mb-4 pt-1 @if($row['deal_status_id'] == 9) current @endif">
                        <form id="deal-card-9-form" method="post">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" value="{{$row['deal_id']}}" name="deal_id" class="deal-id-hidden">
                            <input type="hidden" value="9" name="deal_status_id">
                            <div class="card-header text-left">
                                <h5 class="mb-0">Доставка</h5>
                                <div class="d-flex flex-wrap no-gutters mt-2">
                                    <div class="col-12">
                                        <span>ОТВЕТСТВЕННЫЙ</span>
                                        <select name="deal_user_id9" class="form-control select2-search" id="deal_user_id9">
                                            <option value="0">Выберите ответственного</option>
                                            @if(@count($user_list) > 0)
                                                @foreach($user_list as $key => $user_item)
                                                    <option value="{{$user_item['user_id']}}" @if($user_item['user_id'] == $row['deal_user_id9']) selected @endif>{{$user_item['user_surname']}} {{$user_item['user_name']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                        <p id="deal-card-9-responsible"></p>
                                    </div>
                                    <div class="col-12">
                                        <span>ДАТА ОТПРАВЛЕНИЯ</span>
                                        <p id="deal-card-9-date">{{$row['deal_datetime9_format']}}</p>
                                    </div>
                                </div>
                                <div class="rounded col-12 mt-3 py-2" style="background-color: #B3D7FF"></div>
                            </div>
                            <div class="card-body">
                                <div class="d-flex no-gutters">
                                    <div class="form-group col-12">
                                        <div id="blog-overview-date-range-2" class="input-daterange input-group input-group-sm my-auto ml-auto mr-auto ml-sm-auto mr-sm-0" style="max-width: 350px;">
                                            <label for="blog-overview-date-range-2-1" class="col-12 pl-0">Дата доставки</label>
                                            <input type="text" class="input-sm form-control rounded datepicker-here" data-timepicker="true" name="deal_delivery_date" placeholder="01.01.2019 09:00" id="blog-overview-date-range-2-1" style="height: calc(2.09375rem + 2px)" value="{{$row['deal_delivery_date']}} {{$row['deal_delivery_time']}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="deal-card-9-form-comment">Комментарий от разреза</label>
                                    <textarea class="form-control" id="deal-card-9-form-comment" name="delivery_comment_text" rows="7"></textarea>
                                    <button type="button" onclick="addDeliveryComment()" name="submit" class="mb-2 mt-2 btn btn-outline-primary">Сохранить</button>

                                    <div class="delivery-comment-block"></div>
                                </div>
                                <div class="form-group">
                                    <label for="deal-card-9-form-client-comment">Комментарий для клиента</label>
                                    <textarea class="form-control" id="deal-card-9-form-client-comment" name="delivery_client_comment_text" rows="7"></textarea>
                                    <button type="button" onclick="addDeliveryClientComment()" name="submit" class="mb-2 mt-2 btn btn-primary">Сохранить</button>

                                    <div class="delivery-client-comment-block"></div>
                                </div>
                                <button type="button" onclick="sendDealForm(9)" name="submit" id="deal-card-9-form-submit" class="mb-2 mt-2 btn btn-primary mr-2">Далее</button>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="deal-card-single-wrapper" id="deal-card-10">
                    <div class="deal-card-single card card-small mb-4 pt-1 @if($row['deal_status_id'] == 10) current @endif">
                        <div class="card-header text-left">
                            <h5 class="mb-0">Закрытие</h5>
                            <div class="d-flex flex-wrap no-gutters mt-2">
                                <div class="col-12">
                                    <span>ОТВЕТСТВЕННЫЙ</span>
                                    <select class="form-control select2-search" onchange="setDealUser(10,this)">
                                        <option value="0">Выберите ответственного</option>
                                        @if(@count($user_list) > 0)
                                            @foreach($user_list as $key => $user_item)
                                                <option value="{{$user_item['user_id']}}" @if($user_item['user_id'] == $row['deal_user_id10']) selected @endif>{{$user_item['user_surname']}} {{$user_item['user_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p id="deal-card-10-responsible"></p>
                                </div>
                                <div class="col-12">
                                    <span>ДАТА ОТПРАВЛЕНИЯ</span>
                                    <p id="deal-card-10-date">{{$row['deal_datetime10_format']}}</p>
                                </div>
                            </div>
                            <div class="rounded col-12 mt-3 py-2" style="background-color: #17C671"></div>
                        </div>
                        <div class="card-body">
                            <form id="deal-close-deal-form" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{$row['deal_id']}}" name="deal_id" class="deal-id-hidden">

                                <div class="d-flex no-gutters">
                                    <div class="form-group col-6">
                                        <label for="deal-card-9-form-sum">Количество тонн</label>
                                        <input type="text" name="deal_bill_volume" id="deal-card-9-form-sum" placeholder="" class="form-control" value="">
                                    </div>
                                </div>

                                <label>Цена за 1 тонну:</label>
                                <input type="text" id="deal_bill_tonn_sum2" name="deal_bill_tonn_sum" placeholder="" class="form-control" value="{{$deal_bill_tonn_sum}}" readonly>
                                <label>Общая сумма:</label>
                                <input type="text" id="deal_bill_total_sum2" name="deal_bill_total_sum" placeholder="" class="form-control" value="" readonly>

                                <button onclick="createDealCloseBill()" type="button" name="submit" id="deal-card-10-form-submit" class="mb-2 mt-2 btn btn-outline-primary mr-2">Создать счет</button>
                            </form>

                            <form id="deal-card-10-form" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" value="{{$row['deal_id']}}" name="deal_id" class="deal-id-hidden">
                                <input type="hidden" value="10" name="deal_status_id">
                                <input type="hidden" value="{{$row['deal_user_id10']}}" id="deal_user_id10" name="deal_user_id10">
                                <div class="d-flex flex-wrap my-2 deal-close-file-block"></div>
                                <button type="button" onclick="sendDealForm(10)" id="deal-card-10-next" class="mb-2 mt-2 btn btn-primary mr-2">Завершить</button>
                            </form>
                        </div>
                    </div>
                </div>




            </div>
        </div>
        <!-- /Main content -->
        <div class="col-12 px-0">
            <div class="col-12 px-0 d-flex flex-wrap justify-content-between py-4">
                <div class="col-12 col-sm-6">
                    <div class="card card-small">
                        <div class="d-flex flex-wrap">
                            <div class="col-12 col-sm-6">
                                <div class="card-header px-0 pb-0 text-left">
                                    <h5 class="mb-0">Задачи</h5>
                                </div>
                                <div class="card-body px-0">
                                    <form id="deal-tasks-form" method="post">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="hidden" value="{{$row['deal_id']}}" name="deal_id" class="deal-id-hidden">
                                        <div class="form-group">
                                            <select id="deal-tasks-form-responsible" class="form-control select2-search deal-task-user-select" name="user_task_user_id">
                                                <option value="0">Выберите исполнителя</option>
                                                @if(@count($user_list) > 0)
                                                    @foreach($user_list as $key => $user_item)
                                                        <option value="{{$user_item['user_id']}}">{{$user_item['user_surname']}} {{$user_item['user_name']}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="d-flex no-gutters">
                                            <div class="form-group col-6 pr-1">
                                                <div id="blog-overview-date-range3" class="input-daterange input-group input-group-sm my-auto ml-auto mr-auto ml-sm-auto mr-sm-0" style="max-width: 350px;">
                                                    <label for="blog-overview-date-range-3-1" class="col-12 pl-0">Начало</label>
                                                    <input type="text" class="input-sm form-control rounded datepicker-here" data-timepicker="true" data-position='top left'  id="blog-overview-date-range-3-1" placeholder="01.01.2019 09:00"  style="height: calc(2.09375rem + 2px)" autocomplete="off" >
                                                </div>
                                            </div>
                                            <div class="form-group col-6 pl-1">
                                                <div id="blog-overview-date-range4" class="input-daterange input-group input-group-sm my-auto ml-auto mr-auto ml-sm-auto mr-sm-0" style="max-width: 350px;">
                                                    <label for="blog-overview-date-range-4-1" class="col-12 pl-0">Завершение</label>
                                                    <input type="text" class="input-sm form-control rounded datepicker-here" data-timepicker="true" data-position='top left'  placeholder="31.01.2019 09:00" id="blog-overview-date-range-4-1"style="height: calc(2.09375rem + 2px)" autocomplete="off" >
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <textarea class="form-control" id="deal-tasks-form-comment" name="user_task_text" rows="4"></textarea>
                                        </div>
                                        <button type="button" onclick="saveNewUserTask()" name="submit" id="deal-tasks-form-submit" class="mb-2 mt-2 btn btn-primary mr-2">Поставить</button>
                                    </form>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 py-4 task-small-card-block">

                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-12 col-sm-3">
                    <div class="card card-small">
                        <div class="card-header pb-0">
                            <h5 class="mb-0">История</h5>
                        </div>
                        <div class="card-body deal-history-block"></div>
                    </div>
                </div>
                <div class="col-12 col-sm-3">
                    <div class="card card-small">
                        <div class="card-header pb-0">
                            <h5 class="mb-0">Документы</h5>
                        </div>
                        <div class="card-body">
                            <!-- <form class="dropzone" id="my-awesome-dropzone">
                              <div class="fallback">
                                <input name="file" type="file" multiple />
                              </div>
                            </form> -->

                            <!--begin form choose video upload-->
                            <main class="col s12">
                                <!--teste dropzone com preview-->
                                <div class="row">
                                    <div class="">
                                        <!-- Uploader Dropzone -->
                                        <form action="" id="zdrop" class="fileuploader center-align" enctype="multipart/form-data">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="hidden" value="{{$row['deal_id']}}" name="deal_id" class="deal-id-hidden">
                                            <input type="hidden" value="5" name="deal_file_type">
                                            <div id="upload-label" style="width: 200px;">
                                                <i class="material-icons">cloud_upload</i>
                                            </div>
                                            <span class="tittle">Перетащите файл сюда или нажмите для загрузки</span>
                                        </form>

                                        <div class="deal-other-files-block">
                                            @if(@count($deal_other_files) > 0 )
                                                @foreach($deal_other_files as $key => $deal_other_item)
                                                    <div class="d-flex flex-wrap no-gutters align-items-center justify-content-between deal-other-file-item" id="deal-card-7-bill1">
                                                        <div class="col-2">
                                                            <img src="/admin/images/file-icon.svg">
                                                        </div>
                                                        <div class="col-10">
                                                            <a href="/deal_files/{{$deal_other_item['deal_file_src']}}" target="_blank">
                                                                <p class="deal-card-5-bill-name" id="deal-card-7-bill1-name">{{$deal_other_item['deal_file_name']}}</p>
                                                                <p class="deal-card-5-bill-date" id="deal-card-7-bill1-date">{{$deal_other_item['deal_file_date_format']}}</p>
                                                            </a>
                                                            <button onclick="deleteDealOtherFile({{$deal_other_item['deal_file_id']}},{{$deal_other_item['deal_file_deal_id']}},this)" type="button" class="mb-2 btn btn-sm btn-outline-primary mr-1 delete-btn">Удалить</button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>

                                        <!-- Preview collection of uploaded documents -->
                                        <div class="preview-container">
                                            <div class="collection card" id="previews">
                                                <div class="collection-item clearhack valign-wrapper item-template" id="zdrop-template">
                                                    <div class="left pv zdrop-info" data-dz-thumbnail>
                                                        <div>
                                                            <span data-dz-name></span> <span data-dz-size></span>
                                                        </div>
                                                        <div class="progress">
                                                            <div class="determinate" style="width:0" data-dz-uploadprogress></div>
                                                        </div>
                                                        <div class="dz-error-message"><span data-dz-errormessage></span></div>
                                                    </div>

                                                    <div class="secondary-content actions">
                                                        <a href="#!" data-dz-remove class="btn-floating ph red white-text waves-effect waves-light"><i class="material-icons white-text">clear</i></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </main>


                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal-window-clients rounded" id="modal-window-clients">
            <div class="card-body p-0 py-1 rounded text-center">
                <table class="table mb-0 clients-table">
                    <thead class="bg-light">
                    <tr>
                        <th scope="col" class="border-0">#</th>
                        <th scope="col" class="border-0">Компания</th>
                        <th scope="col" class="border-0">Клиент</th>
                        <th scope="col" class="border-0">Телефон</th>
                        <th scope="col" class="border-0">Email</th>
                        <th scope="col" class="border-0">БИН</th>
                        <th scope="col" class="border-0">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td>1</td>
                        <td>ТОО IBR TRADE</td>
                        <td>Кайрат Нуртас</td>
                        <td>77771113355</td>
                        <td>qwerty@mail.ru</td>
                        <td>123123123123</td>
                        <td>
                            <div class="clients-table__actions">
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-white">
                                  <span class="text-light">
                                    <i class="material-icons">add_circle</i>
                                  </span> Добавить </button>
                                </div>
                            </div>
                        </td>
                    </tr>

                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div style="display: none" class="clone-deal-brand-file-item">
        <div class="d-flex flex-wrap no-gutters align-items-center justify-content-between" id="deal-card-7-bill1">
            <div class="col-2">
                <img src="/admin/images/file-icon.svg">
            </div>
            <div class="col-10">
                <a href="" target="_blank">
                    <p class="deal-card-5-bill-name" id="deal-card-7-bill1-name"></p>
                    <p class="deal-card-5-bill-date" id="deal-card-7-bill1-date"></p>
                </a>
                <button onclick="deleteDealBrandFile(0,0,this)" type="button" class="mb-2 btn btn-sm btn-outline-primary mr-1 delete-btn">Удалить</button>
            </div>
        </div>
    </div>

    <div style="display: none" class="clone-deal-other-file-item">
        <div class="d-flex flex-wrap no-gutters align-items-center justify-content-between" id="deal-card-7-bill1">
            <div class="col-2">
                <img src="/admin/images/file-icon.svg">
            </div>
            <div class="col-10">
                <a href="" target="_blank">
                    <p class="deal-card-5-bill-name" id="deal-card-7-bill1-name"></p>
                    <p class="deal-card-5-bill-date" id="deal-card-7-bill1-date"></p>
                </a>
                <button onclick="deleteDealOtherFile(0,0,this)" type="button" class="mb-2 btn btn-sm btn-outline-primary mr-1 delete-btn">Удалить</button>
            </div>
        </div>
    </div>


    @if($row['deal_id'] > 0)
        <script>
            $(document).ready(function(){
                $(".task-small-card-block").empty();
                $(".task-small-card-block").load("/admin/load-deal-task/{{$row['deal_id']}}");
                $(".client-answers-block").load("/admin/load-client-answers/" + $(".deal-id-hidden").val());
                $(".shipping-comment-block").load("/admin/load-shipping-comment/" + $(".deal-id-hidden").val());
                $(".delivery-comment-block").load("/admin/load-delivery-comment/" + $(".deal-id-hidden").val());
                $(".deal-history-block").load("/admin/load-deal-history/" + $(".deal-id-hidden").val());
                $(".deal-bill-file-block").load("/admin/load-deal-bill-file/" + $(".deal-id-hidden").val());
                $(".deal-kp-file-block").load("/admin/load-deal-kp-file/" + $(".deal-id-hidden").val());
                $(".deal-close-file-block").load("/admin/load-deal-close-file/" + $(".deal-id-hidden").val());
                $(".shipping-client-comment-block").load("/admin/load-shipping-client-comment/" + $(".deal-id-hidden").val());
                $(".delivery-client-comment-block").load("/admin/load-delivery-client-comment/" + $(".deal-id-hidden").val());
            })
        </script>
    @endif

    <script>//scroll on click
        var $scroller = $('.scroller');
        // assign click handler
        $('.deal-status').on('click', function () {
            // get the partial id of the div to scroll to
            var divIdx = $(this).attr('data-deal-stage');

            // retrieve the jquery ref to the div
            var scrollTo = $('#'+divIdx)
            // retrieve its position relative to its parent
                .position().left;
            console.log(scrollTo);
            // simply update the scroll of the scroller
            // $('.scroller').scrollLeft(scrollTo);
            // use an animation to scroll to the destination
            $scroller
                .animate({'scrollLeft': scrollTo}, 500);
        });

        document.getElementById('deal-card-3-form-percents').onclick = function(){
            if (document.getElementById('deal-card-3-form-percents').checked) {
                document.getElementById('percent').style.color = '#007bff';
                document.getElementById('number').style.color = '#5a6169';
                document.getElementById('percent').style.fontWeight = 'bold';
                document.getElementById('number').style.fontWeight = 'normal';
            } else {
                document.getElementById('percent').style.color = '#5a6169';
                document.getElementById('number').style.color = '#007bff';
                document.getElementById('percent').style.fontWeight = 'normal';
                document.getElementById('number').style.fontWeight = 'bold';
            }
        }
    </script>

    <script>
        $(document).ready(function(){
            $("#deal-card-5-form-sum").on("keyup",function(){
                $("#deal_bill_total_sum").val($("#deal_bill_tonn_sum").val()*$(this).val());
            });
            $("#deal-card-9-form-sum").on("keyup",function(){
                $("#deal_bill_total_sum2").val($("#deal_bill_tonn_sum2").val()*$(this).val());
            });

            $(".timepicker-input").timepicker();
            $("#deal_fact_volume").on("keyup",function(event){
                $("#deal_rest_volume").val($(".plan-deal-volume").val() - $("#deal_fact_volume").val());

                $.ajax({
                    type: 'GET',
                    url: "/admin/calculate-deal-rest-volume-sum",
                    data: {_token: CSRF_TOKEN, deal_id: $(".deal-id-hidden").val(), deal_rest_volume: $("#deal_rest_volume").val()},
                    success: function(data){
                        if(data.result == false){
                            Notify("Ошибка при получении данных об станции", null, null, 'danger');
                        }
                        else{
                            $("#deal_rest_volume_in_sum").val(data.sum);
                        }
                    }
                });
            });
            $("#brand_deal_file_src").on("change",function(event){
                event.preventDefault();

                //grab all form data
                var formData = new FormData($("#deal-card-7-file-form")[0]);

                $.ajax({
                    url:'/admin/upload-deal-file',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if(data.success == true){
                            Notify("Ваш файл успешно загружен", null, null, 'success');
                            a = $(".clone-deal-brand-file-item").clone();
                            a.removeClass("clone-deal-brand-file-item");
                            a.addClass("deal-brand-file-item");
                            a.css("display","block");
                            a.find("a").attr("href","/deal_files/" + data.deal_file_src);
                            a.find("#deal-card-7-bill1-name").html(data.deal_file_name);
                            a.find("#deal-card-7-bill1-date").html(data.deal_file_date);
                            a.find(".delete-btn").attr("onclick","deleteDealBrandFile(" + data.deal_file_id + ", " + data.deal_file_deal_id + ",this)");
                            $(".deal-brand-files-block").append(a);
                        }
                        else if(data.success == "not_file"){
                            Notify("Прикрепите файл", null, null, 'danger');
                        }
                        else{
                            Notify("Ошибка при загрузке файла", null, null, 'danger');
                        }
                    }
                });
            });
        });

        $(document).ready(function(){
            $("#deal-card-1-form").validate({
                rules : {
                    client_fio : {required : true},
                    client_phone : {required : true},
                    email : {required : true, email: true},
                    deal_user_id1: {min:1}
                },
                messages:{
                    client_fio: {required : ""},
                    client_phone : {required : ""},
                    email : {required : "", email: true},
                    deal_user_id1: {min: ""}
                }
            });
            $("#deal-card-2-form").validate({
                rules : {
                    deal_user_id2: {min:1},
                    deal_volume: {min:1},
                    deal_brand_id: {min:1},
                    deal_mark_id: {min:1},
                    deal_fraction_id: {min:1},
                    deal_region_id: {min:1},
                    deal_station_id: {min:1}
                },
                messages:{
                    deal_user_id2: {min: ""},
                    deal_volume: {min: ""},
                    deal_brand_id: {min: ""},
                    deal_mark_id: {min: ""},
                    deal_fraction_id: {min: ""},
                    deal_region_id: {min: ""},
                    deal_station_id: {min: ""}
                }
            });
            $(".deal-card-2-kp-form").validate({
                rules : {
                    deal_user_id2: {min:1},
                    deal_volume: {min:1},
                    deal_brand_id: {min:1},
                    deal_mark_id: {min:1},
                    deal_fraction_id: {min:1},
                    deal_region_id: {min:1},
                    deal_station_id: {min:1}
                },
                messages:{
                    deal_user_id2: {min: ""},
                    deal_volume: {min: ""},
                    deal_brand_id: {min: ""},
                    deal_mark_id: {min: ""},
                    deal_fraction_id: {min: ""},
                    deal_region_id: {min: ""},
                    deal_station_id: {min: ""}
                }
            });
            $("#deal-card-3-form").validate({
                rules : {
                    deal_user_id3: {min:1}
//                    deal_user_answer: {required:true},
//                    deal_discount: {required:true}
                },
                messages:{
                    deal_user_id3: {min: ""}
//                    deal_user_answer: {required: ""},
//                    deal_discount: {required: ""}
                }
            });
            $("#deal-card-4-form").validate({
                rules : {
                    deal_user_id4: {min:1},
                    deal_payment_id: {min:1},
                    deal_delivery_id: {min:1},
                    company_bank_id: {min:1},
                    company_name: {required:true},
                    company_address: {required:true},
                    company_bank_bin: {required:true, minlength: 12, maxlength: 12,digits: true},
                    company_bank_iik: {required:true, minlength: 20, maxlength: 20},
                    company_ceo_position: {required:true},
                    company_ceo_name: {required:true},
                    deal_receiver_code: {required:true}
                },
                messages:{
                    deal_user_id4: {min: ""},
                    deal_payment_id: {min: ""},
                    deal_delivery_id: {min: ""},
                    company_bank_id: {min: ""},
                    company_name: {required: ""},
                    company_address: {required: ""},
                    company_bank_bin: {required: "", minlength: "", maxlength: "", digits: ""},
                    company_bank_iik: {required: "", minlength: "", maxlength: ""},
                    company_ceo_position: {required: ""},
                    company_ceo_name: {required: ""},
                    deal_receiver_code: {required: ""}
                }
            });
            $("#deal-card-5-form").validate({
                rules : {
                    deal_user_id5: {min:1}
                },
                messages:{
                    deal_user_id5: {min: ""}
                }
            });
            $("#deal-card-6-form").validate({
                rules : {
                    deal_user_id6: {min:1}
                },
                messages:{
                    deal_user_id6: {min: ""}
                }
            });

            $("#deal-card-7-form").validate({
                ignore: "",
                rules : {
                    deal_user_id7: {min:1},
                    deal_brand_sum: {required:true}
                },
                messages:{
                    deal_user_id7: {min: ""},
                    deal_brand_sum: {required: ""}
                }
            });
            $("#deal-card-8-form").validate({
                rules : {
                    deal_user_id8: {min:1},
                    deal_shipping_date: {required:true},
//                    deal_shipping_time: {required:true},
                    deal_fact_volume: {min:0},
                    deal_rest_volume: {min:0},
                    deal_rest_volume_in_sum: {min:0}
//                    deal_shipping_comment: {required:true}
                },
                messages:{
                    deal_user_id8: {min: ""},
                    deal_shipping_date: {required: ""},
//                    deal_shipping_time: {required: ""},
                    deal_fact_volume: {min: ""},
                    deal_rest_volume: {min: ""},
                    deal_rest_volume_in_sum: {min: ""}
//                    deal_shipping_comment: {required: true}
                }
            });
            $("#deal-card-9-form").validate({
                rules : {
                    deal_user_id9: {min:1},
                    deal_delivery_date: {required:true}
//                    deal_delivery_time: {required:true}
//                    deal_delivery_comment: {required:true}
                },
                messages:{
                    deal_user_id9: {min: ""},
                    deal_delivery_date: {required: ""}
//                    deal_delivery_time: {required: ""}
//                    deal_delivery_comment: {required: true}
                }
            });
            $("#deal-card-10-form").validate({
                ignore: "",
                rules : {
                    deal_user_id10: {min:1}
                },
                messages:{
                    deal_user_id10: {min: ""}
                }
            });
            $("#deal-bill-form").validate({
                rules : {
                    deal_bill_volume: {required:true}
                },
                messages:{
                    deal_bill_volume: {required: ""}
                }
            });
            $("#deal-close-deal-form").validate({
                rules : {
                    deal_bill_volume: {required:true}
                },
                messages:{
                    deal_bill_volume: {required: ""}
                }
            });
            $("#deal-refuse-form-new").validate({
                rules : {
                    deal_id: {required:true},
                    deal_refuse_user_id: {required:true},
                    comment: {required:true}
                },
                messages:{
                    deal_id: {required: ""},
                    deal_refuse_user_id: {required: ""},
                    comment: {required: ""}
                }
            });
            $("#deal-tasks-form").validate({
                rules : {
                    user_task_user_id: {min:1},
                    user_task_start_date: {required:true},
                    user_task_start_time: {required:true},
                    user_task_end_date: {required:true},
                    user_task_end_time: {required:true},
                    user_task_text: {required:true}
                },
                messages:{
                    user_task_user_id: {min: ""},
                    user_task_start_date: {required: ""},
                    user_task_start_time: {required: ""},
                    user_task_end_date: {required: ""},
                    user_task_end_time: {required: ""},
                    user_task_text: {required: ""}
                }
            });
        });

        function sendDealForm(deal_form_id){
            if (!$("#deal-card-" + deal_form_id + "-form").valid()){
                return false;
            }

            $.ajax({
                type: 'POST',
                url: "/admin/save-deal-info",
                data: $("#deal-card-" + deal_form_id + "-form").serialize(),
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при сохранение данных формы", null, null, 'danger');
                    }
                    else if(data.result == "incorrect_status"){
                        Notify("Текущая форма недоступна", null, null, 'danger');
                    }
                    else if(data.result == "error_save_brand_file"){
                        Notify("Ошибка при формировании файла разрезу", null, null, 'danger');
                    }
                    else if(data.result == "error_send_brand_mail"){
                        Notify("Ошибка при отправки email разрезу", null, null, 'danger');
                    }
                    else{
                        if(data.deal_row['deal_status_id'] == 11 && deal_form_id == 10){
//                            alert("Сделка успешно завершена");
                            window.location.href = "/admin/deal-list?type=list";
                        }
                        else{
                            current_status = data.deal_row['deal_status_id'];
                            prev_status = current_status - 1;
                            $(".deal-card-single-wrapper").find(".deal-card-single").removeClass("current");
                            $("#deal-card-" + current_status).find(".deal-card-single").addClass("current");

                            if(deal_form_id == 1){
                                var obj = { Title: 'Komir.kz | Личный кабинет', Url: '/admin/deal-edit/' + data.deal_row['deal_id'] };
                                history.pushState(obj, obj.Title, obj.Url);

                                $(".client-select-block").fadeOut();
                            }
                            else if(deal_form_id == 2){
                                $(".brand-span-new").html(data.deal_row['brand_name']);
                                $(".mark-span-new").html(data.deal_row['mark_name']);
                                $(".fraction-span-new").html(data.deal_row['fraction_name']);
                                $(".deal-volume-span-new").html(data.deal_row['deal_volume']);
                                $(".region-span-new").html(data.deal_row['region_name']);
                                $(".station-span-new").html(data.deal_row['station_name']);
                                $(".price-span-new").html(data.deal_row['deal_kp_sum']);
                            }
                            else if(deal_form_id == 3){
                                discount_sum = data.deal_row['deal_discount'];
                                if(data.deal_row['deal_discount_type'] == 1){
                                    discount_sum = data.deal_row['deal_kp_sum']*data.deal_row['deal_discount']/100;
                                }
                                kp_sum = data.deal_row['deal_kp_sum'] - discount_sum;
                                $(".deal-dogovor-sum").html("Сумма договора: " + kp_sum);
                            }
                            else if(deal_form_id == 4){
                                $(".company-select-block").fadeOut();
                            }

                            $("#deal_bill_tonn_sum").val(data.deal_row['deal_bill_tonn_sum']);
                            $("#deal_bill_total_sum").val($("#deal_bill_tonn_sum").val()*$("#deal-card-5-form-sum").val());
                            $("#deal_bill_tonn_sum2").val(data.deal_row['deal_bill_tonn_sum']);
                            $("#deal_bill_total_sum2").val($("#deal_bill_tonn_sum2").val()*$("#deal-card-9-form-sum").val());
                            $("#deal_client_id").val(data.deal_row['deal_client_id']);
                            $("#company_id").val(data.deal_row['company_id']);
                            $("#deal-card-6-consignee").html(data.deal_row['company_name']);
                            $("#deal-card-6-BIN").html(data.deal_row['company_bank_bin']);
                            $("#deal-card-6-station").html(data.deal_row['station_name']);
                            $("#deal-card-6-stationCode").html(data.deal_row['station_code']);
                            $("#deal-card-6-address").html(data.deal_row['company_delivery_address']);
                            $("#deal-card-6-okpo").html(data.deal_row['company_okpo']);
                            $("#deal-card-6-receiverCode").html(data.deal_row['deal_receiver_code']);
                            $("#deal-card-6-fraction").html(data.deal_row['fraction_name']);
                            $("#deal-card-6-quantity").html(Math.ceil(data.deal_row['deal_volume']/70));

                            $("#deal_user_id2").val(data.deal_row['deal_user_id2']).trigger('change');
                            $("#deal_user_id3").val(data.deal_row['deal_user_id3']).trigger('change');
                            $("#deal_user_id4").val(data.deal_row['deal_user_id4']).trigger('change');
                            $("#deal-card-1-date").html(data.deal_row['deal_datetime1_format']);
                            $("#deal-card-2-date").html(data.deal_row['deal_datetime2_format']);
                            $("#deal-card-3-date").html(data.deal_row['deal_datetime3_format']);
                            $("#deal-card-4-date").html(data.deal_row['deal_datetime4_format']);
                            $("#deal-card-5-date").html(data.deal_row['deal_datetime5_format']);
                            $("#deal-card-6-date").html(data.deal_row['deal_datetime6_format']);
                            $("#deal-card-7-date").html(data.deal_row['deal_datetime7_format']);
                            $("#deal-card-8-date").html(data.deal_row['deal_datetime8_format']);
                            $("#deal-card-9-date").html(data.deal_row['deal_datetime9_format']);
                            $(".plan-deal-volume").html(data.deal_row['deal_volume']);
                            $(".plan-deal-volume").val(data.deal_row['deal_volume']);
                            $(".deal-id-hidden").val(data.deal_row['deal_id']);
                            $(".deal-status-li" + prev_status).removeClass("current").addClass("complete");
                            if(deal_form_id == 4 && data.deal_row['deal_status_id'] == 6){
                                $(".deal-status-li4").removeClass("current").addClass("complete");
                            }
                            $(".deal-status-li" + data.deal_row['deal_status_id']).addClass("current");
                            $(".task-small-card-block").empty();
                            $(".task-small-card-block").load("/admin/load-deal-task/" + data.deal_row['deal_id']);
                            $(".notifications").load("/admin/load-notifications");
                            $(".deal-history-block").empty();
                            $(".deal-history-block").load("/admin/load-deal-history/" + $(".deal-id-hidden").val());
//                            window.location.href = "/admin/deal-edit/" + data.deal_id;
                        }
                    }
                }
            });
        }

        function calculateDealSum(){
            if (!$(".deal-card-2-kp-form").valid()){
                return false;
            }
            $.ajax({
                type: 'post',
                url: "/admin/calculate-deal-kp-sum",
                data: $("#deal-card-2-form").serialize(),
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при получении данных об станции", null, null, 'danger');
                    }
                    else{
                        $("#deal-card-2-price").val(data.sum);
                        $(".process2-btn").fadeIn();
                    }
                }
            });
        }

        function formulateDealKp(){
            if (!$("#deal-card-2-form").valid()){
                return false;
            }
            $.ajax({
                type: 'post',
                url: "/admin/formulate-deal-kp",
                data: $("#deal-card-2-form").serialize(),
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при получении создании КП", null, null, 'danger');
                    }
                    else{
                        $(".deal-kp-file-block").empty();
                        $(".deal-kp-file-block").load("/admin/load-deal-kp-file/" + $(".deal-id-hidden").val());
                    }
                }
            });
        }

        function setDealUser(deal_user_num,ob){
            $("#deal_user_id" +deal_user_num).val($(ob).val());
        }

        function saveNewUserTask(){
            if (!$("#deal-tasks-form").valid()){
                return false;
            }

            $.ajax({
                type: 'POST',
                url: "/admin/save-new-user-task",
                data: $("#deal-tasks-form").serialize(),
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при сохранении новой задачи", null, null, 'danger');
                    }
                    else if(data.result == "error_user"){
                        Notify("Ответственный не найден в базе", null, null, 'danger');
                    }
                    else if(data.result == "error_sending_mail"){
                        Notify("Ошибка при отправке письмо напоминание о задаче", null, null, 'danger');
                    }
                    else if(data.result == "incorrect_date"){
                        Notify("Дата задачи неверно указаны", null, null, 'danger');
                    }
                    else{
                        document.getElementById("deal-tasks-form").reset();
                        $(".deal-task-user-select").val(0).trigger("change");
                        $(".task-small-card-block").empty();
                        $(".task-small-card-block").load("/admin/load-deal-task/{{$row['deal_id']}}");
                        $(".notifications").load("/admin/load-notifications");
                    }
                }
            });
        }

        function addNewClient(){
            $(".client-select-block").css("display","none");
            $("#client_id_list").val(0);
            $("#deal_client_id").val(0);
            $(".deal-client-input").val("");
        }

        function setClientInfo(){
            client_fio = $( "#client_id_list option:selected" ).data("client-fio");
            client_id = $( "#client_id_list option:selected" ).data("client-id");
            client_email = $( "#client_id_list option:selected" ).data("client-email");
            client_phone = $( "#client_id_list option:selected" ).data("client-phone");
            $("#deal_client_id").val(client_id);
            $("#deal-card-1-form-name").val(client_fio);
            $("#deal-card-1-form-phone").val(client_phone);
            $("#deal-card-1-form-email").val(client_email);

        }

        function showClientSelectBlock(){
            $("#client_id_list").val(0);
            $(".client-select-block").fadeIn();
        }

        function addNewCompany(){
            $(".company-select-block").css("display","none");
            $("#company_id_list").val(0);
            $("#company_id").val(0);
            $(".deal-company-input").val("");
            $("#deal-card-4-form-bank").val(0).trigger('change');
        }

        function setCompanyInfo(){
            company_id = $( "#company_id_list option:selected" ).data("company-id");
            company_name = $( "#company_id_list option:selected" ).data("company-name");
            company_address = $( "#company_id_list option:selected" ).data("company-address");
            company_bank_bin = $( "#company_id_list option:selected" ).data("company-bin");
            company_bank_id = $( "#company_id_list option:selected" ).data("company-bank-id");
            company_bank_iik = $( "#company_id_list option:selected" ).data("company-iik");
            company_ceo_position = $( "#company_id_list option:selected" ).data("company-ceo-position");
            company_ceo_name = $( "#company_id_list option:selected" ).data("company-ceo-name");
            company_delivery_address = $( "#company_id_list option:selected" ).data("company-delivery-address");
            company_okpo = $( "#company_id_list option:selected" ).data("company-okpo");
            $("#company_id").val(company_id);
            $("#deal-card-4-form-companyName").val(company_name);
            $("#deal-card-4-form-companyAddress").val(company_address);
            $("#deal-card-4-form-bankBIN").val(company_bank_bin);
            $("#deal-card-4-form-bank").val(company_bank_id);
            $("#deal-card-4-form-bankIIK").val(company_bank_iik);
            $("#deal-card-4-form-companyCEOPosition").val(company_ceo_position);
            $("#deal-card-4-form-companyCEOName").val(company_ceo_name);
            $("#deal-card-4-form-companyDeliveryAddress").val(company_delivery_address);
            $("#deal-card-4-form-companyOkpo").val(company_okpo);

        }

        function showCompanySelectBlock(){
            $("#company_id_list").val(0);
            $(".company-select-block").fadeIn();
        }

        function addClientAnswer(){
            if($("#deal-card-3-form-answer").val().length < 1 || $("#deal_user_id3").val() < 1){
                Notify("Заполните ответственного и ответ клиента", null, null, 'danger');
                return false;
            }

            $.ajax({
                type: 'POST',
                url: "/admin/save-client-answer",
                data: $("#deal-card-3-form").serialize(),
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при сохранение ответа клиента", null, null, 'danger');
                    }
                    else if(data.result == "incorrect_status"){
                        Notify("Текущая форма недоступна", null, null, 'danger');
                    }
                    else{
                        $("#deal-card-3-form-answer").val("");
                        $(".client-answers-block").load("/admin/load-client-answers/" + $(".deal-id-hidden").val());
                    }
                }
            });
        }

        function deleteClientAnswer(client_answer_id,ob){
            if (!confirm('Вы действительно хотите удалить ответ клиента?')) {
                return false;
            }

            $.ajax({
                type: 'GET',
                url: "/admin/delete-client-answer",
                data: {_token: CSRF_TOKEN, client_answer_id: client_answer_id},
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при удалении ответа клиента", null, null, 'danger');
                    }
                    else{
                        $(ob).closest(".task-small-card").remove();
                    }
                }
            });
        }

        function addShippingComment(){
            if($("#deal-card-8-form-comment").val().length < 1 || $("#deal_user_id8").val() < 1){
                Notify("Заполните ответственного и комментарии", null, null, 'danger');
                return false;
            }

            $.ajax({
                type: 'POST',
                url: "/admin/save-shipping-comment",
                data: $("#deal-card-8-form").serialize(),
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при сохранение комментарии по отгрузке", null, null, 'danger');
                    }
                    else if(data.result == "incorrect_status"){
                        Notify("Текущая форма недоступна", null, null, 'danger');
                    }
                    else{
                        $("#deal-card-8-form-comment").val("");
                        $(".shipping-comment-block").load("/admin/load-shipping-comment/" + $(".deal-id-hidden").val());
                    }
                }
            });
        }

        function addShippingClientComment(){
            if($("#deal-card-8-form-client-comment").val().length < 1 || $("#deal_user_id8").val() < 1){
                Notify("Заполните ответственного и комментарии", null, null, 'danger');
                return false;
            }

            $.ajax({
                type: 'POST',
                url: "/admin/save-shipping-client-comment",
                data: $("#deal-card-8-form").serialize(),
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при сохранение комментарии по отгрузке для клиента", null, null, 'danger');
                    }
                    else if(data.result == "incorrect_status"){
                        Notify("Текущая форма недоступна", null, null, 'danger');
                    }
                    else{
                        $("#deal-card-8-form-client-comment").val("");
                        $(".shipping-client-comment-block").load("/admin/load-shipping-client-comment/" + $(".deal-id-hidden").val());
                    }
                }
            });
        }

        function deleteShippingComment(shipping_comment_id,ob){
            if (!confirm('Вы действительно хотите удалить комментарии отгрузки?')) {
                return false;
            }

            $.ajax({
                type: 'GET',
                url: "/admin/delete-shipping-comment",
                data: {_token: CSRF_TOKEN, shipping_comment_id: shipping_comment_id},
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при удалении комментарии отгрузки", null, null, 'danger');
                    }
                    else{
                        $(ob).closest(".task-small-card").remove();
                    }
                }
            });
        }

        function deleteShippingClientComment(shipping_client_comment_id,ob){
            if (!confirm('Вы действительно хотите удалить комментарии отгрузки для клиента?')) {
                return false;
            }

            $.ajax({
                type: 'GET',
                url: "/admin/delete-shipping-client-comment",
                data: {_token: CSRF_TOKEN, shipping_client_comment_id: shipping_client_comment_id},
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при удалении комментарии отгрузки для клиента", null, null, 'danger');
                    }
                    else{
                        $(ob).closest(".task-small-card").remove();
                    }
                }
            });
        }

        function addDeliveryComment(){
            if($("#deal-card-9-form-comment").val().length < 1 || $("#deal_user_id9").val() < 1){
                Notify("Заполните ответственного и комментарии", null, null, 'danger');
                return false;
            }

            $.ajax({
                type: 'POST',
                url: "/admin/save-delivery-comment",
                data: $("#deal-card-9-form").serialize(),
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при сохранение комментарии по доставке", null, null, 'danger');
                    }
                    else if(data.result == "incorrect_status"){
                        Notify("Текущая форма недоступна", null, null, 'danger');
                    }
                    else{
                        $("#deal-card-9-form-comment").val("");
                        $(".delivery-comment-block").load("/admin/load-delivery-comment/" + $(".deal-id-hidden").val());
                    }
                }
            });
        }

        function deleteDeliveryComment(delivery_comment_id,ob){
            if (!confirm('Вы действительно хотите удалить комментарии доставки?')) {
                return false;
            }

            $.ajax({
                type: 'GET',
                url: "/admin/delete-delivery-comment",
                data: {_token: CSRF_TOKEN, delivery_comment_id: delivery_comment_id},
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при удалении комментарии доставки", null, null, 'danger');
                    }
                    else{
                        $(ob).closest(".task-small-card").remove();
                    }
                }
            });
        }

        function addDeliveryClientComment(){
            if($("#deal-card-9-form-client-comment").val().length < 1 || $("#deal_user_id9").val() < 1){
                Notify("Заполните ответственного и комментарии", null, null, 'danger');
                return false;
            }

            $.ajax({
                type: 'POST',
                url: "/admin/save-delivery-client-comment",
                data: $("#deal-card-9-form").serialize(),
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при сохранение комментарии по доставке для клиента", null, null, 'danger');
                    }
                    else if(data.result == "incorrect_status"){
                        Notify("Текущая форма недоступна", null, null, 'danger');
                    }
                    else{
                        $("#deal-card-9-form-client-comment").val("");
                        $(".delivery-client-comment-block").load("/admin/load-delivery-client-comment/" + $(".deal-id-hidden").val());
                    }
                }
            });
        }

        function deleteDeliveryClientComment(delivery_client_comment_id,ob){
            if (!confirm('Вы действительно хотите удалить комментарии доставки для клиента?')) {
                return false;
            }

            $.ajax({
                type: 'GET',
                url: "/admin/delete-delivery-client-comment",
                data: {_token: CSRF_TOKEN, delivery_client_comment_id: delivery_client_comment_id},
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при удалении комментарии доставки для клиента", null, null, 'danger');
                    }
                    else{
                        $(ob).closest(".task-small-card").remove();
                    }
                }
            });
        }

        function downloadDealKp(){
            $.ajax({
                type: 'GET',
                url: "/admin/download-deal-kp",
                data: {_token: CSRF_TOKEN, deal_id: $(".deal-id-hidden").val()},
                success: function(data){
                    if(data.result['result'] == false){
                        Notify("Ошибка при скачивании файла КП", null, null, 'danger');
                    }
                    else{
                        window.open(data.result['filename']);
                    }
                }
            });
        }

        function sendKpMail(){
            $.ajax({
                type: 'GET',
                url: "/admin/send-kp-mail",
                data: {_token: CSRF_TOKEN, deal_id: $(".deal-id-hidden").val()},
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при отправки email", null, null, 'danger');
                    }
                    else{
                        Notify("Email успешно отправлен", null, null, 'success');
                    }
                }
            });
        }

        function createDealBill(){
            if (!$("#deal-bill-form").valid()){
                return false;
            }
            $.ajax({
                type: 'POST',
                url: "/admin/create-deal-bill-file",
                data: $("#deal-bill-form").serialize(),
                success: function(data){
                    if(data.result['result'] == false){
                        Notify("Ошибка при создании счета", null, null, 'danger');
                    }
                    else{
                        document.getElementById("deal-bill-form").reset();
                        $(".deal-bill-file-block").empty();
                        $(".deal-bill-file-block").load("/admin/load-deal-bill-file/" + $(".deal-id-hidden").val());
                    }
                }
            });
        }

        function createDealCloseBill(){
            if (!$("#deal-close-deal-form").valid()){
                return false;
            }
            $.ajax({
                type: 'POST',
                url: "/admin/create-deal-close-file",
                data: $("#deal-close-deal-form").serialize(),
                success: function(data){
                    if(data.result['result'] == false){
                        Notify("Ошибка при создании счета закрытия", null, null, 'danger');
                    }
                    else{
                        document.getElementById("deal-close-deal-form").reset();
                        $(".deal-close-file-block").empty();
                        $(".deal-close-file-block").load("/admin/load-deal-close-file/" + $(".deal-id-hidden").val());
                    }
                }
            });
        }

        function sendDealBill(deal_file_id,deal_file_deal_id){
            $.ajax({
                type: 'GET',
                url: "/admin/send-bill-mail",
                data: {_token: CSRF_TOKEN, deal_file_deal_id: deal_file_deal_id, deal_file_id:deal_file_id},
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при отправки email", null, null, 'danger');
                    }
                    else{
                        Notify("Email успешно отправлен", null, null, 'success');
                    }
                }
            });
        }

        function sendDealBillClose(deal_file_id,deal_file_deal_id){
            $.ajax({
                type: 'GET',
                url: "/admin/send-bill-mail-close",
                data: {_token: CSRF_TOKEN, deal_file_deal_id: deal_file_deal_id, deal_file_id:deal_file_id},
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при отправки email", null, null, 'danger');
                    }
                    else{
                        Notify("Email успешно отправлен", null, null, 'success');
                    }
                }
            });
        }

        function deleteDealBill(deal_file_id,deal_file_deal_id){
            $.ajax({
                type: 'GET',
                url: "/admin/delete-deal-file",
                data: {_token: CSRF_TOKEN, deal_file_deal_id: deal_file_deal_id, deal_file_id:deal_file_id},
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при удалении счета на оплату", null, null, 'danger');
                    }
                    else{
                        $(".deal-bill-file-block").empty();
                        $(".deal-bill-file-block").load("/admin/load-deal-bill-file/" + $(".deal-id-hidden").val());
                    }
                }
            });
        }

        function deleteDealClose(deal_file_id,deal_file_deal_id){
            $.ajax({
                type: 'GET',
                url: "/admin/delete-deal-file",
                data: {_token: CSRF_TOKEN, deal_file_deal_id: deal_file_deal_id, deal_file_id:deal_file_id},
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при удалении счета закрытия", null, null, 'danger');
                    }
                    else{
                        $(".deal-close-file-block").empty();
                        $(".deal-close-file-block").load("/admin/load-deal-close-file/" + $(".deal-id-hidden").val());
                    }
                }
            });
        }

        function deleteDealKpFile(deal_file_id,deal_file_deal_id){
            $.ajax({
                type: 'GET',
                url: "/admin/delete-deal-kp-file",
                data: {_token: CSRF_TOKEN, deal_file_deal_id: deal_file_deal_id, deal_file_id:deal_file_id},
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при удалении файла КП", null, null, 'danger');
                    }
                    else{
                        $("#deal-card-2-form-brand").val(data.deal_row['deal_brand_id']).trigger('change');
                        $("#deal-card-2-form-mark").val(data.deal_row['deal_mark_id']).trigger('change');
                        $("#deal-card-2-form-fraction").val(data.deal_row['deal_fraction_id']).trigger('change');
                        $("#deal-card-1-form-volume").val(data.deal_row['deal_volume']);
                        $("#deal-card-2-price").val(data.deal_row['deal_kp_sum']);
                        $("#deal-card-2-form-region").val(data.deal_row['deal_region_id']).trigger('change');
                        showStationByRegion(null,data.deal_row['deal_region_id'],data.deal_row['deal_station_id']);

                        $(".brand-span-new").html(data.deal_row['brand_name']);
                        $(".mark-span-new").html(data.deal_row['mark_name']);
                        $(".fraction-span-new").html(data.deal_row['fraction_name']);
                        $(".deal-volume-span-new").html(data.deal_row['deal_volume']);
                        $(".region-span-new").html(data.deal_row['region_name']);
                        $(".station-span-new").html(data.deal_row['station_name']);
                        $(".price-span-new").html(data.deal_row['deal_kp_sum']);

                        $(".deal-kp-file-block").empty();
                        $(".deal-kp-file-block").load("/admin/load-deal-kp-file/" + $(".deal-id-hidden").val());
                    }
                }
            });
        }

        function deleteDealBrandFile(deal_file_id,deal_file_deal_id,ob){
            $.ajax({
                type: 'GET',
                url: "/admin/delete-deal-file",
                data: {_token: CSRF_TOKEN, deal_file_deal_id: deal_file_deal_id, deal_file_id:deal_file_id},
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при удалении файла разреза", null, null, 'danger');
                    }
                    else{
                        $(ob).closest(".deal-brand-file-item").remove();
                    }
                }
            });
        }

        function deleteDealOtherFile(deal_file_id,deal_file_deal_id,ob){
            $.ajax({
                type: 'GET',
                url: "/admin/delete-deal-file",
                data: {_token: CSRF_TOKEN, deal_file_deal_id: deal_file_deal_id, deal_file_id:deal_file_id},
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при удалении документа", null, null, 'danger');
                    }
                    else{
                        $(ob).closest(".deal-other-file-item").remove();
                    }
                }
            });
        }

        function sendDeliveryClientCommentEmail(delivery_client_comment_id,ob){
            $.ajax({
                type: 'GET',
                url: "/admin/send-delivery-client-comment-email",
                data: {_token: CSRF_TOKEN, delivery_client_comment_id: delivery_client_comment_id, deal_id: $(".deal-id-hidden").val()},
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при отправке клиенту комментарии по доставке", null, null, 'danger');
                    }
                    else{
                        Notify("Комментарии отправлено", null, null, 'success');
                    }
                }
            });
        }

        function sendShippingClientCommentEmail(shipping_client_comment_id,ob){
            $.ajax({
                type: 'GET',
                url: "/admin/send-shipping-client-comment-email",
                data: {_token: CSRF_TOKEN, shipping_client_comment_id: shipping_client_comment_id, deal_id: $(".deal-id-hidden").val()},
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при отправке клиенту комментарии по отгрузке", null, null, 'danger');
                    }
                    else{
                        Notify("Комментарии отправлено", null, null, 'success');
                    }
                }
            });
        }

        function setMarkFractionRegionStationList(ob){
            showMarkList($(ob).val(),0,0);
            showFractionList($(ob).val(),0,0);
            showRegionList($(ob).val(),0,0,0);
        }

        function showMarkList(ob_val,brand_id,mark_id){
            if(brand_id == 0){
                brand_id = ob_val;
            }
            $.ajax({
                type: 'GET',
                url: "/admin/get-mark-by-brand",
                data: {_token: CSRF_TOKEN, brand_id: brand_id},
                success: function(data){
                    $(".mark-option").remove();
                    $("#deal-card-2-form-mark").val(0);
                    $("#deal-card-2-form-mark").append(data);
                    if(mark_id > 0){
                        $("#deal-card-2-form-mark").val(mark_id).trigger('refresh');
                    }
                }
            });
        }

        function showFractionList(ob_val,brand_id,fraction_id){
            if(brand_id == 0){
                brand_id = ob_val;
            }
            $.ajax({
                type: 'GET',
                url: "/admin/get-fraction-by-brand",
                data: {_token: CSRF_TOKEN, brand_id: brand_id},
                success: function(data){
                    $(".fraction-option").remove();
                    $("#deal-card-2-form-fraction").val(0);
                    $("#deal-card-2-form-fraction").append(data);
                    if(fraction_id > 0){
                        $("#deal-card-2-form-fraction").val(fraction_id).trigger('refresh');
                    }
                }
            });
        }

        function showRegionList(ob_val,brand_id,region_id,station_id){
            if(brand_id == 0){
                brand_id = ob_val;
            }
            $.ajax({
                type: 'GET',
                url: "/admin/get-region-by-brand",
                data: {_token: CSRF_TOKEN, brand_id: brand_id},
                success: function(data){
                    $(".region-option").remove();
                    $("#deal-card-2-form-region").val(0);
                    $("#deal-card-2-form-region").append(data);
                    if(region_id > 0){
                        $("#deal-card-2-form-region").val(region_id).trigger('refresh');
                    }
                    showStationByRegion(null,region_id,station_id);
                }
            });
        }

        function showStationByRegion(ob,region_id,station_id){
            if(region_id == 0){
                region_id = $(ob).val();
            }
            $.ajax({
                type: 'GET',
                url: "/admin/get-station-by-region",
                data: {_token: CSRF_TOKEN, region_id: region_id},
                success: function(data){
                    $(".station-option").remove();
                    $("#deal-card-2-form-station").val(0);
                    $("#deal-card-2-form-station").append(data);
                    if(station_id > 0){
                        $("#deal-card-2-form-station").val(station_id).trigger('refresh');
                    }
                }
            });
        }

        function downloadDogovor(){
            $.ajax({
                type: 'GET',
                url: "/admin/download-dogovor",
                data: {_token: CSRF_TOKEN, deal_id: $(".deal-id-hidden").val()},
                success: function(data){
                    if(data.result['result'] == false){
                        Notify("Ошибка при скачивании договора", null, null, 'danger');
                    }
                    else{
                        window.open('/dogovor/dogovor' + $(".deal-id-hidden").val() + '.docx');
                    }
                }
            });
        }

        function sendDogovor(){
            $.ajax({
                type: 'GET',
                url: "/admin/send-dogovor",
                data: {_token: CSRF_TOKEN, deal_id: $(".deal-id-hidden").val()},
                success: function(data){
                    if(data.result['result'] == false){
                        Notify("Ошибка при отправке договора", null, null, 'danger');
                    }
                    else{
                        Notify("Договор успешно отправлен", null, null, 'success');
                    }
                }
            });
        }
    </script>
@endsection
