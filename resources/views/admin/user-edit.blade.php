@extends('admin.layout')

@section('content')
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
{{--                <h3 class="page-title">@if($row['user_id'] > 0) {{$row['user_surname']}} {{$row['user_name']}} @else Добавление нового пользователя @endif </h3>--}}
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

                            <form id="client-contact-form" method="post" enctype="multipart/form-data" action="/admin/user-edit/{{$row->user_id}}">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <input type="hidden" name="user_id" value="{{$row->user_id}}">
                                <div class="form-group">
                                    <label>Фамилия</label>
                                    <input type="text" name="user_surname" placeholder="" class="form-control" value="{{$row['user_surname']}}">
                                </div>
                                <div class="form-group">
                                    <label>Имя</label>
                                    <input type="text" name="user_name" placeholder="" class="form-control" value="{{$row['user_name']}}">
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text" name="email" placeholder="" class="form-control" value="{{$row['email']}}">
                                </div>
                                <div class="form-group">
                                    <label>Телефон</label>
                                    <input type="text" name="user_phone" placeholder="" class="form-control" value="{{$row['user_phone']}}">
                                </div>
                                <div class="form-group">
                                    <label>Роль</label>
                                    <select class="form-control" name="user_role_id">
                                        <? use App\Models\Role;
                                        $role_list = Role::orderBy("role_name")->get();
                                        ?>
                                        @if(@count($role_list) > 0)
                                            @foreach($role_list as $key => $role_item)
                                                <option value="{{$role_item['role_id']}}" @if($row['user_role_id'] == $role_item['role_id']) selected @endif>{{$role_item['role_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <button type="submit" name="submit" id="client-contact-form-submit" class="mb-2 btn btn-primary mr-2">@if($row->user_id > 0) Сохранить @else Добавить @endif</button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </div>
        <!-- End Default Light Table -->
    </div>
@endsection
