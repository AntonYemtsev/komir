@extends('admin.layout')

@section('content')
    <div class="main-content-container container-fluid px-4">
        <!-- Page Header -->
        <div class="page-header row align-items-center no-gutters py-4">
            {{--<h3 class="page-title">{{$row['user_surname']}} {{$row['user_name']}}</h3>--}}
        </div>
        <!--Main content-->
        <div class="tasks-card-wrapper">
            <div class="d-flex" style="width: auto">
                <div class="col-sm-4 tasks-card-single-wrapper">
                    <div class="tasks-card-single card card-small mb-4 pt-1">
                        <div class="card-header text-left">
                            <h5 class="mb-0">Личные данные</h5>
                        </div>
                        <div class="card-body">
                            <form class="login-form" id="profile-form" method="post">
                                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                <div class="form-group">
                                    <label for="login-form-email">Фамилия</label>
                                    <input type="text" id="profile-form-name" name="user_surname"  value="{{$row['user_surname']}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="login-form-email">Имя</label>
                                    <input type="text" id="profile-form-name" name="user_name"  value="{{$row['user_name']}}"  class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="login-form-email">Телефон</label>
                                    <input type="text" id="profile-form-phone"  name="user_phone"  value="{{$row['user_phone']}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="login-form-email">E-mail</label>
                                    <input type="email" id="profile-form-email"  name="email"  value="{{$row['email']}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="login-form-password">Текущий пароль</label>
                                    <input type="password" id="profile-form-currentPassword"  name="password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="login-form-password">Новый пароль</label>
                                    <input type="password" id="profile-form-newPassword" name="new_password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="login-form-password">Подтверждение пароля</label>
                                    <input type="password" id="profile-form-confirmPassword" name="repeat_password" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="profile-form-role">Роль</label>
                                    <select id="profile-form-role" class="form-control" name="user_role_id">
                                        @if(@count($role_list) > 0)
                                            @foreach($role_list as $key => $role_item)
                                                <option value="{{$role_item['role_id']}}" @if($role_item['role_id'] == $row['user_role_id']) selected @endif>{{$role_item['role_name']}}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <button onclick="updateProfileInfo()" type="button" name="submit" id="login-form-submit" class="mb-2 btn btn-primary mr-2">Обновить</button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="tasks-card-single-wrapper" id="profile-deals">
                    <div class="tasks-card-single card card-small mb-4 pt-1">
                        <div class="card-header text-left">
                            <h5 class="mb-0">Мои сделки</h5>
                            <div class="d-flex flex-wrap no-gutters mt-2">
                                <div class="col-12 col-sm-6">
                                    <span>СДЕЛОК</span>
                                    <p id="profile-deals-dealsQuantity">{{@count($deal_list)}}</p>
                                </div>
                                <div class="col-12 col-sm-6 text-sm-right">
                                    <span>СУММА</span>
                                    <p id="profile-deals-dealsSum">
                                        <?=preg_replace('/(\d)(?=((\d{3})+)(\D|$))/', '$1 ', $all_deals_sum[0]->deal_kp_sum_res);?>
                                    </p>
                                </div>
                            </div>
                            <div class="rounded col-12 mt-3 py-2 bg-primary"></div>
                        </div>
                        <div class="card-body">
                            @if(@count($deal_list) > 0)
                                @foreach($deal_list as $deal_item)
                                    <div class="rounded border-primary border px-1 py-1 mb-2 task-small-card" id="task-small-card-2">
                                        <div class="d-flex align-items-center justify-content-between">
                                          <span class="task-small-card-status">
                                            <span class="task-small-card-status-text">
                                               {{$deal_item['station_name']}} - {{$deal_item['mark_name']}}  {{$deal_item['deal_volume']}} тонн
                                            </span>
                                          </span>
                                            <span class="task-small-card-date text-right">
                                                <span class="task-small-card-date-text" id="task-small-card-2-date">
                                                 {{$deal_item['deal_datetime1_format']}}
                                                </span>
                                                <span class="task-small-card-date-icon text-primary">
                                                   <i class="far fa-calendar-alt"></i>
                                                </span>
                                            </span>
                                        </div>
                                        <div>
                                            <p class="task-small-card-name my-2" id="task-small-card-2-name">
                                                {{$deal_item['client_surname']}} {{$deal_item['client_name']}}
                                            </p>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between">
                                          <span class="task-small-card-responsible" id="task-small-card-2-responsible">
                                              @if($deal_item['deal_status_id'] <= 3)
                                                  {{$deal_item['deal_kp_sum']}} тг.
                                              @elseif($deal_item['deal_status_id'] >= 4)
                                                  <?
                                                  $discount_sum = $deal_item['deal_discount'];
                                                  if($deal_item['deal_discount_type'] == 1){
                                                      $discount_sum = $deal_item['deal_kp_sum']*$deal_item['deal_discount']/100;
                                                  }
                                                  ?>
                                                  <?=preg_replace('/(\d)(?=((\d{3})+)(\D|$))/', '$1 ', $deal_item['deal_kp_sum']-$discount_sum);?> тг.
                                              @endif
                                          </span>
                                            <a href="/admin/deal-edit/{{$deal_item['deal_id']}}" class="task-small-card-make text-primary">
                                                <span>
                                                  Перейти
                                                </span>
                                            </a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div class="tasks-card-single-wrapper" id="profile-tasks">
                    <div class="tasks-card-single card card-small mb-4 pt-1">
                        <div class="card-header text-left">
                            <h5 class="mb-0">Мои задачи</h5>
                            <div class="d-flex flex-wrap no-gutters mt-2">
                                <div class="col-12 col-sm-6">
                                    <span>ЗАДАЧИ</span>
                                    <p id="profile-deals-dealsQuantity">{{@count($user_task_list)}}</p>
                                </div>
                            </div>
                            <div class="rounded col-12 mt-3 py-2 bg-success"></div>
                        </div>
                        <div class="card-body">
                            @if(@count($user_task_list) > 0)
                                @foreach($user_task_list as $key => $user_task_item)
                                    <div class="rounded border-success border px-1 py-1 mb-2 task-small-card" id="task-small-card-3">
                                        <div class="d-flex align-items-center justify-content-between">
                                          <span class="task-small-card-status">
                                                <span class="task-small-card-status-icon" style="color: {{$user_task_item['task_color']}} !important;">
                                                    <i class="fas fa-circle"></i>
                                                </span>
                                                <span class="task-small-card-status-text">
                                                    {{$user_task_item['task_name']}}
                                                </span>
                                            </span>
                                            <span class="task-small-card-date text-right">
                                                <span class="task-small-card-date-icon" style="color: {{$user_task_item['task_color']}} !important;">
                                                <i class="far fa-calendar-alt"></i>
                                              </span>
                                              <span class="task-small-card-date-text">
                                                 {{$user_task_item['user_task_start_date_format']}} {{$user_task_item['user_task_start_time']}}
                                                  {{$user_task_item['user_task_end_date_format']}} {{$user_task_item['user_task_end_time']}}
                                              </span>
                                           </span>
                                        </div>
                                        <div>
                                            <p class="task-small-card-name my-2" id="task-small-card-3-name">
                                                <?=nl2br($user_task_item['user_task_text'])?>
                                            </p>
                                            <p class="task-small-card-name my-2">
                                                Комментарии: <?=nl2br($user_task_item['user_task_comment'])?>
                                            </p>
                                        </div>
                                        <div class="d-flex align-items-center justify-content-between">
                                          <span class="task-small-card-responsible" id="task-small-card-3-responsible">
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


            </div>
        </div>
        <!-- /Main content -->

    </div>

    <script>
        function updateProfileInfo(){
            $.ajax({
                type: 'POST',
                url: "/admin/update-profile-info",
                data: $("#profile-form").serialize(),
                success: function(data){
                    if(data.result == "incorrect_user"){
                        Notify("Ваш аккаунт не найден", null, null, 'danger');
                    }
                    else if(data.result == "incorrect_password"){
                        Notify("Неверный текущий пароль", null, null, 'danger');
                    }
                    else if(data.result == "incorrect_repeat"){
                        Notify("Новый и повтор пароли не совпадает", null, null, 'danger');
                    }
                    else if(data.result == false){
                        Notify("Ошибка при удалении банка", null, null, 'danger');
                    }
                    else{
                        Notify("Данные успешно обновлены", null, null, 'success');
                    }
                }
            });
        }
    </script>

@endsection

