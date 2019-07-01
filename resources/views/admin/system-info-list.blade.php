@extends('admin.layout')

@section('content')
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row align-items-center no-gutters py-4">
            <div class="col-12 col-sm-2 text-center text-sm-left mb-0">
            </div>
        </div>
        <!-- End Page Header -->
        <!-- Default Light Table -->
        <div class="row">
            <div class="col">
                <div class="card card-small mb-4">
                    <div class="card-body p-0 pb-3 text-center">
                        <table class="table mb-0 companys-table">
                            <thead class="bg-light">
                            <tr>
                                <th scope="col" class="border-0">#</th>
                                <th scope="col" class="border-0">ФИО владельца</th>
                                <th scope="col" class="border-0">Название компании</th>
                                <th scope="col" class="border-0">Адрес</th>
                                <th scope="col" class="border-0">Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(@count($row) > 0)
                                @foreach($row as $key => $system_info_item)
                                        <tr>
                                            <td>{{$loop->index}}</td>
                                            <td>{{$system_info_item['system_info_fio']}}</td>
                                            <td>{{$system_info_item['system_info_company_name']}}</td>
                                            <td>{{$system_info_item['system_info_address']}}</td>
                                            <td>
                                                <div class="companys-table__actions">
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="/admin/system-info-edit/{{$system_info_item->system_info_id}}">
                                                            <button type="button" class="btn btn-white">
                                                              <span class="text-light">
                                                                <i class="material-icons">more_vert</i>
                                                              </span> Изменить
                                                            </button>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Default Light Table -->
    </div>
@endsection

