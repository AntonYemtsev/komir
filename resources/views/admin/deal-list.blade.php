@extends('admin.layout')

@section('content')
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row align-items-center no-gutters py-4">
            <div class="col-12 col-sm-2 d-flex text-center text-sm-left mb-0">
                {{--<h3 class="page-title">Сделки</h3>--}}
                <a class="change-view-type" href="/admin/deal-list?type=list">
                    <svg width="18" height="18" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect width="31" height="6" fill="#007BFF"/>
                        <rect width="31" height="6" fill="#007BFF"/>
                        <rect width="31" height="6" fill="#007BFF"/>
                        <rect y="12" width="31" height="7" fill="#007BFF"/>
                        <rect y="12" width="31" height="7" fill="#007BFF"/>
                        <rect y="12" width="31" height="7" fill="#007BFF"/>
                        <rect y="25" width="31" height="6" fill="#007BFF"/>
                        <rect y="25" width="31" height="6" fill="#007BFF"/>
                        <rect y="25" width="31" height="6" fill="#007BFF"/>
                    </svg>
                </a>
                <a class="change-view-type" href="/admin/deal-list?type=cards">
                    <svg width="18" height="18" viewBox="0 0 31 31" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect x="30.9951" width="10" height="5.9991" transform="rotate(89.9917 30.9951 0)" fill="#007BFF"/>
                        <rect x="30.9951" width="10" height="5.9991" transform="rotate(89.9917 30.9951 0)" fill="#007BFF"/>
                        <rect x="30.9951" width="10" height="5.9991" transform="rotate(89.9917 30.9951 0)" fill="#979797"/>
                        <rect x="18.9971" y="0.00170898" width="20" height="6.99895" transform="rotate(89.9917 18.9971 0.00170898)" fill="#007BFF"/>
                        <rect x="18.9971" y="0.00170898" width="20" height="6.99895" transform="rotate(89.9917 18.9971 0.00170898)" fill="#007BFF"/>
                        <rect x="18.9971" y="0.00170898" width="20" height="6.99895" transform="rotate(89.9917 18.9971 0.00170898)" fill="#979797"/>
                        <rect x="5.99902" y="0.00366211" width="30.9956" height="5.9991" transform="rotate(89.9917 5.99902 0.00366211)" fill="#007BFF"/>
                        <rect x="5.99902" y="0.00366211" width="30.9956" height="5.9991" transform="rotate(89.9917 5.99902 0.00366211)" fill="#007BFF"/>
                        <rect x="5.99902" y="0.00366211" width="30.9956" height="5.9991" transform="rotate(89.9917 5.99902 0.00366211)" fill="#979797"/>
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
                    <a href="/admin/deal-list?type=list">
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
                    <input type="text" class="input-sm form-control date_from_input datepicker-here" name="date_form" placeholder="01.01.2019" id="blog-overview-date-range-1" style="height: calc(2.09375rem + 2px)" value="{{$date_from}}">
                    <input type="text" class="input-sm form-control date_to_input datepicker-here" data-position="bottom right" name="date_to" placeholder="02.01.2019" id="blog-overview-date-range-2" style="height: calc(2.09375rem + 2px)" value="{{$date_to}}">
                    <span class="input-group-append">
                    <span class="input-group-text" style="height: calc(2.09375rem + 2px)">
                      <i class="material-icons"></i>
                    </span>
                  </span>
                </div>
            </div>
        </div>
        <!-- End Page Header -->
        <!-- Default Light Table -->
        <div class="row">
            <div class="col">
                <div class="card card-small mb-4">
                    <div class="card-header d-flex border-bottom no-gutters">
                        <div class="col-12 col-sm-6">
                            <span>Количество записей</span>
                            <select id="select-client-lines-qty" class="form-control ml-2 d-inline-block" style="width: 75px;" onchange="searchByDeals()">
                                <option value="20" @if($row_count == 20) selected @endif>20</option>
                                <option value="50" @if($row_count == 50) selected @endif>50</option>
                            </select>
                        </div>
                        <div class="col-12 col-sm-3"></div>
                        <div class="col-12 col-sm-3">
                            <div class="ml-auto input-group input-group-seamless input-group-sm" >
                                <div class="input-group-prepend">
                          <span class="input-group-text">
                            <i class="material-icons">search</i>
                          </span>
                                </div>
                                <input class="form-control"  style="height: calc(2.09375rem + 2px)" id="search_word" value="{{$search_word}}"></div>
                        </div>
                    </div>
                    <div class="card-body p-0 pb-3 text-center">
                        <table class="table mb-0 clients-table">
                            <thead class="bg-light">
                            <tr>
                                <th scope="col" class="border-0">#</th>
                                <th scope="col" class="border-0">Наименование сделки</th>
                                <th scope="col" class="border-0">Клиент</th>
                                <th scope="col" class="border-0">Дата</th>
                                <th scope="col" class="border-0">Статус</th>
                                <th scope="col" class="border-0">Сумма</th>
                                <th scope="col" class="border-0">Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                                @if(@count($row) > 0)
                                    @foreach($row as $key => $deal_item)
                                        <tr>
                                            <td>{{$loop->index}}</td>
                                            <td>{{$deal_item['station_name']}} - {{$deal_item['mark_name']}}  {{$deal_item['deal_volume']}} тонн</td>
                                            <td>{{$deal_item['client_surname']}} {{$deal_item['client_name']}}</td>
                                            <td>{{$deal_item['deal_datetime1_format']}}</td>
                                            <td>
                                                <div class="pb-1 text-white" style="background-color: {{$deal_item['status_color']}}">
                                                    {{$deal_item['status_name']}}
                                                </div>
                                            </td>
                                            <td>
                                                @if($deal_item['deal_status_id'] <= 3)
                                                    {{$deal_item['deal_kp_sum']}} тг.
                                                @elseif($deal_item['deal_status_id'] >= 4)
                                                    <?
                                                    $discount_sum = $deal_item['deal_discount'];
                                                    if($deal_item['deal_discount_type'] == 1){
                                                        $discount_sum = $deal_item['deal_kp_sum']*$deal_item['deal_discount']/100;
                                                    }
                                                    ?>
                                                    <?=preg_replace('/(\d)(?=((\d{3})+)(\D|$))/', '$1 ', $deal_item['deal_kp_sum']-$discount_sum);?> тг.
                                                @endif
                                            </td>
                                            <td>
                                                <div class="clients-table__actions">
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="/admin/deal-edit/{{$deal_item->deal_id}}">
                                                            <button type="button" class="btn btn-white">
                                                              <span class="text-light">
                                                                <i class="material-icons">more_vert</i>
                                                              </span> Подробнее
                                                            </button>
                                                        </a>
                                                        <button type="button" class="btn btn-white" onclick="showDealRejectForm({{$deal_item['deal_id']}})">
                                                          <span class="text-danger">
                                                            <i class="material-icons">clear</i>
                                                          </span> Отказ клиента
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                            </tbody>
                        </table>

                        <div class="dataTables_paginate paging_bootstrap pagination" style="float: right; margin-right: 20px;">
                            {!! $row->appends(\Illuminate\Support\Facades\Input::except('page'))->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Default Light Table -->
    </div>

    <script>
        $(document).ready(function(){
            $(".date_from_input").on("change",function(){
                searchByDeals();
            })
            $(".date_to_input").on("change",function(){
                searchByDeals();
            })
        })
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
            window.location.href = "/admin/deal-list?type=list&deal_type_id=" + $("#deal_type_id_select").val() + "&client_id=" + $("#client_id_select").val() + "&status_id=" + $("#status_id_select").val() + "&user_id=" + $("#user_id_select").val() + "&date_from=" + $(".date_from_input").val() + "&date_to=" + $(".date_to_input").val() + "&row_count=" + $("#select-client-lines-qty").val() + "&search_word=" + $("#search_word").val();
        }

        $("#search_word").keyup(function(event) {
            if (event.keyCode === 13) {
                searchByDeals();
            }
        });

        function setDealUser(deal_user_num,ob){
            $("#deal_user_id" +deal_user_num).val($(ob).val());
        }
    </script>

@endsection

