@extends('admin.layout')

@section('content')
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                {{--<h3 class="page-title">@if($row['brand_id'] > 0) {{$row['brand_name']}} @else Добавление нового разреза @endif </h3>--}}
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

                            <form id="client-contact-form" method="post" enctype="multipart/form-data" action="/admin/brand-edit/{{$row->brand_id}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="brand_id" value="{{$row->brand_id}}">
                                <div class="form-group">
                                    <label>Наименование</label>
                                    <input type="text" name="brand_name" placeholder="" class="form-control" value="{{$row['brand_name']}}">
                                </div>
                                <div class="form-group">
                                    <label>Наименование компании</label>
                                    <input type="text" name="brand_company_name" placeholder="" class="form-control" value="{{$row['brand_company_name']}}">
                                </div>

                                <div class="form-group">
                                    <label>ФИО руководителя</label>
                                    <input type="text" name="brand_company_ceo_name" placeholder="" class="form-control" value="{{$row['brand_company_ceo_name']}}">
                                </div>

                                <div class="form-group">
                                    <label>Номер договора поставки</label>
                                    <input type="text" name="brand_dogovor_num" placeholder="" class="form-control" value="{{$row['brand_dogovor_num']}}">
                                </div>

                                <div class="form-group">
                                    <label>Дата договора поставки</label>
                                    <input type="text" name="brand_dogovor_date" placeholder="" class="form-control blog-overview-date-range-all" value="{{$row['brand_dogovor_date']}}">
                                </div>

                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="brand_email" placeholder="" class="form-control" value="{{$row['brand_email']}}">
                                </div>

                                <div class="form-group">
                                    <label> Реквизиты разреза</label>
                                    <textarea class="form-control" name="brand_props">{{$row['brand_props']}}</textarea>
                                </div>

                                <button type="submit" name="submit" id="client-contact-form-submit" class="mb-2 btn btn-primary mr-2">@if($row->brand_id > 0) Сохранить @else Добавить @endif</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- End Default Light Table -->
    </div>
@endsection
