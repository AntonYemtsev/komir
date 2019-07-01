@extends('admin.layout')

@section('content')
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                {{--<h3 class="page-title">@if($row['payment_id'] > 0) {{$row['payment_name']}} @else Добавление новой условии оплаты @endif </h3>--}}
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

                            <form id="client-contact-form" method="post" enctype="multipart/form-data" action="/admin/payment-edit/{{$row->payment_id}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="payment_id" value="{{$row->payment_id}}">
                                <div class="form-group">
                                    <label>Наименование</label>
                                    <input type="text" name="payment_name" placeholder="" class="form-control" value="{{$row['payment_name']}}">
                                </div><div class="form-group">
                                    <div class="custom-control custom-toggle custom-toggle-sm mb-1">
                                        <input type="checkbox" id="is_postpay" name="is_postpay" class="custom-control-input" @if($row['is_postpay'] == 1) checked="checked" @endif>
                                        <label class="custom-control-label" for="is_postpay">100% постоплата </label>
                                    </div>
                                </div>

                                <button type="submit" name="submit" id="client-contact-form-submit" class="mb-2 btn btn-primary mr-2">@if($row->payment_id > 0) Сохранить @else Добавить @endif</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- End Default Light Table -->
    </div>
@endsection
