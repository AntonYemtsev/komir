@extends('admin.layout')

@section('content')
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row align-items-center no-gutters py-4">
            <div class="col-12 col-sm-2 d-flex text-center text-sm-left mb-0">
                {{--<h3 class="page-title">Сделки</h3>--}}
                <a class="change-view-type" href="/admin/deal-list?type=list">
                    <svg width="18" height="18" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="31" height="6" fill="#979797"/>
                        <rect width="31" height="6" fill="#979797"/>
                        <rect width="31" height="6" fill="#979797"/>
                        <rect y="12" width="31" height="7" fill="#979797"/>
                        <rect y="12" width="31" height="7" fill="#979797"/>
                        <rect y="12" width="31" height="7" fill="#979797"/>
                        <rect y="25" width="31" height="6" fill="#979797"/>
                        <rect y="25" width="31" height="6" fill="#979797"/>
                        <rect y="25" width="31" height="6" fill="#979797"/>
                    </svg>
                </a>
                <a class="change-view-type" href="/admin/deal-list?type=cards">
                    <svg width="18" height="18" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="30.9951" width="10" height="5.9991" transform="rotate(89.9917 30.9951 0)" fill="#007BFF"/>
                        <rect x="30.9951" width="10" height="5.9991" transform="rotate(89.9917 30.9951 0)" fill="#007BFF"/>
                        <rect x="30.9951" width="10" height="5.9991" transform="rotate(89.9917 30.9951 0)" fill="#007BFF"/>
                        <rect x="18.9971" y="0.00170898" width="20" height="6.99895" transform="rotate(89.9917 18.9971 0.00170898)" fill="#007BFF"/>
                        <rect x="18.9971" y="0.00170898" width="20" height="6.99895" transform="rotate(89.9917 18.9971 0.00170898)" fill="#007BFF"/>
                        <rect x="18.9971" y="0.00170898" width="20" height="6.99895" transform="rotate(89.9917 18.9971 0.00170898)" fill="#007BFF"/>
                        <rect x="5.99902" y="0.00366211" width="30.9956" height="5.9991" transform="rotate(89.9917 5.99902 0.00366211)" fill="#007BFF"/>
                        <rect x="5.99902" y="0.00366211" width="30.9956" height="5.9991" transform="rotate(89.9917 5.99902 0.00366211)" fill="#007BFF"/>
                        <rect x="5.99902" y="0.00366211" width="30.9956" height="5.9991" transform="rotate(89.9917 5.99902 0.00366211)" fill="#007BFF"/>
                    </svg>
                </a>
            </div>
            <div class="col-12 col-sm-7 d-flex text-center text-sm-left mb-0">
                <div class="col-6 col-sm-3">
                    {{--<select id="deal_type_id_select" class="form-control" name="deal_type_id" onchange="searchByDeals()">--}}
                        {{--<option value="">Тип заявки</option>--}}
                        {{--<option value="0" @if(strlen($deal_type_id) > 0 && $deal_type_id == 0) selected @endif>Активные</option>--}}
                        {{--<option value="1" @if($deal_type_id == 1) selected @endif>Завершенные</option>--}}
                        {{--<option value="2" @if($deal_type_id == 2) selected @endif>Отказанные</option>--}}
                    {{--</select>--}}
                    <a href="/admin/deal-list?type=cards">
                        <button type="button" name="submit" id="client-transporter-form-submit" class="mb-2 btn btn-primary mr-2">Обнулить</button>
                    </a>
                </div>
                <div class="col-6 col-sm-3">
                    <select id="client_id_select" class="form-control select2-search" name="user_id" onchange="searchByDeals()">
                        <option value="0">Клиент</option>
                        @if(@count($client_list) > 0)
                            @foreach($client_list as $key => $client_item)
                                <option value="{{$client_item['client_id']}}" @if($client_item['client_id'] == $client_id) selected @endif >{{$client_item['client_surname']}} {{ $client_item['client_name'] }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-6 col-sm-3">
                    <select id="status_id_select" class="form-control" name="status_id" onchange="searchByDeals()">
                        <option value="0">Статус</option>
                        @if(@count($status_list) > 0)
                            @foreach($status_list as $key => $status_item)
                                <option value="{{$status_item['status_id']}}" @if($status_item['status_id'] == $status_id) selected @endif >{{ $status_item['status_name'] }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-6 col-sm-3">
                    <select id="user_id_select" class="form-control select2-search" name="user_id" onchange="searchByDeals()">
                        <option value="0">Ответственный</option>
                        @if(@count($user_list) > 0)
                            @foreach($user_list as $key => $user_item)
                                <option value="{{$user_item['user_id']}}" @if($user_item['user_id'] == $user_id) selected @endif >{{$user_item['user_surname']}} {{ $user_item['user_name'] }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="col-12 col-sm-3 text-center text-sm-left mb-0">
                <!-- DO NOT CHANGE IDs IN DATE PICKER -->
                <div id="blog-overview-date-range" class="input-daterange input-group input-group-sm my-auto ml-auto mr-auto ml-sm-auto mr-sm-0" style="max-width: 350px;">
                    <input type="text" class="input-sm form-control date_from_input datepicker-here" name="date_from" placeholder="01.01.2019" id="blog-overview-date-range-1" style="height: calc(2.09375rem + 2px)" value="{{$date_from}}" onchange="searchByDeals()">
                    <input type="text" class="input-sm form-control date_to_input datepicker-here" data-position="bottom right" name="date_to" placeholder="02.01.2019" id="blog-overview-date-range-2" style="height: calc(2.09375rem + 2px)" value="{{$date_to}}" onchange="searchByDeals()">
                    <span class="input-group-append">
                    <span class="input-group-text" style="height: calc(2.09375rem + 2px)">
                      <i class="material-icons"></i>
                    </span>
                  </span>
                </div>
            </div>
        </div>
        <!--Main content-->
        <div class="deal-card-wrapper dragscroll">
            <div class="d-flex" style="width: auto">
                <div class="deal-card-single-wrapper" id="deal-card-1">
                    <div class="deal-card-single card card-small mb-4 pt-1">
                        <div class="card-header text-left">
                            <h5 class="mb-0">Заявка</h5>
                            <div class="d-flex flex-wrap no-gutters mt-2">
                                <div class="col-12 col-sm-6">
                                    <span>СДЕЛОК</span>
                                    <p id="tasks-card-1-dealsQuantity">{{@count($row_list[1])}}</p>
                                </div>
                                <div class="col-12 col-sm-6 text-sm-right">
                                    <span>СУММА</span>
                                    <?
                                    $all_deals_sum1 = DB::select( DB::raw("select
                                                                                         COALESCE( sum(CASE
                                                                                         WHEN t.deal_discount_type = 1 THEN t.deal_kp_sum - t.deal_kp_sum*t.deal_discount/100
                                                                                         ELSE t.deal_kp_sum - t.deal_discount
                                                                                         END),0) as deal_kp_sum_res
                                                                                    from deals t
                                                                                    where t.deal_status_id = 1"));
                                    ?>
                                    <p id="tasks-card-1-dealsSum">{{$all_deals_sum1[0]->deal_kp_sum_res}}</p>
                                </div>
                            </div>
                            <div class="rounded col-12 mt-3 py-2" style="background-color: #EA5876"></div>
                        </div>
                        <div class="card-body">
                            @if(@count($row_list[1]) > 0)
                                @foreach($row_list[1] as $key => $row_item)
                                    <div class="rounded border-primary border px-1 py-1 mb-2 task-small-card">
                                        <div class="d-flex align-items-center justify-content-between">

                                            <span class="task-small-card-client">
                                                <span class="task-small-card-status-text">
                                                   {{$row_item['client_surname']}} {{$row_item['client_name']}}
                                                </span>
                                            </span>

                                            <span class="task-small-card-date text-right">
                                                <span class="task-small-card-date-text">
                                                  {{$row_item['deal_datetime1_format']}}
                                                </span>
                                                <span class="task-small-card-date-icon text-primary">
                                                   <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </span>
                                        </div>
                                        <div>
                                            <p class="task-small-card-name my-2">
                                                {{$row_item['station_name']}} - {{$row_item['mark_name']}} {{$row_item['deal_volume']}} тонн
                                            </p>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span class="task-small-card-price">
                                               @if($row_item['deal_status_id'] <= 3)
                                                    {{$row_item['deal_kp_sum']}} тг.
                                                @elseif($row_item['deal_status_id'] >= 4)
                                                    <?
                                                    $discount_sum = $row_item['deal_discount'];
                                                    if($row_item['deal_discount_type'] == 1){
                                                        $discount_sum = $row_item['deal_kp_sum']*$row_item['deal_discount']/100;
                                                    }
                                                    ?>
                                                    {{$row_item['deal_kp_sum']-$discount_sum}} тг.
                                                @endif
                                            </span>

                                            <span class="task-small-card-status">
                                                Нет задач
                                                <span class="task-small-card-status-icon text-warning">
                                                    <i class="fas fa-circle"></i>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="deal-card-single-wrapper" id="deal-card-2">
                    <div class="deal-card-single card card-small mb-4 pt-1">
                        <div class="card-header text-left">
                            <h5 class="mb-0">Расчет КП</h5>
                            <div class="d-flex flex-wrap no-gutters mt-2">
                                <div class="col-12 col-sm-6">
                                    <span>СДЕЛОК</span>
                                    <p id="tasks-card-2-dealsQuantity">{{@count($row_list[2])}}</p>
                                </div>
                                <div class="col-12 col-sm-6 text-sm-right">
                                    <span>СУММА</span>
                                    <?
                                    $all_deals_sum2 = DB::select( DB::raw("select
                                                                                         COALESCE( sum(CASE
                                                                                         WHEN t.deal_discount_type = 1 THEN t.deal_kp_sum - t.deal_kp_sum*t.deal_discount/100
                                                                                         ELSE t.deal_kp_sum - t.deal_discount
                                                                                         END),0) as deal_kp_sum_res
                                                                                    from deals t
                                                                                    where t.deal_status_id = 2"));
                                    ?>
                                    <p id="tasks-card-2-dealsSum">{{$all_deals_sum2[0]->deal_kp_sum_res}}</p>
                                </div>
                            </div>
                            <div class="rounded col-12 mt-3 py-2" style="background-color: #00B8D8"></div>
                        </div>
                        <div class="card-body">
                            @if(@count($row_list[2]) > 0)
                                @foreach($row_list[2] as $key => $row_item)
                                    <div class="rounded border-primary border px-1 py-1 mb-2 task-small-card">
                                        <div class="d-flex align-items-center justify-content-between">

                                            <span class="task-small-card-client">
                                                <span class="task-small-card-status-text">
                                                   {{$row_item['client_surname']}} {{$row_item['client_name']}}
                                                </span>
                                            </span>

                                            <span class="task-small-card-date text-right">
                                                <span class="task-small-card-date-text">
                                                  {{$row_item['deal_datetime1_format']}}
                                                </span>
                                                <span class="task-small-card-date-icon text-primary">
                                                   <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </span>
                                        </div>
                                        <div>
                                            <p class="task-small-card-name my-2">
                                                {{$row_item['station_name']}} - {{$row_item['mark_name']}} {{$row_item['deal_volume']}} тонн
                                            </p>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between">
                                            <span class="task-small-card-price">
                                               @if($row_item['deal_status_id'] <= 3)
                                                    {{$row_item['deal_kp_sum']}} тг.
                                                @elseif($row_item['deal_status_id'] >= 4)
                                                    <?
                                                    $discount_sum = $row_item['deal_discount'];
                                                    if($row_item['deal_discount_type'] == 1){
                                                        $discount_sum = $row_item['deal_kp_sum']*$row_item['deal_discount']/100;
                                                    }
                                                    ?>
                                                    {{$row_item['deal_kp_sum']-$discount_sum}} тг.
                                                @endif
                                            </span>

                                            <span class="task-small-card-status">
                                                Нет задач
                                                <span class="task-small-card-status-icon text-warning">
                                                    <i class="fas fa-circle"></i>
                                                </span>
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="deal-card-single-wrapper" id="deal-card-3">
                    <div class="deal-card-single card card-small mb-4 pt-1">
                        <div class="card-header text-left">
                            <h5 class="mb-0">Переговоры</h5>
                            <div class="d-flex flex-wrap no-gutters mt-2">
                                <div class="col-12 col-sm-6">
                                    <span>СДЕЛОК</span>
                                    <p id="tasks-card-3-dealsQuantity">{{@count($row_list[3])}}</p>
                                </div>
                                <div class="col-12 col-sm-6 text-sm-right">
                                    <span>СУММА</span>
                                    <?
                                    $all_deals_sum3 = DB::select( DB::raw("select
                                                                                         COALESCE( sum(CASE
                                                                                         WHEN t.deal_discount_type = 1 THEN t.deal_kp_sum - t.deal_kp_sum*t.deal_discount/100
                                                                                         ELSE t.deal_kp_sum - t.deal_discount
                                                                                         END),0) as deal_kp_sum_res
                                                                                    from deals t
                                                                                    where t.deal_status_id = 3"));
                                    ?>
                                    <p id="tasks-card-3-dealsSum">{{$all_deals_sum3[0]->deal_kp_sum_res}}</p>
                                </div>
                            </div>
                            <div class="rounded col-12 mt-3 py-2" style="background-color: #313541"></div>
                        </div>
                        <div class="card-body">
                            @if(@count($row_list[3]) > 0)
                                @foreach($row_list[3] as $key => $row_item)
                                    <a href="/admin/deal-edit/{{$row_item['deal_id']}}">
                                        <div class="rounded border-primary border px-1 py-1 mb-2 task-small-card">
                                            <div class="d-flex align-items-center justify-content-between">

                                                <span class="task-small-card-client">
                                                    <span class="task-small-card-status-text">
                                                       {{$row_item['client_surname']}} {{$row_item['client_name']}}
                                                    </span>
                                                </span>

                                                <span class="task-small-card-date text-right">
                                                    <span class="task-small-card-date-text">
                                                      {{$row_item['deal_datetime1_format']}}
                                                    </span>
                                                    <span class="task-small-card-date-icon text-primary">
                                                       <i class="far fa-calendar-alt"></i>
                                                    </span>
                                                </span>
                                            </div>
                                            <div>
                                                <p class="task-small-card-name my-2">
                                                    {{$row_item['station_name']}} - {{$row_item['mark_name']}} {{$row_item['deal_volume']}} тонн
                                                </p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="task-small-card-price">
                                                   @if($row_item['deal_status_id'] <= 3)
                                                        {{$row_item['deal_kp_sum']}} тг.
                                                    @elseif($row_item['deal_status_id'] >= 4)
                                                        <?
                                                        $discount_sum = $row_item['deal_discount'];
                                                        if($row_item['deal_discount_type'] == 1){
                                                            $discount_sum = $row_item['deal_kp_sum']*$row_item['deal_discount']/100;
                                                        }
                                                        ?>
                                                        {{$row_item['deal_kp_sum']-$discount_sum}} тг.
                                                    @endif
                                                </span>

                                                <span class="task-small-card-status">
                                                    Нет задач
                                                    <span class="task-small-card-status-icon text-warning">
                                                        <i class="fas fa-circle"></i>
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="deal-card-single-wrapper" id="deal-card-4">
                    <div class="deal-card-single card card-small mb-4 pt-1">
                        <div class="card-header text-left">
                            <h5 class="mb-0">Договор</h5>
                            <div class="d-flex flex-wrap no-gutters mt-2">
                                <div class="col-12 col-sm-6">
                                    <span>СДЕЛОК</span>
                                    <p id="tasks-card-4-dealsQuantity">{{@count($row_list[4])}}</p>
                                </div>
                                <div class="col-12 col-sm-6 text-sm-right">
                                    <span>СУММА</span>
                                    <?
                                    $all_deals_sum4 = DB::select( DB::raw("select
                                                                                         COALESCE( sum(CASE
                                                                                         WHEN t.deal_discount_type = 1 THEN t.deal_kp_sum - t.deal_kp_sum*t.deal_discount/100
                                                                                         ELSE t.deal_kp_sum - t.deal_discount
                                                                                         END),0) as deal_kp_sum_res
                                                                                    from deals t
                                                                                    where t.deal_status_id = 4"));
                                    ?>
                                    <p id="tasks-card-4-dealsSum">{{$all_deals_sum4[0]->deal_kp_sum_res}}</p>
                                </div>
                            </div>
                            <div class="rounded col-12 mt-3 py-2" style="background-color: #674EEC"></div>
                        </div>
                        <div class="card-body">
                            @if(@count($row_list[4]) > 0)
                                @foreach($row_list[4] as $key => $row_item)
                                    <a href="/admin/deal-edit/{{$row_item['deal_id']}}">
                                        <div class="rounded border-primary border px-1 py-1 mb-2 task-small-card">
                                            <div class="d-flex align-items-center justify-content-between">

                                                <span class="task-small-card-client">
                                                    <span class="task-small-card-status-text">
                                                       {{$row_item['client_surname']}} {{$row_item['client_name']}}
                                                    </span>
                                                </span>

                                                <span class="task-small-card-date text-right">
                                                    <span class="task-small-card-date-text">
                                                      {{$row_item['deal_datetime1_format']}}
                                                    </span>
                                                    <span class="task-small-card-date-icon text-primary">
                                                       <i class="far fa-calendar-alt"></i>
                                                    </span>
                                                </span>
                                            </div>
                                            <div>
                                                <p class="task-small-card-name my-2">
                                                    {{$row_item['station_name']}} - {{$row_item['mark_name']}} {{$row_item['deal_volume']}} тонн
                                                </p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="task-small-card-price">
                                                   @if($row_item['deal_status_id'] <= 3)
                                                        {{$row_item['deal_kp_sum']}} тг.
                                                    @elseif($row_item['deal_status_id'] >= 4)
                                                        <?
                                                        $discount_sum = $row_item['deal_discount'];
                                                        if($row_item['deal_discount_type'] == 1){
                                                            $discount_sum = $row_item['deal_kp_sum']*$row_item['deal_discount']/100;
                                                        }
                                                        ?>
                                                        {{$row_item['deal_kp_sum']-$discount_sum}} тг.
                                                    @endif
                                                </span>

                                                <span class="task-small-card-status">
                                                    Нет задач
                                                    <span class="task-small-card-status-icon text-warning">
                                                        <i class="fas fa-circle"></i>
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="deal-card-single-wrapper" id="deal-card-5">
                    <div class="deal-card-single card card-small mb-4 pt-1">
                        <div class="card-header text-left">
                            <h5 class="mb-0">Счет на оплату</h5>
                            <div class="d-flex flex-wrap no-gutters mt-2">
                                <div class="col-12 col-sm-6">
                                    <span>СДЕЛОК</span>
                                    <p id="tasks-card-5-dealsQuantity">{{@count($row_list[5])}}</p>
                                </div>
                                <div class="col-12 col-sm-6 text-sm-right">
                                    <span>СУММА</span>
                                    <?
                                    $all_deals_sum5 = DB::select( DB::raw("select
                                                                                         COALESCE( sum(CASE
                                                                                         WHEN t.deal_discount_type = 1 THEN t.deal_kp_sum - t.deal_kp_sum*t.deal_discount/100
                                                                                         ELSE t.deal_kp_sum - t.deal_discount
                                                                                         END),0) as deal_kp_sum_res
                                                                                    from deals t
                                                                                    where t.deal_status_id = 5"));
                                    ?>
                                    <p id="tasks-card-5-dealsSum">{{$all_deals_sum5[0]->deal_kp_sum_res}}</p>
                                </div>
                            </div>
                            <div class="rounded col-12 mt-3 py-2" style="background-color: #17C671"></div>
                        </div>
                        <div class="card-body">
                            @if(@count($row_list[5]) > 0)
                                @foreach($row_list[5] as $key => $row_item)
                                    <a href="/admin/deal-edit/{{$row_item['deal_id']}}">
                                        <div class="rounded border-primary border px-1 py-1 mb-2 task-small-card">
                                            <div class="d-flex align-items-center justify-content-between">

                                                <span class="task-small-card-client">
                                                    <span class="task-small-card-status-text">
                                                       {{$row_item['client_surname']}} {{$row_item['client_name']}}
                                                    </span>
                                                </span>

                                                <span class="task-small-card-date text-right">
                                                    <span class="task-small-card-date-text">
                                                      {{$row_item['deal_datetime1_format']}}
                                                    </span>
                                                    <span class="task-small-card-date-icon text-primary">
                                                       <i class="far fa-calendar-alt"></i>
                                                    </span>
                                                </span>
                                            </div>
                                            <div>
                                                <p class="task-small-card-name my-2">
                                                    {{$row_item['station_name']}} - {{$row_item['mark_name']}} {{$row_item['deal_volume']}} тонн
                                                </p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="task-small-card-price">
                                                   @if($row_item['deal_status_id'] <= 3)
                                                        {{$row_item['deal_kp_sum']}} тг.
                                                    @elseif($row_item['deal_status_id'] >= 4)
                                                        <?
                                                        $discount_sum = $row_item['deal_discount'];
                                                        if($row_item['deal_discount_type'] == 1){
                                                            $discount_sum = $row_item['deal_kp_sum']*$row_item['deal_discount']/100;
                                                        }
                                                        ?>
                                                        {{$row_item['deal_kp_sum']-$discount_sum}} тг.
                                                    @endif
                                                </span>

                                                <span class="task-small-card-status">
                                                    Нет задач
                                                    <span class="task-small-card-status-icon text-warning">
                                                        <i class="fas fa-circle"></i>
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="deal-card-single-wrapper" id="deal-card-6">
                    <div class="deal-card-single card card-small mb-4 pt-1">
                        <div class="card-header text-left">
                            <h5 class="mb-0">Заявка разрезу</h5>
                            <div class="d-flex flex-wrap no-gutters mt-2">
                                <div class="col-12 col-sm-6">
                                    <span>СДЕЛОК</span>
                                    <p id="tasks-card-6-dealsQuantity">{{@count($row_list[6])}}</p>
                                </div>
                                <div class="col-12 col-sm-6 text-sm-right">
                                    <span>СУММА</span>
                                    <?
                                    $all_deals_sum6 = DB::select( DB::raw("select
                                                                                         COALESCE( sum(CASE
                                                                                         WHEN t.deal_discount_type = 1 THEN t.deal_kp_sum - t.deal_kp_sum*t.deal_discount/100
                                                                                         ELSE t.deal_kp_sum - t.deal_discount
                                                                                         END),0) as deal_kp_sum_res
                                                                                    from deals t
                                                                                    where t.deal_status_id = 6"));
                                    ?>
                                    <p id="tasks-card-6-dealsSum">{{$all_deals_sum6[0]->deal_kp_sum_res}}</p>
                                </div>
                            </div>
                            <div class="rounded col-12 mt-3 py-2" style="background-color: #C4183C"></div>
                        </div>
                        <div class="card-body">
                            @if(@count($row_list[6]) > 0)
                                @foreach($row_list[6] as $key => $row_item)
                                    <a href="/admin/deal-edit/{{$row_item['deal_id']}}">
                                        <div class="rounded border-primary border px-1 py-1 mb-2 task-small-card">
                                            <div class="d-flex align-items-center justify-content-between">

                                                <span class="task-small-card-client">
                                                    <span class="task-small-card-status-text">
                                                       {{$row_item['client_surname']}} {{$row_item['client_name']}}
                                                    </span>
                                                </span>

                                                <span class="task-small-card-date text-right">
                                                    <span class="task-small-card-date-text">
                                                      {{$row_item['deal_datetime1_format']}}
                                                    </span>
                                                    <span class="task-small-card-date-icon text-primary">
                                                       <i class="far fa-calendar-alt"></i>
                                                    </span>
                                                </span>
                                            </div>
                                            <div>
                                                <p class="task-small-card-name my-2">
                                                    {{$row_item['station_name']}} - {{$row_item['mark_name']}} {{$row_item['deal_volume']}} тонн
                                                </p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="task-small-card-price">
                                                   @if($row_item['deal_status_id'] <= 3)
                                                        {{$row_item['deal_kp_sum']}} тг.
                                                    @elseif($row_item['deal_status_id'] >= 4)
                                                        <?
                                                        $discount_sum = $row_item['deal_discount'];
                                                        if($row_item['deal_discount_type'] == 1){
                                                            $discount_sum = $row_item['deal_kp_sum']*$row_item['deal_discount']/100;
                                                        }
                                                        ?>
                                                        {{$row_item['deal_kp_sum']-$discount_sum}} тг.
                                                    @endif
                                                </span>

                                                <span class="task-small-card-status">
                                                    Нет задач
                                                    <span class="task-small-card-status-icon text-warning">
                                                        <i class="fas fa-circle"></i>
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="deal-card-single-wrapper" id="deal-card-7">
                    <div class="deal-card-single card card-small mb-4 pt-1">
                        <div class="card-header text-left">
                            <h5 class="mb-0">Оплата разрезу</h5>
                            <div class="d-flex flex-wrap no-gutters mt-2">
                                <div class="col-12 col-sm-6">
                                    <span>СДЕЛОК</span>
                                    <p id="tasks-card-7-dealsQuantity">{{@count($row_list[7])}}</p>
                                </div>
                                <div class="col-12 col-sm-6 text-sm-right">
                                    <span>СУММА</span>
                                    <?
                                    $all_deals_sum7 = DB::select( DB::raw("select
                                                                                         COALESCE( sum(CASE
                                                                                         WHEN t.deal_discount_type = 1 THEN t.deal_kp_sum - t.deal_kp_sum*t.deal_discount/100
                                                                                         ELSE t.deal_kp_sum - t.deal_discount
                                                                                         END),0) as deal_kp_sum_res
                                                                                    from deals t
                                                                                    where t.deal_status_id = 7"));
                                    ?>
                                    <p id="tasks-card-7-dealsSum">{{$all_deals_sum7[0]->deal_kp_sum_res}}</p>
                                </div>
                            </div>
                            <div class="rounded col-12 mt-3 py-2" style="background-color: #F7B422"></div>
                        </div>
                        <div class="card-body">
                            @if(@count($row_list[7]) > 0)
                                @foreach($row_list[7] as $key => $row_item)
                                    <a href="/admin/deal-edit/{{$row_item['deal_id']}}">
                                        <div class="rounded border-primary border px-1 py-1 mb-2 task-small-card">
                                            <div class="d-flex align-items-center justify-content-between">

                                                <span class="task-small-card-client">
                                                    <span class="task-small-card-status-text">
                                                       {{$row_item['client_surname']}} {{$row_item['client_name']}}
                                                    </span>
                                                </span>

                                                <span class="task-small-card-date text-right">
                                                    <span class="task-small-card-date-text">
                                                      {{$row_item['deal_datetime1_format']}}
                                                    </span>
                                                    <span class="task-small-card-date-icon text-primary">
                                                       <i class="far fa-calendar-alt"></i>
                                                    </span>
                                                </span>
                                            </div>
                                            <div>
                                                <p class="task-small-card-name my-2">
                                                    {{$row_item['station_name']}} - {{$row_item['mark_name']}} {{$row_item['deal_volume']}} тонн
                                                </p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="task-small-card-price">
                                                   @if($row_item['deal_status_id'] <= 3)
                                                        {{$row_item['deal_kp_sum']}} тг.
                                                    @elseif($row_item['deal_status_id'] >= 4)
                                                        <?
                                                        $discount_sum = $row_item['deal_discount'];
                                                        if($row_item['deal_discount_type'] == 1){
                                                            $discount_sum = $row_item['deal_kp_sum']*$row_item['deal_discount']/100;
                                                        }
                                                        ?>
                                                        {{$row_item['deal_kp_sum']-$discount_sum}} тг.
                                                    @endif
                                                </span>

                                                <span class="task-small-card-status">
                                                    Нет задач
                                                    <span class="task-small-card-status-icon text-warning">
                                                        <i class="fas fa-circle"></i>
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="deal-card-single-wrapper" id="deal-card-8">
                    <div class="deal-card-single card card-small mb-4 pt-1">
                        <div class="card-header text-left">
                            <h5 class="mb-0">Отгрузка</h5>
                            <div class="d-flex flex-wrap no-gutters mt-2">
                                <div class="col-12 col-sm-6">
                                    <span>СДЕЛОК</span>
                                    <p id="tasks-card-8-dealsQuantity">{{@count($row_list[8])}}</p>
                                </div>
                                <div class="col-12 col-sm-6 text-sm-right">
                                    <span>СУММА</span>
                                    <?
                                    $all_deals_sum8 = DB::select( DB::raw("select
                                                                                         COALESCE( sum(CASE
                                                                                         WHEN t.deal_discount_type = 1 THEN t.deal_kp_sum - t.deal_kp_sum*t.deal_discount/100
                                                                                         ELSE t.deal_kp_sum - t.deal_discount
                                                                                         END),0) as deal_kp_sum_res
                                                                                    from deals t
                                                                                    where t.deal_status_id = 8"));
                                    ?>
                                    <p id="tasks-card-8-dealsSum">{{$all_deals_sum8[0]->deal_kp_sum_res}}</p>
                                </div>
                            </div>
                            <div class="rounded col-12 mt-3 py-2" style="background-color: #A8AEB4"></div>
                        </div>
                        <div class="card-body">
                            @if(@count($row_list[8]) > 0)
                                @foreach($row_list[8] as $key => $row_item)
                                    <a href="/admin/deal-edit/{{$row_item['deal_id']}}">
                                        <div class="rounded border-primary border px-1 py-1 mb-2 task-small-card">
                                            <div class="d-flex align-items-center justify-content-between">

                                                <span class="task-small-card-client">
                                                    <span class="task-small-card-status-text">
                                                       {{$row_item['client_surname']}} {{$row_item['client_name']}}
                                                    </span>
                                                </span>

                                                <span class="task-small-card-date text-right">
                                                    <span class="task-small-card-date-text">
                                                      {{$row_item['deal_datetime1_format']}}
                                                    </span>
                                                    <span class="task-small-card-date-icon text-primary">
                                                       <i class="far fa-calendar-alt"></i>
                                                    </span>
                                                </span>
                                            </div>
                                            <div>
                                                <p class="task-small-card-name my-2">
                                                    {{$row_item['station_name']}} - {{$row_item['mark_name']}} {{$row_item['deal_volume']}} тонн
                                                </p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="task-small-card-price">
                                                   @if($row_item['deal_status_id'] <= 3)
                                                        {{$row_item['deal_kp_sum']}} тг.
                                                    @elseif($row_item['deal_status_id'] >= 4)
                                                        <?
                                                        $discount_sum = $row_item['deal_discount'];
                                                        if($row_item['deal_discount_type'] == 1){
                                                            $discount_sum = $row_item['deal_kp_sum']*$row_item['deal_discount']/100;
                                                        }
                                                        ?>
                                                        {{$row_item['deal_kp_sum']-$discount_sum}} тг.
                                                    @endif
                                                </span>

                                                <span class="task-small-card-status">
                                                    Нет задач
                                                    <span class="task-small-card-status-icon text-warning">
                                                        <i class="fas fa-circle"></i>
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="deal-card-single-wrapper" id="deal-card-9">
                    <div class="deal-card-single card card-small mb-4 pt-1">
                        <div class="card-header text-left">
                            <h5 class="mb-0">Доставка</h5>
                            <div class="d-flex flex-wrap no-gutters mt-2">
                                <div class="col-12 col-sm-6">
                                    <span>СДЕЛОК</span>
                                    <p id="tasks-card-9-dealsQuantity">{{@count($row_list[9])}}</p>
                                </div>
                                <div class="col-12 col-sm-6 text-sm-right">
                                    <span>СУММА</span>
                                    <?
                                    $all_deals_sum9 = DB::select( DB::raw("select
                                                                                         COALESCE( sum(CASE
                                                                                         WHEN t.deal_discount_type = 1 THEN t.deal_kp_sum - t.deal_kp_sum*t.deal_discount/100
                                                                                         ELSE t.deal_kp_sum - t.deal_discount
                                                                                         END),0) as deal_kp_sum_res
                                                                                    from deals t
                                                                                    where t.deal_status_id = 9"));
                                    ?>
                                    <p id="tasks-card-9-dealsSum">{{$all_deals_sum9[0]->deal_kp_sum_res}}</p>
                                </div>
                            </div>
                            <div class="rounded col-12 mt-3 py-2" style="background-color: #B3D7FF"></div>
                        </div>
                        <div class="card-body">
                            @if(@count($row_list[9]) > 0)
                                @foreach($row_list[9] as $key => $row_item)
                                    <a href="/admin/deal-edit/{{$row_item['deal_id']}}">
                                        <div class="rounded border-primary border px-1 py-1 mb-2 task-small-card">
                                            <div class="d-flex align-items-center justify-content-between">

                                                <span class="task-small-card-client">
                                                    <span class="task-small-card-status-text">
                                                       {{$row_item['client_surname']}} {{$row_item['client_name']}}
                                                    </span>
                                                </span>

                                                <span class="task-small-card-date text-right">
                                                    <span class="task-small-card-date-text">
                                                      {{$row_item['deal_datetime1_format']}}
                                                    </span>
                                                    <span class="task-small-card-date-icon text-primary">
                                                       <i class="far fa-calendar-alt"></i>
                                                    </span>
                                                </span>
                                            </div>
                                            <div>
                                                <p class="task-small-card-name my-2">
                                                    {{$row_item['station_name']}} - {{$row_item['mark_name']}} {{$row_item['deal_volume']}} тонн
                                                </p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="task-small-card-price">
                                                   @if($row_item['deal_status_id'] <= 3)
                                                        {{$row_item['deal_kp_sum']}} тг.
                                                    @elseif($row_item['deal_status_id'] >= 4)
                                                        <?
                                                        $discount_sum = $row_item['deal_discount'];
                                                        if($row_item['deal_discount_type'] == 1){
                                                            $discount_sum = $row_item['deal_kp_sum']*$row_item['deal_discount']/100;
                                                        }
                                                        ?>
                                                        {{$row_item['deal_kp_sum']-$discount_sum}} тг.
                                                    @endif
                                                </span>

                                                <span class="task-small-card-status">
                                                    Нет задач
                                                    <span class="task-small-card-status-icon text-warning">
                                                        <i class="fas fa-circle"></i>
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="deal-card-single-wrapper" id="deal-card-10">
                    <div class="deal-card-single card card-small mb-4 pt-1">
                        <div class="card-header text-left">
                            <h5 class="mb-0">Закрытие</h5>
                            <div class="d-flex flex-wrap no-gutters mt-2">
                                <div class="col-12 col-sm-6">
                                    <span>СДЕЛОК</span>
                                    <p id="tasks-card-9-dealsQuantity">{{@count($row_list[10])}}</p>
                                </div>
                                <div class="col-12 col-sm-6 text-sm-right">
                                    <span>СУММА</span>
                                    <?
                                    $all_deals_sum10 = DB::select( DB::raw("select
                                                                                         COALESCE( sum(CASE
                                                                                         WHEN t.deal_discount_type = 1 THEN t.deal_kp_sum - t.deal_kp_sum*t.deal_discount/100
                                                                                         ELSE t.deal_kp_sum - t.deal_discount
                                                                                         END),0) as deal_kp_sum_res
                                                                                    from deals t
                                                                                    where t.deal_status_id = 10"));
                                    ?>
                                    <p id="tasks-card-9-dealsSum">{{$all_deals_sum10[0]->deal_kp_sum_res}}</p>
                                </div>
                            </div>
                            <div class="rounded col-12 mt-3 py-2" style="background-color: #B3D7FF"></div>
                        </div>
                        <div class="card-body">
                            @if(@count($row_list[10]) > 0)
                                @foreach($row_list[10] as $key => $row_item)
                                    <a href="/admin/deal-edit/{{$row_item['deal_id']}}">
                                        <div class="rounded border-primary border px-1 py-1 mb-2 task-small-card">
                                            <div class="d-flex align-items-center justify-content-between">

                                                <span class="task-small-card-client">
                                                    <span class="task-small-card-status-text">
                                                       {{$row_item['client_surname']}} {{$row_item['client_name']}}
                                                    </span>
                                                </span>

                                                <span class="task-small-card-date text-right">
                                                    <span class="task-small-card-date-text">
                                                      {{$row_item['deal_datetime1_format']}}
                                                    </span>
                                                    <span class="task-small-card-date-icon text-primary">
                                                       <i class="far fa-calendar-alt"></i>
                                                    </span>
                                                </span>
                                            </div>
                                            <div>
                                                <p class="task-small-card-name my-2">
                                                    {{$row_item['station_name']}} - {{$row_item['mark_name']}} {{$row_item['deal_volume']}} тонн
                                                </p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="task-small-card-price">
                                                   @if($row_item['deal_status_id'] <= 3)
                                                        {{$row_item['deal_kp_sum']}} тг.
                                                    @elseif($row_item['deal_status_id'] >= 4)
                                                        <?
                                                        $discount_sum = $row_item['deal_discount'];
                                                        if($row_item['deal_discount_type'] == 1){
                                                            $discount_sum = $row_item['deal_kp_sum']*$row_item['deal_discount']/100;
                                                        }
                                                        ?>
                                                        {{$row_item['deal_kp_sum']-$discount_sum}} тг.
                                                    @endif
                                                </span>

                                                <span class="task-small-card-status">
                                                    Нет задач
                                                    <span class="task-small-card-status-icon text-warning">
                                                        <i class="fas fa-circle"></i>
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="deal-card-single-wrapper" id="deal-card-10">
                    <div class="deal-card-single card card-small mb-4 pt-1">
                        <div class="card-header text-left">
                            <h5 class="mb-0">Завершенные</h5>
                            <div class="d-flex flex-wrap no-gutters mt-2">
                                <div class="col-12 col-sm-6">
                                    <span>СДЕЛОК</span>
                                    <p id="tasks-card-9-dealsQuantity">{{@count($row_list[11])}}</p>
                                </div>
                                <div class="col-12 col-sm-6 text-sm-right">
                                    <span>СУММА</span>
                                    <?
                                    $all_deals_sum11 = DB::select( DB::raw("select
                                                                                         COALESCE( sum(CASE
                                                                                         WHEN t.deal_discount_type = 1 THEN t.deal_kp_sum - t.deal_kp_sum*t.deal_discount/100
                                                                                         ELSE t.deal_kp_sum - t.deal_discount
                                                                                         END),0) as deal_kp_sum_res
                                                                                    from deals t
                                                                                    where t.deal_status_id = 11"));
                                    ?>
                                    <p id="tasks-card-9-dealsSum">{{$all_deals_sum11[0]->deal_kp_sum_res}}</p>
                                </div>
                            </div>
                            <div class="rounded col-12 mt-3 py-2" style="background-color: #B3D7FF"></div>
                        </div>
                        <div class="card-body">
                            @if(@count($row_list[11]) > 0)
                                @foreach($row_list[11] as $key => $row_item)
                                    <a href="/admin/deal-edit/{{$row_item['deal_id']}}">
                                        <div class="rounded border-primary border px-1 py-1 mb-2 task-small-card">
                                            <div class="d-flex align-items-center justify-content-between">

                                                <span class="task-small-card-client">
                                                    <span class="task-small-card-status-text">
                                                       {{$row_item['client_surname']}} {{$row_item['client_name']}}
                                                    </span>
                                                </span>

                                                <span class="task-small-card-date text-right">
                                                    <span class="task-small-card-date-text">
                                                      {{$row_item['deal_datetime1_format']}}
                                                    </span>
                                                    <span class="task-small-card-date-icon text-primary">
                                                       <i class="far fa-calendar-alt"></i>
                                                    </span>
                                                </span>
                                            </div>
                                            <div>
                                                <p class="task-small-card-name my-2">
                                                    {{$row_item['station_name']}} - {{$row_item['mark_name']}} {{$row_item['deal_volume']}} тонн
                                                </p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="task-small-card-price">
                                                   @if($row_item['deal_status_id'] <= 3)
                                                        {{$row_item['deal_kp_sum']}} тг.
                                                    @elseif($row_item['deal_status_id'] >= 4)
                                                        <?
                                                        $discount_sum = $row_item['deal_discount'];
                                                        if($row_item['deal_discount_type'] == 1){
                                                            $discount_sum = $row_item['deal_kp_sum']*$row_item['deal_discount']/100;
                                                        }
                                                        ?>
                                                        {{$row_item['deal_kp_sum']-$discount_sum}} тг.
                                                    @endif
                                                </span>

                                                <span class="task-small-card-status">
                                                    Нет задач
                                                    <span class="task-small-card-status-icon text-warning">
                                                        <i class="fas fa-circle"></i>
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="deal-card-single-wrapper" id="deal-card-11">
                    <div class="deal-card-single card card-small mb-4 pt-1">
                        <div class="card-header text-left">
                            <h5 class="mb-0">Отказанные</h5>
                            <div class="d-flex flex-wrap no-gutters mt-2">
                                <div class="col-12 col-sm-6">
                                    <span>СДЕЛОК</span>
                                    <p id="tasks-card-9-dealsQuantity">{{@count($row_list[12])}}</p>
                                </div>
                                <div class="col-12 col-sm-6 text-sm-right">
                                    <span>СУММА</span>
                                    <?
                                    $all_deals_sum12 = DB::select( DB::raw("select
                                                                                         COALESCE( sum(CASE
                                                                                         WHEN t.deal_discount_type = 1 THEN t.deal_kp_sum - t.deal_kp_sum*t.deal_discount/100
                                                                                         ELSE t.deal_kp_sum - t.deal_discount
                                                                                         END),0) as deal_kp_sum_res
                                                                                    from deals t
                                                                                    where t.deal_status_id = 12"));
                                    ?>
                                    <p id="tasks-card-9-dealsSum">{{$all_deals_sum12[0]->deal_kp_sum_res}}</p>
                                </div>
                            </div>
                            <div class="rounded col-12 mt-3 py-2" style="background-color: #B3D7FF"></div>
                        </div>
                        <div class="card-body">
                            @if(@count($row_list[12]) > 0)
                                @foreach($row_list[12] as $key => $row_item)
                                    <a href="/admin/deal-edit/{{$row_item['deal_id']}}">
                                        <div class="rounded border-primary border px-1 py-1 mb-2 task-small-card">
                                            <div class="d-flex align-items-center justify-content-between">

                                                <span class="task-small-card-client">
                                                    <span class="task-small-card-status-text">
                                                       {{$row_item['client_surname']}} {{$row_item['client_name']}}
                                                    </span>
                                                </span>

                                                <span class="task-small-card-date text-right">
                                                    <span class="task-small-card-date-text">
                                                      {{$row_item['deal_datetime1_format']}}
                                                    </span>
                                                    <span class="task-small-card-date-icon text-primary">
                                                       <i class="far fa-calendar-alt"></i>
                                                    </span>
                                                </span>
                                            </div>
                                            <div>
                                                <p class="task-small-card-name my-2">
                                                    {{$row_item['station_name']}} - {{$row_item['mark_name']}} {{$row_item['deal_volume']}} тонн
                                                </p>
                                            </div>
                                            <div class="d-flex align-items-center justify-content-between">
                                                <span class="task-small-card-price">
                                                   @if($row_item['deal_status_id'] <= 3)
                                                        {{$row_item['deal_kp_sum']}} тг.
                                                    @elseif($row_item['deal_status_id'] >= 4)
                                                        <?
                                                        $discount_sum = $row_item['deal_discount'];
                                                        if($row_item['deal_discount_type'] == 1){
                                                            $discount_sum = $row_item['deal_kp_sum']*$row_item['deal_discount']/100;
                                                        }
                                                        ?>
                                                        {{$row_item['deal_kp_sum']-$discount_sum}} тг.
                                                    @endif
                                                </span>

                                                <span class="task-small-card-status">
                                                    Нет задач
                                                    <span class="task-small-card-status-icon text-warning">
                                                        <i class="fas fa-circle"></i>
                                                    </span>
                                                </span>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>




            </div>
        </div>
        <!-- /Main content -->

    </div>

    <script>
        function deleteDeal(deal_id,ob){
            if (!confirm('Вы действительно хотите удалить сделку №' + deal_id +'?')) {
                return false;
            }

            $.ajax({
                type: 'GET',
                url: "/admin/delete-deal",
                data: {_token: CSRF_TOKEN, deal_id: deal_id},
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при удалении сделки", null, null, 'danger');
                    }
                    else{
                        Notify("Сделка #" + deal_id + " удалена", null, null, 'success');
                        $(ob).closest("tr").remove();
                    }
                }
            });
        }

        function searchByDeals(){
            window.location.href = "/admin/deal-list?type=cards&deal_type_id=" + $("#deal_type_id_select").val() + "&client_id=" + $("#client_id_select").val() + "&status_id=" + $("#status_id_select").val() + "&user_id=" + $("#user_id_select").val() + "&date_from=" + $(".date_from_input").val() + "&date_to=" + $(".date_to_input").val();
        }

        $("#search_word").keyup(function(event) {
            if (event.keyCode === 13) {
                searchByDeals();
            }
        });
    </script>

@endsection

