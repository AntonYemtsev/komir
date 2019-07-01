@extends('admin.layout')

@section('content')
    <input type="hidden" value="1" id="is_user_task_page">
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row align-items-center no-gutters py-4">
            {{--<div class="col-12 col-sm-2 text-center text-sm-left mb-0">--}}
                {{--<h3 class="page-title">Задачи</h3>--}}
            {{--</div>--}}
            <form id="user_task_list_form" method="get" action="/admin/user-task-list" style="display: contents">
                <div class="col-12 col-sm-7 d-flex text-center text-sm-left mb-0">
                    <div class="col-6 col-sm-3">
                        <select id="select-tasks-2" class="form-control client-id-select select2-search" name="client_id" onchange="searchByUserTasks()">
                            <option value="0">Клиент</option>
                            @if(@count($client_list) > 0)
                                @foreach($client_list as $key => $client_item)
                                    <option value="{{$client_item['client_id']}}" @if($client_item['client_id'] == $client_id) selected @endif >{{$client_item['client_surname']}} {{ $client_item['client_name'] }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-6 col-sm-3">
                        <select id="select-tasks-4" class="form-control user-id-select select2-search" name="user_id" onchange="searchByUserTasks()">
                            <option value="0">Ответственный</option>
                            @if(@count($user_list) > 0)
                                @foreach($user_list as $key => $user_item)
                                    <option value="{{$user_item['user_id']}}" @if($user_item['user_id'] == $user_id) selected @endif >{{$user_item['user_surname']}} {{ $user_item['user_name'] }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-3 text-center text-sm-left mb-0">
                    <!-- DO NOT CHANGE IDs IN DATE PICKER -->
                    <div id="blog-overview-date-range" class="input-daterange input-group input-group-sm my-auto ml-auto mr-auto ml-sm-auto mr-sm-0" style="max-width: 350px;">
                        <input type="text" class="input-sm form-control user-task-start-date datepicker-here" name="user_task_start_date" placeholder="01.01.2019" id="blog-overview-date-range-1" style="height: calc(2.09375rem + 2px)" value="{{$user_task_start_date}}" onchange="searchByUserTasks()">
                        <input type="text" class="input-sm form-control user-task-end-date datepicker-here" data-position="bottom right" name="user_task_end_date" placeholder="02.01.2019" id="blog-overview-date-range-2" style="height: calc(2.09375rem + 2px)" value="{{$user_task_end_date}}" onchange="searchByUserTasks()">
                        <span class="input-group-append">
                        <span class="input-group-text" style="height: calc(2.09375rem + 2px)">
                          <i class="material-icons"></i>
                        </span>
                      </span>
                    </div>
                </div>
            </form>
        </div>
        <!--Main content-->
        <div class="tasks-card-wrapper dragscroll">
            <div class="d-flex" style="width: auto">
                <div class="tasks-card-single-wrapper" id="tasks-card-1">
                    <div class="tasks-card-single card card-small mb-4 pt-1">
                        <div class="card-header text-left">
                            <h5 class="mb-0">Просрочено</h5>
                            <div class="d-flex flex-wrap no-gutters mt-2">
                                <div class="col-12 col-sm-6">
                                    <span>ЗАДАЧИ</span>
                                    <p id="tasks-card-1-dealsQuantity">{{@count($user_task_list[2])}}</p>
                                </div>
                            </div>
                            <div class="rounded col-12 mt-3 py-2 bg-danger"></div>
                        </div>
                        <div class="card-body">
                            @if(@count($user_task_list[2]) > 0)
                                @foreach($user_task_list[2] as $key => $user_task_item)
                                    <div class="rounded border-danger border px-1 py-1 mb-2 task-small-card" id="task-small-card-1">
                                        <div class="d-flex align-items-center justify-content-between">
                                          <span class="task-small-card-status">
                                              <a href="/admin/deal-edit/{{$user_task_item['deal_id']}}">
                                                <span class="task-small-card-status-text">
                                                   {{$user_task_item['station_name']}} - {{$user_task_item['mark_name']}}  {{$user_task_item['deal_volume']}} тонн
                                                </span>
                                              </a>
                                          </span>
                                            <span class="task-small-card-date">
                                                <span class="task-small-card-date-text" id="task-small-card-1-date">
                                                    {{$user_task_item['user_task_end_date_format']}} {{$user_task_item['user_task_end_time']}}
                                                </span>
                                                <span class="task-small-card-date-icon text-danger">
                                                   📆
                                                </span>
                                           </span>
                                        </div>
                                        <div>
                                            <p class="task-small-card-name my-2" id="task-small-card-1-name">
                                                <?=nl2br($user_task_item['user_task_text'])?>
                                            </p>
                                            @if(strlen($user_task_item['user_task_comment']) > 0)
                                                <p class="task-small-card-name my-2" id="task-small-card-1-name">
                                                    Комментарии: <?=nl2br($user_task_item['user_task_comment'])?>
                                                </p>
                                            @endif
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between">
                                          <span class="task-small-card-responsible" id="task-small-card-1-responsible">
                                              {{$user_task_item['user_surname']}} {{$user_task_item['user_name']}}
                                          </span>
                                            @if($user_task_item['user_task_task_id'] < 3)
                                                <a href="javascript:void(0)" onclick="showCompleteDealTaskForm({{$user_task_item['user_task_id']}},this)" class="task-small-card-make text-danger">
                                                    <span>
                                                      Выполнить
                                                    </span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tasks-card-single-wrapper" id="tasks-card-2">
                    <div class="tasks-card-single card card-small mb-4 pt-1">
                        <div class="card-header text-left">
                            <h5 class="mb-0">В процессе</h5>
                            <div class="d-flex flex-wrap no-gutters mt-2">
                                <div class="col-12 col-sm-6">
                                    <span>ЗАДАЧИ</span>
                                    <p id="tasks-card-2-dealsQuantity">{{@count($user_task_list[1])}}</p>
                                </div>
                            </div>
                            <div class="rounded col-12 mt-3 py-2 bg-primary"></div>
                        </div>
                        <div class="card-body">
                            @if(@count($user_task_list[1]) > 0)
                                @foreach($user_task_list[1] as $key => $user_task_item)
                                    <div class="rounded border-primary border px-1 py-1 mb-2 task-small-card" id="task-small-card-2">
                                        <div class="d-flex align-items-center justify-content-between">
                                          <span class="task-small-card-status">
                                              <a href="/admin/deal-edit/{{$user_task_item['deal_id']}}">
                                                <span class="task-small-card-status-text">
                                                   {{$user_task_item['station_name']}} - {{$user_task_item['mark_name']}}  {{$user_task_item['deal_volume']}} тонн
                                                </span>
                                              </a>
                                          </span>
                                                    <span class="task-small-card-date">
                                            <span class="task-small-card-date-text" id="task-small-card-2-date">
                                              {{$user_task_item['user_task_end_date_format']}} {{$user_task_item['user_task_end_time']}}
                                            </span>
                                            <span class="task-small-card-date-icon text-primary">
                                               📆
                                            </span>
                                           </span>
                                        </div>
                                        <div>
                                            <p class="task-small-card-name my-2" id="task-small-card-2-name">
                                                <?=nl2br($user_task_item['user_task_text'])?>
                                            </p>
                                            @if(strlen($user_task_item['user_task_comment']) > 0)
                                                <p class="task-small-card-name my-2" id="task-small-card-2-name">
                                                    Комментарии: <?=nl2br($user_task_item['user_task_comment'])?>
                                                </p>
                                            @endif
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between">
                                          <span class="task-small-card-responsible" id="task-small-card-2-responsible">
                                              {{$user_task_item['user_surname']}} {{$user_task_item['user_name']}}
                                          </span>
                                            @if($user_task_item['user_task_task_id'] < 3)
                                                <a href="javascript:void(0)" onclick="showCompleteDealTaskForm({{$user_task_item['user_task_id']}},this)" class="task-small-card-make text-primary">
                                                    <span>
                                                      Выполнить
                                                    </span>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tasks-card-single-wrapper" id="tasks-card-3">
                    <div class="tasks-card-single card card-small mb-4 pt-1">
                        <div class="card-header text-left">
                            <h5 class="mb-0">Выполнено в срок</h5>
                            <div class="d-flex flex-wrap no-gutters mt-2">
                                <div class="col-12 col-sm-6">
                                    <span>ЗАДАЧИ</span>
                                    <p id="tasks-card-3-dealsQuantity">{{@count($user_task_list[3])}}</p>
                                </div>
                            </div>
                            <div class="rounded col-12 mt-3 py-2 bg-success"></div>
                        </div>
                        <div class="card-body">
                            @if(@count($user_task_list[3]) > 0)
                                @foreach($user_task_list[3] as $key => $user_task_item)
                                    <div class="rounded border-success border px-1 py-1 mb-2 task-small-card" id="task-small-card-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                          <span class="task-small-card-status">
                                              <a href="/admin/deal-edit/{{$user_task_item['deal_id']}}">
                                                <span class="task-small-card-status-text">
                                                   {{$user_task_item['station_name']}} - {{$user_task_item['mark_name']}}  {{$user_task_item['deal_volume']}} тонн
                                                </span>
                                              </a>
                                          </span>
                                                    <span class="task-small-card-date">
                                            <span class="task-small-card-date-text" id="task-small-card-3-date">
                                              {{$user_task_item['user_task_end_date_format']}} {{$user_task_item['user_task_end_time']}}
                                            </span>
                                            <span class="task-small-card-date-icon text-success">
                                               📆
                                            </span>
                                           </span>
                                        </div>
                                        <div>
                                            <p class="task-small-card-name my-2" id="task-small-card-3-name">
                                                <?=nl2br($user_task_item['user_task_text'])?>
                                            </p>
                                            @if(strlen($user_task_item['user_task_comment']) > 0)
                                                <p class="task-small-card-name my-2" id="task-small-card-3-name">
                                                    Комментарии: <?=nl2br($user_task_item['user_task_comment'])?>
                                                </p>
                                            @endif
                                        </div>
                                        <div class="d-flex align-items-center">
                                          <span class="task-small-card-responsible" id="task-small-card-3-responsible">
                                              {{$user_task_item['user_surname']}} {{$user_task_item['user_name']}}
                                          </span>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tasks-card-single-wrapper" id="tasks-card-4">
                    <div class="tasks-card-single card card-small mb-4 pt-1">
                        <div class="card-header text-left">
                            <h5 class="mb-0">Выполнено с просрочкой</h5>
                            <div class="d-flex flex-wrap no-gutters mt-2">
                                <div class="col-12 col-sm-6">
                                    <span>ЗАДАЧИ</span>
                                    <p id="tasks-card-3-dealsQuantity">{{@count($user_task_list[4])}}</p>
                                </div>
                            </div>
                            <div class="rounded col-12 mt-3 py-2 bg-warning"></div>
                        </div>
                        <div class="card-body">
                            @if(@count($user_task_list[4]) > 0)
                                @foreach($user_task_list[4] as $key => $user_task_item)
                                    <div class="rounded border-warning border px-1 py-1 mb-2 task-small-card" id="task-small-card-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                          <span class="task-small-card-status">
                                              <a href="/admin/deal-edit/{{$user_task_item['deal_id']}}">
                                                <span class="task-small-card-status-text">
                                                   {{$user_task_item['station_name']}} - {{$user_task_item['mark_name']}}  {{$user_task_item['deal_volume']}} тонн
                                                </span>
                                              </a>
                                          </span>
                                                    <span class="task-small-card-date">
                                            <span class="task-small-card-date-text" id="task-small-card-4-date">
                                              {{$user_task_item['user_task_end_date_format']}} {{$user_task_item['user_task_end_time']}}
                                            </span>
                                            <span class="task-small-card-date-icon text-warning">
                                               📆
                                            </span>
                                           </span>
                                        </div>
                                        <div>
                                            <p class="task-small-card-name my-2" id="task-small-card-4-name">
                                                <?=nl2br($user_task_item['user_task_text'])?>
                                            </p>
                                            @if(strlen($user_task_item['user_task_comment']) > 0)
                                                <p class="task-small-card-name my-2" id="task-small-card-4-name">
                                                    Комментарии: <?=nl2br($user_task_item['user_task_comment'])?>
                                                </p>
                                            @endif
                                        </div>
                                        <div class="d-flex align-items-center">
                                          <span class="task-small-card-responsible" id="task-small-card-4-responsible">
                                               {{$user_task_item['user_surname']}} {{$user_task_item['user_name']}}
                                          </span>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <!-- /Main content -->

    </div>

    <script>
        function searchByUserTasks(){
            document.getElementById("user_task_list_form").submit();
        }
    </script>

@endsection

