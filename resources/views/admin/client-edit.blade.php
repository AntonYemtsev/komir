@extends('admin.layout')

@section('content')
    <div class="alert alert-success alert-dismissible fade show mb-0 client-alert" role="alert" style="display: none">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">×</span>
        </button>
        <i class="fa fa-check mx-2"></i>
        Данные клиента успешно обновлены
    </div>

    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                {{--<h3 class="page-title">@if($row['client_id'] > 0) {{$row['client_name']}} @else Добавление нового клиента @endif </h3>--}}
            </div>
        </div>
        <!-- End Page Header -->

        <style>
            label.error{
                color: red;
                height: auto;
                display: block;
                text-align: center;
            }

            input.error{
                height: auto;
            }
        </style>

        <!-- Default Light Table -->
        <div class="row">
            <form id="client_form" method="post" enctype="multipart/form-data" style="display: contents">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="client_id" value="{{$row->client_id}}" id="client_id">
                <div class="col-lg-8 d-flex">
                    <div class="col-lg-6 pl-0">
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

                                <div id="client-contact-form" method="post" enctype="multipart/form-data">
                                    <div class="form-group">
                                        <label for="client-contact-form-name">Фамилия</label>
                                        <input type="text" name="client_surname" id="client-contact-form-name" placeholder="" class="form-control" value="{{$row['client_surname']}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="client-contact-form-name">Имя</label>
                                        <input type="text" name="client_name" id="client-contact-form-name" placeholder="" class="form-control" value="{{$row['client_name']}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="client-contact-form-phone">Телефон</label>
                                        <input type="tel" name="client_phone" id="client-contact-form-phone" placeholder="" class="form-control" value="{{$row['client_phone']}}">
                                    </div>
                                    <div class="form-group">
                                        <label for="client-contact-form-email">Email</label>
                                        <input type="email" name="client_email" id="client-contact-form-email" placeholder="" class="form-control" value="{{$row['client_email']}}">
                                    </div>
                                    <button type="button" name="button" id="client-contact-form-submit" onclick="updateClientInfo()" class="mb-2 btn btn-primary mr-2">Обновить</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-6 pr-0">
                        <div class="card card-small mb-4 pt-1">
                            <div class="card-header border-bottom text-left">
                                <h5 class="mb-0">Грузоперевозчик</h5>
                            </div>
                            <div class="card-body">
                                <div id="client-transporter-form">
                                    <?
                                    use App\Models\Region;
                                    $region_list = Region::orderBy("region_name","asc")->get();
                                    ?>
                                    <div class="form-group">
                                        <label for="client-transporter-form-region">Область</label>
                                        <select class="form-control" name="client_region_id">
                                            <option value="0">Выберите область</option>
                                            @if(@count($region_list) > 0)
                                                @foreach($region_list as $key => $region_item)
                                                    <option value="{{$region_item['region_id']}}" @if($region_item['region_id'] == $row->client_region_id) selected @endif >{{$region_item['region_name']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>

                                    <?
                                    use App\Models\Station;
                                    $station_list = Station::orderBy("station_name",'asc')->get();
                                    ?>
                                    <div class="form-group">
                                        <label for="client-transporter-form-station">Станция</label>
                                        <select class="form-control" name="client_station_id">
                                            <option value="0">Выберите станцию</option>
                                            @if(@count($station_list) > 0)
                                                @foreach($station_list as $key => $station_item)
                                                    <option value="{{$station_item['station_id']}}" @if($station_item['station_id'] == $row->client_station_id) selected @endif >{{$station_item['station_name']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="client-transporter-form-receiverCode">Код получателя</label>
                                        <input type="text" name="client_receiver_code" id="client-transporter-form-receiverCode" placeholder="" class="form-control" value="{{$row['client_receiver_code']}}">
                                    </div>
                                    <?
                                    use App\Models\Company;
                                    $company_list = Company::orderBy("company_name",'asc')->get();
                                    ?>
                                    <div class="form-group">
                                        <label for="client-transporter-form-station">Компания</label>
                                        <select class="form-control" name="client_company_id">
                                            <option value="0">Выберите компанию</option>
                                            @if(@count($company_list) > 0)
                                                @foreach($company_list as $key => $company_item)
                                                    <option value="{{$company_item['company_id']}}" @if($company_item['company_id'] == $row->client_company_id) selected @endif >{{$company_item['company_name']}}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    {{--<button type="submit" name="button" id="client-transporter-form-submit" onclick="updateClientInfo()" class="mb-2 btn btn-primary mr-2">Обновить</button>--}}
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </form>

        </div>
        <!-- End Default Light Table -->
    </div>

    <script>
        $(document).ready(function(){
            $("#client_form").validate({
                rules : {
                    'client_company_id':{min:1},
                    'client_region_id':{min:1},
                    'client_station_id':{min:1}
                },
                messages:{
                    'client_company_id': {min: "Выберите Компанию"},
                    'client_region_id': {min: "Выберите Регион"},
                    'client_station_id': {min: "Выберите Область"}
                }
            });
        });

        function updateClientInfo(){
            if (!$("#client_form").valid()){
                return false;
            }

            $.ajax({
                type: 'POST',
                url: "/admin/client-edit",
                data: $("#client_form").serialize(),
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при сохранении клиента", null, null, 'danger');
                    }
                    else{
//                        $(".client-alert").fadeIn(200);
                        window.location.href = "/admin/client-list";
                    }
                }
            });
        }
    </script>
@endsection
