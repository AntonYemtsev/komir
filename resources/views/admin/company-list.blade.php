@extends('admin.layout')

@section('content')
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row align-items-center no-gutters py-4">
            <div class="col-12 col-sm-2 text-center text-sm-left mb-0">
                {{--<h3 class="page-title">Компании</h3>--}}
            </div>
        </div>
        <!-- End Page Header -->
        <!-- Default Light Table -->
        <div class="row">
            <div class="col">
                <div class="card card-small mb-4">
                    <div class="card-header d-flex border-bottom no-gutters">
                        <div class="col-12 col-sm-6">
                            <span>Количество записей</span>
                            <select id="select-company-lines-qty" class="form-control ml-2 d-inline-block" style="width: 75px;" onchange="setSearchParam()">
                                <option value="20" @if($row_count == 20) selected @endif>20</option>
                                <option value="50" @if($row_count == 50) selected @endif>50</option>
                            </select>

                            <a href="/admin/company-edit/0">
                                <button type="button" name="submit" id="company-transporter-form-submit" class="mb-2 btn btn-primary mr-2">Добавить</button>
                            </a>
                        </div>
                        <div class="col-12 col-sm-3"></div>
                        <div class="col-12 col-sm-3">
                            <div class="ml-auto input-group input-group-seamless input-group-sm" >
                                <div class="input-group-prepend">
                                      <span class="input-group-text">
                                        <i class="material-icons">search</i>
                                      </span>
                                </div>
                                <input class="form-control"  style="height: calc(2.09375rem + 2px)" id="search_word" value="{{$search_word}}">
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0 pb-3 text-center">
                        <table class="table mb-0 companys-table">
                            <thead class="bg-light">
                            <tr>
                                <th scope="col" class="border-0">#</th>
                                <th scope="col" class="border-0">Компания</th>
                                <th scope="col" class="border-0">ФИО руководителя</th>
                                <th scope="col" class="border-0">Должность руководителя</th>
                                <th scope="col" class="border-0">Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(@count($row) > 0)
                                @foreach($row as $key => $company_item)
                                        <tr>
                                            <td>{{$loop->index}}</td>
                                            <td>{{$company_item['company_name']}}</td>
                                            <td>{{$company_item['company_ceo_name']}}</td>
                                            <td>{{$company_item['company_ceo_position']}}</td>
                                            <td>
                                                <div class="companys-table__actions">
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="/admin/company-edit/{{$company_item->company_id}}">
                                                            <button type="button" class="btn btn-white">
                                                              <span class="text-light">
                                                                <i class="material-icons">more_vert</i>
                                                              </span> Изменить
                                                            </button>
                                                        </a>
                                                        <button type="button" class="btn btn-white" onclick="deleteCompany({{$company_item->company_id}},this)">
                                                          <span class="text-danger">
                                                            <i class="material-icons">clear</i>
                                                          </span> Удалить
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                        <div class="dataTables_paginate paging_bootstrap pagination" style="float: right; margin-right: 20px;">
                            {!! $row->appends(\Illuminate\Support\Facades\Input::except('page'))->links() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- End Default Light Table -->
    </div>

    <script>
        function deleteCompany(company_id,ob){
            if (!confirm('Вы действительно хотите удалить компанию №' + company_id +'?')) {
                return false;
            }

            $.ajax({
                type: 'GET',
                url: "/admin/delete-company",
                data: {_token: CSRF_TOKEN, company_id: company_id},
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при удалении компании", null, null, 'danger');
                    }
                    else{
                        Notify("Компания #" + company_id + " удалена", null, null, 'success');
                        $(ob).closest("tr").remove();
                    }
                }
            });
        }

        function setSearchParam(){
            window.location.href = "/admin/company-list?row_count=" + $("#select-company-lines-qty").val() + "&search_word=" + $("#search_word").val();
        }

        $("#search_word").keyup(function(event) {
            if (event.keyCode === 13) {
                setSearchParam();
            }
        });
    </script>

@endsection

