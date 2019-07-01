@extends('admin.layout')

@section('content')
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                {{--<h3 class="page-title">@if($row['fraction_id'] > 0) {{$row['fraction_name']}} @else Добавление новой фракции @endif </h3>--}}
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

                            <form id="client-contact-form" method="post" enctype="multipart/form-data" action="/admin/fraction-edit/{{$row->fraction_id}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="fraction_id" value="{{$row->fraction_id}}">
                                <div class="form-group">
                                    <label>Наименование</label>
                                    <input type="text" name="fraction_name" placeholder="" class="form-control" value="{{$row['fraction_name']}}">
                                </div>

                                <div class="form-group">
                                    <label>Разрез</label>
                                    <select class="form-control" name="fraction_brand_id">
                                        <option value="0">Выберите разрез</option>
                                        <? use App\Models\Brand;
                                        $brand_list = Brand::orderBy("brand_name")->get();
                                        ?>
                                        @if(@count($brand_list) > 0)
                                            @foreach($brand_list as $key => $brand_item)
                                                <option value="{{$brand_item['brand_id']}}" @if($row['fraction_brand_id'] == $brand_item['brand_id']) selected @endif>{{$brand_item['brand_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <button type="submit" name="submit" id="client-contact-form-submit" class="mb-2 btn btn-primary mr-2">@if($row->fraction_id > 0) Сохранить @else Добавить @endif</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- End Default Light Table -->
    </div>
@endsection
