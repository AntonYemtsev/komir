@extends('admin.layout')

@section('content')
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                {{--<h3 class="page-title">@if($row['station_id'] > 0) {{$row['station_name']}} @else Добавление нового тарифа @endif </h3>--}}
            </div>
        </div>
        <!-- End Page Header -->
        <!-- Default Light Table -->
        <div class="row">
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

                            <form id="client-contact-form" method="post" enctype="multipart/form-data" action="/admin/station-edit/{{$row->station_id}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="station_id" value="{{$row->station_id}}">
                                <div class="form-group">
                                    <label>Станция назначения</label>
                                    <input type="text" name="station_name" placeholder="" class="form-control" value="{{$row['station_name']}}">
                                </div>
                                <div class="form-group">
                                    <label>Код станции</label>
                                    <input type="text" name="station_code" placeholder="" class="form-control" value="{{$row['station_code']}}">
                                </div>
                                <div class="form-group">
                                    <label>Расстояние, км</label>
                                    <input type="text" name="station_km" placeholder="" class="form-control" value="{{$row['station_km']}}">
                                </div>

                                <div class="form-group">
                                    <label>Разрез</label>
                                    <select class="form-control" name="station_brand_id" onchange="showRegionList(this)">
                                        <option value="0">Выберите разрез</option>
                                        <? use App\Models\Brand;
                                        $brand_list = Brand::orderBy("brand_name")->get();
                                        ?>
                                        @if(@count($brand_list) > 0)
                                            @foreach($brand_list as $key => $brand_item)
                                                <option value="{{$brand_item['brand_id']}}" @if($row['station_brand_id'] == $brand_item['brand_id']) selected @endif>{{$brand_item['brand_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label>Область</label>
                                    <select class="form-control" name="station_region_id" id="station_region_id">
                                        <option value="0">Выберите область</option>
                                        <? use App\Models\Region;
                                        $region_list = Region::where("region_brand_id","=",$row['station_brand_id'])->orderBy("region_name")->get();
                                        ?>
                                        @if(@count($region_list) > 0)
                                            @foreach($region_list as $key => $region_item)
                                                <option class="region-option" value="{{$region_item['region_id']}}" @if($row['station_region_id'] == $region_item['region_id']) selected @endif>{{$region_item['region_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Тариф на 1 тонну, без НДС</label>
                                    <input type="text" name="station_rate" placeholder="" class="form-control" value="{{$row['station_rate']}}">
                                </div>
                                <div class="form-group">
                                    <label>Тариф на 1 тонну, с НДС</label>
                                    <input type="text" name="station_rate_nds" placeholder="" class="form-control" value="{{$row['station_rate_nds']}}">
                                </div>

                                <button type="submit" name="submit" id="client-contact-form-submit" class="mb-2 btn btn-primary mr-2">@if($row->station_id > 0) Сохранить @else Добавить @endif</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- End Default Light Table -->
    </div>

    <script>
        function showRegionList(ob){
            $.ajax({
                type: 'GET',
                url: "/admin/get-region-by-brand",
                data: {_token: CSRF_TOKEN, brand_id: $(ob).val()},
                success: function(data){
                    $(".region-option").remove();
                    $("#station_region_id").val(0);
                    $("#station_region_id").append(data);
                }
            });
        }
    </script>
@endsection
