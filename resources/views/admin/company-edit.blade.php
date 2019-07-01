@extends('admin.layout')

@section('content')
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                {{--<h3 class="page-title">@if($row['company_id'] > 0) {{$row['company_name']}} @else Добавление новой компании @endif </h3>--}}
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
            <form id="company_form" method="post" enctype="multipart/form-data" style="display: contents">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="company_id" value="{{$row->company_id}}" id="company_id">
                
                <div class="col-lg-8">
                    <div class="card card-small mb-4">
                        <div class="card-header border-bottom">
                            <h5 class="m-0">Компания</h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item p-3">
                                <div class="row">
                                    <div class="col">
                                        <div id="company-company-form">
                                            <div class="form-row">
                                                <input type="hidden" name="company_id" value="{{$row['company_id']}}">
                                                <div class="form-group col-md-6">
                                                    <label for="company-company-form-name">Наименование компании</label>
                                                    <input type="text" class="form-control" id="company-company-form-name" placeholder="" name="company_name" value="{{$row['company_name']}}">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="company-company-form-bankName">Банк</label>
                                                    <select id="company-company-form-bankName" class="form-control" name="company_bank_id">
                                                        <?
                                                        use App\Models\Bank;
                                                        $bank_list = Bank::orderBy("bank_name","asc")->get();
                                                        ?>
                                                        <option value="0">Выберите банк</option>
                                                        @if(@count($bank_list) > 0)
                                                            @foreach($bank_list as $key => $bank_item)
                                                                <option value="{{$bank_item['bank_id']}}" @if($bank_item['bank_id'] == $row['company_bank_id']) selected @endif>{{$bank_item['bank_name']}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="company-company-form-ceoPosition">Должность руководителя</label>
                                                    <input type="text" class="form-control" id="company-company-form-ceoPosition" placeholder="" value="{{$row['company_ceo_position']}}" name="company_ceo_position"> </div>
                                                <div class="form-group col-md-6">
                                                    <label for="company-company-form-bankIIK">ИИК</label>
                                                    <input type="text" class="form-control" id="company-company-form-bankIIK" placeholder="" value="{{$row['company_bank_iik']}}" name="company_bank_iik"> </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="company-company-form-ceoName">ФИО руководителя</label>
                                                    <input type="text" class="form-control" id="company-company-form-ceoName" placeholder="" value="{{$row['company_ceo_name']}}" name="company_ceo_name"> </div>
                                                {{--<div class="form-group col-md-6">--}}
                                                    {{--<label for="company-company-form-bankBIK">БИК</label>--}}
                                                    {{--<input type="text" class="form-control" id="company-company-form-bankBIK" placeholder="" value="{{$row['company_bank_iik']}}" name="company_bank_iik"> </div>--}}
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="company-company-form-address">Юридический адрес</label>
                                                    <input type="text" class="form-control" id="company-company-form-assress" placeholder="" value="{{$row['company_address']}}" name="company_address"> </div>
                                                <div class="form-group col-md-6">
                                                    <label for="company-company-form-bankBIN">БИН</label>
                                                    <input type="text" class="form-control" id="company-company-form-bankBIN" placeholder="" value="{{$row['company_bank_bin']}}" name="company_bank_bin"> </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="company-company-form-address">Адрес доставки</label>
                                                    <input type="text" class="form-control" id="company-company-form-delassress" placeholder="" value="{{$row['company_delivery_address']}}" name="company_delivery_address"> </div>
                                                <div class="form-group col-md-6">
                                                    <label for="company-company-form-bankBIN">ОКПО</label>
                                                    <input type="text" class="form-control" id="company-company-form-okpo" placeholder="" value="{{$row['company_okpo']}}" name="company_okpo"> </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <button type="button" id="company-company-form-submit" onclick="updateCompanyInfo()" class="btn btn-primary">Сохранить</button>
                                                </div>
                                                <div class="form-group d-flex align-items-center col-md-6">
                                                    <div class="custom-control custom-toggle custom-toggle-sm mb-1">
                                                        <input type="checkbox" id="company-company-form-isDiscount" name="company_is_discount" class="custom-control-input" @if($row['company_is_discount'] == 1) checked="checked" @endif>
                                                        <label class="custom-control-label" for="company-company-form-isDiscount">Давать скидку (нет/да)</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </form>

        </div>
        <!-- End Default Light Table -->
    </div>

    <script>
        $(document).ready(function(){
            $("#company_form").validate({
                rules : {
                    'company_bank_id':{min:1}
                },
                messages:{
                    'company_bank_id': {min: "Выберите Банк"}
                }
            });
        });

        function updateCompanyInfo(){
            if (!$("#company_form").valid()){
                return false;
            }

            $.ajax({
                type: 'POST',
                url: "/admin/company-edit",
                data: $("#company_form").serialize(),
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при сохранении компании", null, null, 'danger');
                    }
                    else{
                        window.location.href = "/admin/company-list";
                    }
                }
            });
        }
    </script>
@endsection
