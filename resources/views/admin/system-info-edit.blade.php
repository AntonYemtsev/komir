@extends('admin.layout')

@section('content')
    <style>
        label.error, input.error, textarea.error, select.error{height: auto;}
        input.error, textarea.error, select.error{height: auto; border: 1px solid red;}
    </style>
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
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
            @if(isset($result['status']))
                <p style="color: red; font-size: 14px; text-align: center;">
                    @if(@count($result['value']) > 0)
                        @foreach($result['value'] as $key => $error_item)
                            {{ $error_item }} <br>
                        @endforeach
                    @endif
                </p>
            @endif

            <form id="system_info_form" method="post" enctype="multipart/form-data" style="display: contents" action="/admin/system-info-edit/{{$row->system_info_id}}">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="system_info_id" value="{{$row->system_info_id}}" id="system_info_id">
                
                <div class="col-lg-8">
                    <div class="card card-small mb-4">
                        <div class="card-header border-bottom">
                            <h5 class="m-0">Владелец системы</h5>
                        </div>
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item p-3">
                                <div class="row">
                                    <div class="col">
                                        <div id="system-info-system-info-form">
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="system-info-form-name">ФИО</label>
                                                    <input type="text" class="form-control" id="system-info-form-name" placeholder="" name="system_info_fio" value="{{$row['system_info_fio']}}">
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <label for="system-info-system-info-form-bankName">Банк</label>
                                                    <select id="system-info-system-info-form-bankName" class="form-control" name="system_info_bank_id">
                                                        <?
                                                        use App\Models\Bank;
                                                        $bank_list = Bank::orderBy("bank_name","asc")->get();
                                                        ?>
                                                        <option value="0">Выберите банк</option>
                                                        @if(@count($bank_list) > 0)
                                                            @foreach($bank_list as $key => $bank_item)
                                                                <option value="{{$bank_item['bank_id']}}" @if($bank_item['bank_id'] == $row['system_info_bank_id']) selected @endif>{{$bank_item['bank_name']}}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="system-info-name-form">Название компании</label>
                                                    <input type="text" class="form-control" id="system-info-name-form" placeholder="" value="{{$row['system_info_company_name']}}" name="system_info_company_name"> </div>
                                                <div class="form-group col-md-6">
                                                    <label for="system-info-system-info-form-bankIIK">ИИК</label>
                                                    <input type="text" class="form-control" id="system-info-system-info-form-bankIIK" placeholder="" value="{{$row['system_info_bank_iik']}}" name="system_info_bank_iik" maxlength="20"> </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="system-info-system-info-form-address">Юридический адрес</label>
                                                    <input type="text" class="form-control" id="system-info-system-info-form-assress" placeholder="" value="{{$row['system_info_address']}}" name="system_info_address"> </div>
                                                <div class="form-group col-md-6">
                                                    <label for="system-info-system-info-form-bankBIN">БИН</label>
                                                    <input type="text" class="form-control" id="system-info-system-info-form-bankBIN" placeholder="" value="{{$row['system_info_bank_bin']}}" name="system_info_bank_bin" maxlength="12"> </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="system-info-system-info-form-address">КБЕ</label>
                                                    <input type="text" class="form-control" id="system-info-system-info-form-delassress" placeholder="" value="{{$row['system_info_bank_kbe']}}" name="system_info_bank_kbe"> </div>
                                                <div class="form-group col-md-6">
                                                    <label for="system-info-system-info-form-bankBIN">Код назначения</label>
                                                    <input type="text" class="form-control" id="system-info-system-info-form-okpo" placeholder="" value="{{$row['system_info_bank_code']}}" name="system_info_bank_code"> </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <label for="system-info-system-info-form-address">Подпись</label>
                                                    <div class="form-group col-md-12">
                                                        @if(strlen($row['system_info_img']) > 0)
                                                            <img src="/system_info_img/{{$row['system_info_img']}}" style="max-width: 150px;">
                                                        @endif
                                                    </div>
                                                    <input type="file" name="system_info_img">
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <button onclick="sendSystemInfoForm()" id="system-info-system-info-form-submit" class="btn btn-primary">Сохранить</button>
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
            $("#system_info_form").validate({
                rules : {
                    system_info_bank_bin: {required:true, minlength: 12, maxlength: 12,digits: true},
                    system_info_bank_iik: {required:true, minlength: 20, maxlength: 20}
                },
                messages:{
                    system_info_bank_bin: {required: "", minlength: "", maxlength: "", digits: ""},
                    system_info_bank_iik: {required: "", minlength: "", maxlength: ""}
                }
            });
        });

        function sendSystemInfoForm(){
            if (!$("#system_info_form").valid()){
                return false;
            }
            document.getElementById("system_info_form").submit();
        }
    </script>
@endsection
