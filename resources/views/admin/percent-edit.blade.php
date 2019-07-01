@extends('admin.layout')

@section('content')
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                {{--<h3 class="page-title">@if($row['percent_id'] > 0) {{$row['percent_name']}} @else Добавление нового процента владельца @endif </h3>--}}
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

                            <form id="client-contact-form" method="post" enctype="multipart/form-data" action="/admin/percent-edit/{{$row->percent_id}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="percent_id" value="{{$row->percent_id}}">
                                <div class="form-group">
                                    <label>Процент маржи</label>
                                    <input type="text" name="percent_rate" placeholder="" class="form-control" value="{{$row['percent_rate']}}">
                                </div>
                                <div class="form-group">
                                    <label>Сумма маржи</label>
                                    <input type="text" name="percent_sum_rate" placeholder="" class="form-control" value="{{$row['percent_sum_rate']}}">
                                </div>
                                <div class="form-group">
                                    <label>Разрез</label>
                                    <select class="form-control" name="percent_brand_id">
                                        <option value="0">Выберите разрез</option>
                                        <? use App\Models\Brand;
                                        $brand_list = Brand::orderBy("brand_name")->get();
                                        ?>
                                        @if(@count($brand_list) > 0)
                                            @foreach($brand_list as $key => $brand_item)
                                                <option value="{{$brand_item['brand_id']}}" @if($row['percent_brand_id'] == $brand_item['brand_id']) selected @endif>{{$brand_item['brand_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <button type="submit" name="submit" id="client-contact-form-submit" class="mb-2 btn btn-primary mr-2">@if($row->percent_id > 0) Сохранить @else Добавить @endif</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- End Default Light Table -->
    </div>
@endsection
