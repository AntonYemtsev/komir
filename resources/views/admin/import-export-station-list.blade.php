@extends('admin.layout')

@section('content')
    <style>
        .error{height: auto}
        input.error{border: 1px solid red;}
    </style>
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                {{--<h3 class="page-title">Тарифы</h3>--}}
            </div>
        </div>
        <!-- End Page Header -->
        <!-- Default Light Table -->
        <div class="row">
            <div class="col">
                <div class="card card-small mb-4">
                    <div class="card-header d-flex border-bottom no-gutters">
                        <div class="col-12 col-sm-12">
                            <button onclick="exportStationList()" type="button" name="submit" id="client-transporter-form-submit" class="mb-2 btn btn-primary mr-2">Скачать все тарифы</button>
                            <hr>
                            <h4>Обновление тарифов</h4>
                            <form id="import_form" method="post" enctype="multipart/form-data">
                                <input type="hidden" id="is_new_import" value="0" name="is_new_import">
                                <input type="file" name="import_file" id="import_file">
                                <button type="button" name="submit" id="client-transporter-form-submit" class="mb-2 btn btn-primary mr-2 import-btn" data-new="0">Импортировать</button>
                                <hr>
                                <h4>Добавление новых тарифов тарифов</h4>
                                <div class="col-12 col-sm-6">
                                    <span>Область</span>
                                    <select class="form-control ml-2 d-inline-block select2-search" name="station_region_id">
                                        @if(@count($region_list) > 0)
                                            @foreach($region_list as $key => $region_item)
                                                <option value="{{$region_item['region_id']}}">{{$region_item['region_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <span>Разрез</span>
                                    <select class="form-control ml-2 d-inline-block select2-search" name="station_brand_id">
                                        @if(@count($brand_list) > 0)
                                            @foreach($brand_list as $key => $brand_item)
                                                <option value="{{$brand_item['brand_id']}}">{{$brand_item['brand_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <br>

                                <input type="file" name="import_file_new">
                                <button type="button" name="submit" id="client-transporter-form-submit" class="mb-2 btn btn-primary mr-2 import-btn" data-new="1">Загрузить</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Default Light Table -->
    </div>

    <script>
        function exportStationList(){
            $.ajax({
                type: 'GET',
                url: "/admin/export-station-list",
                data: {_token: CSRF_TOKEN},
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при выгрузке всех тарифов", null, null, 'danger');
                    }
                    else{
                        window.open(data.filename);
                    }
                }
            });
        }

        $(document).ready(function(){
            $("#import_form").validate({
                rules : {
                    import_file_new : {required : true},
                    station_region_id: {min:1},
                    station_brand_id: {min:1}
                },
                messages:{
                    import_file_new: {required : ""},
                    station_region_id: {min: ""},
                    station_brand_id: {min: ""}
                }
            });


            $(".import-btn").on("click",function(event){
                $("#is_new_import").val($(this).data("new"));
                if($(this).data("new") == 1){
                    if (!$("#import_form").valid()){
                        return false;
                    }
                }
                else{
                    if($("#import_file").val().length < 1){
                        Notify("Выберите файл для обновления тарифов", null, null, 'danger');
                        return false;
                    }
                }


                event.preventDefault();

                //grab all form data
                var formData = new FormData($("#import_form")[0]);

                $.ajax({
                    url:'/admin/import-station-list',
                    type: 'POST',
                    headers: {
                        'X-CSRF-TOKEN':  CSRF_TOKEN
                    },
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        if(data.result == true){
                            Notify("Данные успешно импортированы", null, null, 'success');
                        }
                        else{
                            Notify(data.result, null, null, 'danger');
                        }
                    }
                });
            });
        });
    </script>

@endsection

