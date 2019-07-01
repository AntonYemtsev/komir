@extends('admin.layout')

@section('content')
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row no-gutters py-4">
            <div class="col-12 col-sm-4 text-center text-sm-left mb-0">
                {{--<h3 class="page-title">Марки угля</h3>--}}
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
                            <select id="select-client-lines-qty" class="form-control ml-2 d-inline-block" style="width: 75px;" onchange="setSearchParam()">
                                <option value="20" @if($row_count == 20) selected @endif>20</option>
                                <option value="50" @if($row_count == 50) selected @endif>50</option>
                            </select>

                            <a href="/admin/mark-edit/0">
                                <button type="button" name="submit" id="client-transporter-form-submit" class="mb-2 btn btn-primary mr-2">Добавить</button>
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
                        <table class="table mb-0 clients-table">
                            <thead class="bg-light">
                            <tr>
                                <th scope="col" class="border-0">#</th>
                                <th scope="col" class="border-0">Наименование</th>
                                <th scope="col" class="border-0">Код</th>
                                <th scope="col" class="border-0">Разрез</th>
                                <th scope="col" class="border-0">Действия</th>
                            </tr>
                            </thead>
                            <tbody>
                                
                                @if(@count($row) > 0)
                                    @foreach($row as $key => $mark_item)
                                        
                                        <tr>
                                            <td>{{$loop->index}}</td>
                                            <td>{{$mark_item->mark_name}}</td>
                                            <td>{{$mark_item->mark_code}}</td>
                                            <td>{{$mark_item->brand_name}}</td>
                                            <td>
                                                <div class="clients-table__actions">
                                                    <div class="btn-group btn-group-sm">
                                                        <a href="/admin/mark-edit/{{$mark_item->mark_id}}">
                                                            <button type="button" class="btn btn-white">
                                                              <span class="text-light">
                                                                <i class="material-icons">more_vert</i>
                                                              </span> Изменить
                                                            </button>
                                                        </a>
                                                        <button type="button" class="btn btn-white" onclick="deleteMark({{$mark_item->mark_id}},this)">
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
                    </div>
                </div>
            </div>
        </div>
        <!-- End Default Light Table -->
    </div>

    <script>
        function deleteMark(mark_id,ob){
            if (!confirm('Вы действительно хотите удалить марку угля №' + mark_id +'?')) {
                return false;
            }

            $.ajax({
                type: 'GET',
                url: "/admin/delete-mark",
                data: {_token: CSRF_TOKEN, mark_id: mark_id},
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при удалении марки угля", null, null, 'danger');
                    }
                    else{
                        Notify("Марка угля #" + mark_id + " удалена", null, null, 'success');
                        $(ob).closest("tr").remove();
                    }
                }
            });
        }

        function setSearchParam(){
            window.location.href = "/admin/mark-list?row_count=" + $("#select-client-lines-qty").val() + "&search_word=" + $("#search_word").val();
        }

        $("#search_word").keyup(function(event) {
            if (event.keyCode === 13) {
                setSearchParam();
            }
        });
    </script>

@endsection

