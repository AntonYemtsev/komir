@extends('admin.top')

@section('layout')
    <?php  $user = Auth::user();
            $action_name = "";
            $controller_name = "";
            $current_path_parts = explode("/",Route::getFacadeRoot()->current()->uri());
            if(isset($current_path_parts[0])){
                $controller_name = $current_path_parts[0];
            }
            if(isset($current_path_parts[1])){
                $action_name = $current_path_parts[1];
            }
    ?>
    <style>
        .dropdown-parent{position: relative}

        .selection,.select2-selection,.select2-selection__rendered{width: 100%}
        .select2-container .select2-selection--single{height: calc(2.09375rem + 2px);     border-color: rgb(225, 229, 235);}
        .select2-container--default .select2-selection--single .select2-selection__rendered{text-decoration: none; color: #000; margin-top: 2px; margin-bottom: 3px; font-weight: 300;font-size: .8125rem;}
        .select2-container--default .select2-selection--single .select2-selection__arrow {top: 4px;}
        .select2-container--default .select2-selection--single .select2-selection__arrow b{border-color: #000 transparent transparent transparent;}
        #status10:before{ content: "10";}
    </style>

    <style>
        #notifications {
            cursor: pointer;
            position: fixed;
            right: 0px;
            z-index: 9999;
            bottom: 0px;
            margin-bottom: 22px;
            margin-right: 15px;
            max-width: 300px;
        }

        #notifications .close{
            position: relative;
            top: -4px;
            color: white;
        }
    </style>
    <div id="notifications"></div>


    <body class="h-100">
        <meta name="csrf-token" content="{{ csrf_token() }}" />

        <div class="container-fluid">
            <div class="row">
                <!-- Main Sidebar -->
                <aside class="main-sidebar col-12 col-md-3 col-lg-2 px-0">
                    <div class="main-navbar">
                        <nav class="navbar align-items-stretch navbar-light bg-white flex-md-nowrap border-bottom p-0">
                            <a class="navbar-brand w-100 mr-0" href="/admin/index" style="line-height: 25px;">
                                <div class="d-table m-auto">
                                    <img id="main-logo" class="d-inline-block align-top mr-1" style="max-width: 65%;" src="/admin/images/main-logo.svg" alt="Komir.kz">
                                </div>
                            </a>
                            <a class="toggle-sidebar d-sm-inline d-md-none d-lg-none">
                                <i class="material-icons">&#xE5C4;</i>
                            </a>
                        </nav>
                    </div>
                    <form action="#" class="main-sidebar__search w-100 border-right d-sm-flex d-md-none d-lg-none">
                        <div class="input-group input-group-seamless ml-3">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-search"></i>
                                </div>
                            </div>
                            <input class="navbar-search form-control" type="text" placeholder="Поиск" aria-label="Search"> </div>
                    </form>
                    <div class="nav-wrapper">
                        <ul class="nav flex-column">
                            <li class="nav-item">
                                <a class="nav-link @if($action_name == "index") active @endif " href="/admin/index">
                                    <i class="material-icons">pie_chart</i>
                                    <span>Аналитика</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="/admin/deal-list?type=list">
                                    <i class="material-icons">vertical_split</i>
                                    <span>Сделки</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="/admin/user-task-list">
                                    <i class="material-icons">note_add</i>
                                    <span>Задачи</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="/admin/station-list">
                                    <i class="material-icons">view_module</i>
                                    <span>Тарифы</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="/admin/client-list">
                                    <i class="material-icons">table_chart</i>
                                    <span>Клиенты</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="/admin/profile">
                                    <i class="material-icons">person</i>
                                    <span>Личный кабинет</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link dropdown-parent" data-toggle="dropdown-tab-settings" href="javascript:;">
                                    <i class="material-icons">settings</i>
                                    <span>Настройки</span>
                                    <span class="dropdown-arrow">▶</span>
                                </a>
                            </li>
                            <ul class="nav flex-column dropdown-tab" id="dropdown-tab-settings">
                                <li class="nav-item ">
                                    <a class="nav-link" href="/admin/deal-template-file-list">
                                        <span class="ml-4">Шаблон файлов и email</span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="/admin/system-info-list">
                                        <span class="ml-4">Инфо о владельце системы</span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="/admin/auto-task-list">
                                        <span class="ml-4">Автозадачи</span>
                                    </a>
                                </li>
                            </ul>


                            <li class="nav-item" >
                                <a class="nav-link dropdown-parent" data-toggle="dropdown-tab-dict" href="javascript:;">
                                    <i class="material-icons">settings</i>
                                    <span>Справочники</span>
                                    <span class="dropdown-arrow">▶</span>
                                </a>
                            </li>
                            <ul class="nav flex-column dropdown-tab" id="dropdown-tab-dict">
                                <li class="nav-item ">
                                    <a class="nav-link" href="/admin/company-list">
                                        <span class="ml-4">Компании</span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="/admin/user-list">
                                        <span class="ml-4">Пользователи</span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="/admin/region-list">
                                        <span class="ml-4">Области</span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="/admin/bank-list">
                                        <span class="ml-4">Банк</span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="/admin/payment-list">
                                        <span class="ml-4">Условия оплаты</span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="/admin/delivery-list">
                                        <span class="ml-4">Срок доставки</span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="/admin/brand-list">
                                        <span class="ml-4">Разрез</span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="/admin/mark-list">
                                        <span class="ml-4">Марка угля</span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="/admin/fraction-list">
                                        <span class="ml-4">Фракции</span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="/admin/percent-list">
                                        <span class="ml-4">Процент владельца</span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="/admin/status-list">
                                        <span class="ml-4">Статус</span>
                                    </a>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="/admin/timezone-list">
                                        <span class="ml-4">Часовой пояс</span>
                                    </a>
                                </li>
                            </ul>
                        </ul>
                    </div>
                </aside>
                <!-- End Main Sidebar -->
                <main class="main-content col-lg-10 col-md-9 col-sm-12 p-0 offset-lg-2 offset-md-3">
                    <div class="main-navbar sticky-top bg-white">
                        <!-- Main Navbar -->
                        <nav class="navbar align-items-stretch navbar-light flex-md-nowrap p-0">
                            <div class="col-md-9 d-flex align-items-center justify-content-between">
                                <h4 class="mb-0 ml-2">
                                    @if($action_name == "bank-list")
                                        Банк
                                    @elseif($action_name == "bank-edit")
                                        @if($row['bank_id'] > 0) {{$row['bank_name']}} @else Добавление нового банка @endif

                                    @elseif($action_name == "brand-list")
                                        Разрез
                                    @elseif($action_name == "brand-edit")
                                        @if($row['brand_id'] > 0) {{$row['brand_name']}} @else Добавление нового разреза @endif

                                    @elseif($action_name == "client-list")
                                        Клиенты
                                    @elseif($action_name == "client-edit")
                                        @if($row['client_id'] > 0) {{$row['client_name']}} @else Добавление нового клиента @endif

                                    @elseif($action_name == "company-list")
                                        Компании
                                    @elseif($action_name == "company-edit")
                                        @if($row['company_id'] > 0) {{$row['company_name']}} @else Добавление новой компании @endif

                                    @elseif($action_name == "deal-list")
                                        Сделки
                                    @elseif($action_name == "deal-edit")
                                        @if($row['deal_id'] > 0) {{$row['station_name']}} - {{$row['mark_name']}}  {{$row['deal_volume']}} тонн @else Добавление новой сделки @endif

                                    @elseif($action_name == "deal-template-file-list")
                                        Шаблоны файлов сделки
                                    @elseif($action_name == "deal-template-file-edit")
                                        @if($row['deal_template_file_id'] > 0)
                                            @if($row['deal_template_type_id'] == 1)
                                                Коммерческое предложение. ID - {{$row['deal_template_file_id']}}
                                            @elseif($row['deal_template_type_id'] == 2)
                                                Счет на оплату. ID - {{$row['deal_template_file_id']}}
                                            @elseif($row['deal_template_type_id'] == 3)
                                                Приложение №3. ID - {{$row['deal_template_file_id']}}
                                            @elseif($row['deal_template_type_id'] == 4)
                                                Email "КП". ID - {{$row['deal_template_file_id']}}
                                            @elseif($row['deal_template_type_id'] == 5)
                                                Email "Счет на оплату". ID - {{$row['deal_template_file_id']}}
                                            @elseif($row['deal_template_type_id'] == 6)
                                                Email "Заявка разрезу". ID - {{$row['deal_template_file_id']}}
                                            @elseif($row['deal_template_type_id'] == 7)
                                                Email "Комментарии по отгрузке". ID - {{$row['deal_template_file_id']}}
                                            @elseif($row['deal_template_type_id'] == 8)
                                                Email "Комментарии по доставке". ID - {{$row['deal_template_file_id']}}
                                            @endif
                                        @else
                                            Добавление нового шаблона файла
                                        @endif

                                    @elseif($action_name == "delivery-list")
                                        Срок доставки
                                    @elseif($action_name == "delivery-edit")
                                        @if($row['delivery_id'] > 0) {{$row['delivery_name']}} @else Добавление новой сроки доставки @endif

                                    @elseif($action_name == "fraction-list")
                                        Фракции
                                    @elseif($action_name == "fraction-edit")
                                        @if($row['fraction_id'] > 0) {{$row['fraction_name']}} @else Добавление новой фракции @endif

                                    @elseif($action_name == "mark-list")
                                        Марки угля
                                    @elseif($action_name == "mark-edit")
                                        @if($row['mark_id'] > 0) {{$row['mark_name']}} @else Добавление новой марки угля @endif

                                    @elseif($action_name == "payment-list")
                                        Условия оплаты
                                    @elseif($action_name == "payment-edit")
                                        @if($row['payment_id'] > 0) {{$row['payment_name']}} @else Добавление новой условии оплаты @endif

                                    @elseif($action_name == "percent-list")
                                        Процент владельца
                                    @elseif($action_name == "percent-edit")
                                        @if($row['percent_id'] > 0) {{$row['percent_name']}} @else Добавление нового процента владельца @endif

                                    @elseif($action_name == "profile")
                                        {{$row['user_surname']}} {{$row['user_name']}}

                                    @elseif($action_name == "region-list")
                                        Области
                                    @elseif($action_name == "region-edit")
                                        @if($row['region_id'] > 0) {{$row['region_name']}} @else Добавление новой области @endif

                                    @elseif($action_name == "station-list")
                                        Тарифы
                                    @elseif($action_name == "station-edit")
                                        @if($row['station_id'] > 0) {{$row['station_name']}} @else Добавление нового тарифа @endif

                                    @elseif($action_name == "status-list")
                                        Статусы
                                    @elseif($action_name == "status-edit")
                                        @if($row['status_id'] > 0) {{$row['status_name']}} @else Добавление нового статуса @endif

                                    @elseif($action_name == "timezone-list")
                                        Часовой пояс
                                    @elseif($action_name == "timezone-edit")
                                        @if($row['timezone_id'] > 0) {{$row['timezone_name']}} @else Добавление нового часового пояса @endif

                                    @elseif($action_name == "auto-task-list")
                                        Автозадачи
                                    @elseif($action_name == "auto-task-edit")
                                        @if($row['auto_task_id'] > 0) {{$row['auto_task_id']}} @else Добавление новой автозадачи @endif

                                    @elseif($action_name == "user-list")
                                        Пользователи
                                    @elseif($action_name == "user-edit")
                                        @if($row['user_id'] > 0) {{$row['user_surname']}} {{$row['user_name']}} @else Добавление нового пользователя @endif

                                    @elseif($action_name == "system-info-list")
                                        Инфо о владельце системы
                                    @elseif($action_name == "system-info-edit")
                                        @if($row['system_info_id'] > 0) Владелец системы - {{$row['system_info_fio']}} @else Добавление нового владельца системы @endif

                                    @elseif($action_name == "user-task-list")
                                        Задачи
                                    @elseif($action_name == "index")
                                        Аналитика
                                    @endif
                                </h4>
                                @if($controller_name == "admin" && $action_name == "deal-list")
                                    <a href="/admin/deal-edit/0">
                                        <button type="button" class="btn btn-primary">Добавить сделку</button>
                                    </a>
                                @elseif($controller_name == "admin" && $action_name == "deal-edit")
                                    <button type="button" class="btn btn-danger" id="deal-reject-navbar" onclick="showDealRejectForm({{$row['deal_id']}})">Отказ клиента</button>
                                @endif
                            </div>
                            <ul class="navbar-nav border-left flex-row ">
                                <li class="nav-item border-right dropdown notifications">

                                </li>


                                <li class="nav-item dropdown d-flex align-items-center">
                                    <a class="nav-link dropdown-toggle text-nowrap px-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                                        <span class="d-none d-md-inline-block">{{$user->user_surname}} {{$user->user_name}}</span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-small">
                                        <a class="dropdown-item" href="/admin/profile">
                                            <i class="material-icons">&#xE7FD;</i> Профиль</a>
                                        <a class="dropdown-item" href="/admin/deal-list">
                                            <i class="material-icons">vertical_split</i> Сделки</a>
                                        <a class="dropdown-item" href="/admin/user-task-list">
                                            <i class="material-icons">note_add</i> Задачи</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item text-danger" href="/admin/logout">
                                            <i class="material-icons text-danger">&#xE879;</i> Выйти </a>
                                    </div>
                                </li>
                            </ul>
                            <nav class="nav">
                                <a href="#" class="nav-link nav-link-icon toggle-sidebar d-md-inline d-lg-none text-center border-left" data-toggle="collapse" data-target=".header-navbar" aria-expanded="false" aria-controls="header-navbar">
                                    <i class="material-icons">&#xE5D2;</i>
                                </a>
                            </nav>
                        </nav>
                    </div>
                    <!-- / .main-navbar -->

                    @yield('content')

                    <div class="modal-window-refuse rounded" id="modal-window-refuse">
                        <i class="fas fa-times modal-window-close" id="close-modal-window-refuse" style="font-size:18px"></i>
                        <div class="card-body p-0 py-1 rounded text-center">
                            <div class="card-header px-4 pb-0 text-left">
                                <h5 class="mb-0">Отказ клиента</h5>
                                <div class="d-flex flex-wrap no-gutters mt-2">
                                    <div class="col-12 col-sm-5">
                                        <span>ОТВЕТСТВЕННЫЙ</span>
                                        <p class="mb-0" id="deal-card-6-responsible">{{$user->user_surname}} {{$user->user_name}}</p>
                                    </div>
                                    <div class="col-12 col-sm-7 text-sm-right">
                                        <span>ДАТА ОТПРАВЛЕНИЯ</span>
                                        <p class="mb-0" id="deal-card-6-date"></p>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body px-4">
                                <form id="deal-refuse-form-new" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="deal_id" class="refuse-deal-id-hidden">
                                    <input type="hidden" name="deal_refuse_user_id" id="deal_refuse_user_id" value="{{$user->user_id}}">
                                    <div class="form-group">
                                        <textarea class="form-control" placeholder="Причина отказа" id="deal-tasks-form-comment" name="comment" rows="4"></textarea>
                                    </div>
                                    <button type="button" onclick="sendDealRefuseForm()" name="submit" id="deal-tasks-form-submit" class="mb-4 mt-2 btn btn-primary float-right">Отправить</button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="modal-window-refuse rounded" id="modal-window-task-complete">
                        <div class="card-body p-0 py-1 rounded text-center">
                            <div class="card-header px-4 pb-0 text-left">
                                <h5 class="mb-0">Выполнение задачи</h5>
                            </div>
                            <div class="card-body px-4">
                                <form id="user-task-complete-form-new" method="post">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="user_task_id" class="user-task-id-hidden">
                                    <div class="form-group">
                                        <textarea class="form-control" placeholder="Комментарии" id="deal-tasks-form-comment" name="user_task_comment" rows="4"></textarea>
                                    </div>
                                    <button type="button" onclick="sendUserTaskCompleteForm()" name="submit" id="deal-tasks-form-submit" class="mb-4 mt-2 btn btn-primary float-right">Выполнить</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        </div>

        <div id="modal-shadow"></div>
    </body>

    <script>
        $(document).ready(function() {
            $(".timepicker-input").timepicker({step: 1, wrapHours: true, show2400: true, timeFormat: 'H:i'});
            $(".select2-search").select2({
                "language": {
                    "noResults": function(){
                        return "Ничего не найдено";
                    }
                }
            });
            $(".notifications").load("/admin/load-notifications");
        });

        var timerId = setInterval(function() {
            $(".notifications").load("/admin/load-notifications");
        }, 60000);

        $('#tasks-card-3-form-percents').on("click", function(){
            if (document.getElementById('tasks-card-3-form-percents').checked) {
                document.getElementById('percent').style.color = '#007bff';
                document.getElementById('number').style.color = '#5a6169';
                document.getElementById('percent').style.fontWeight = 'bold';
                document.getElementById('number').style.fontWeight = 'normal';
            } else {
                document.getElementById('percent').style.color = '#5a6169';
                document.getElementById('number').style.color = '#007bff';
                document.getElementById('percent').style.fontWeight = 'normal';
                document.getElementById('number').style.fontWeight = 'bold';
            }
        });
        $('#see-all-clients').on("click", function(){
            document.getElementById('modal-shadow').style.display = 'block';
            document.getElementById('modal-window-clients').style.display = 'block';
        });
        $('#modal-shadow').on("click", function(){
            document.getElementById('modal-shadow').style.display = 'none';
            document.getElementById('modal-window-clients').style.display = 'none';
            document.getElementById('modal-window-refuse').style.display = 'none';
        });
        $('#close-modal-window-refuse').on("click", function(){
            document.getElementById('modal-shadow').style.display = 'none';
            document.getElementById('modal-window-refuse').style.display = 'none';
        })

        jQuery(function($) {
            $( ".datepicker").datepicker({
                showOtherMonths: true,
                selectOtherMonths: false,
                dateFormat: 'dd.mm.yy',
                monthNames : ['Январь','Февраль','Март','Апрель','Май','Июнь','Июль','Август','Сентябрь','Октябрь','Ноябрь','Декабрь'],
                dayNamesMin: ['Вс','Пн','Вт','Ср','Чт','Пт','Сб']
            });
        });

        function changeCheckboxValue(ob){
            if($(ob).is(":checked")){
                $(ob).closest(".form-group").find(".hidden-checkbox-value").attr("value",1);
            }
            else{
                $(ob).closest(".form-group").find(".hidden-checkbox-value").attr("value",0);
            }
        }
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

        function showDealRejectForm(deal_id){
//            $("#modal-window-refuse").find("#deal-card-6-responsible").html($("#deal_user_id3 option:selected").text());
            $(".refuse-deal-id-hidden").val(deal_id);
//            $("#deal_refuse_user_id").val($("#deal_user_id3").val());
            document.getElementById('modal-shadow').style.display = 'block';
            document.getElementById('modal-window-refuse').style.display = 'block';
        }
        document.getElementById('modal-shadow').onclick = function(){
            document.getElementById('modal-shadow').style.display = 'none';
            document.getElementById('modal-window-refuse').style.display = 'none';
            document.getElementById('modal-window-clients').style.display = 'none';
            document.getElementById('modal-window-task-complete').style.display = 'none';
        }

        function sendDealRefuseForm(){
            if (!$("#deal-refuse-form-new").valid()){
                return false;
            }
            $.ajax({
                type: 'POST',
                url: "/admin/send-deal-refuse-form",
                data: $("#deal-refuse-form-new").serialize(),
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при отправке данных", null, null, 'danger');
                    }
                    else if(data.result == "incorrect_status"){
                        Notify("Отказ клиента недоступна в текущем статусе", null, null, 'danger');
                    }
                    else{
                        Notify("Статус успешно изменен на 'Отказ клиента'", null, null, 'success');
                        window.location.href = "/admin/deal-list?type=list";
                    }
                }
            });
        }

        function showCompleteDealTaskForm(user_task_id,ob){
            $(".user-task-id-hidden").val(user_task_id);
            document.getElementById('modal-shadow').style.display = 'block';
            document.getElementById('modal-window-task-complete').style.display = 'block';
        }

        $(document).ready(function() {
            $("#user-task-complete-form-new").validate({
                rules: {
                    user_task_id: {required: true},
                    user_task_comment: {required: true}
                },
                messages: {
                    user_task_id: {required: ""},
                    user_task_comment: {required: ""}
                }
            });
        });

        function sendUserTaskCompleteForm(){
            if (!$("#user-task-complete-form-new").valid()){
                return false;
            }

            $.ajax({
                type: 'POST',
                url: "/admin/complete-user-task",
                data: $("#user-task-complete-form-new").serialize(),
                success: function(data){
                    if(data.result == false){
                        Notify("Ошибка при завершении задачи", null, null, 'danger');
                    }
                    else{
                        if($("#is_user_task_page").val() == 1){
                            window.location.href = window.location;
                        }
                        else{
                            document.getElementById('modal-shadow').style.display = 'none';
                            document.getElementById('modal-window-task-complete').style.display = 'none';
                            $(".task-small-card-block").empty();
                            $(".task-small-card-block").load("/admin/load-deal-task/" + $(".deal-id-hidden").val());
                            $(".notifications").load("/admin/load-notifications");
                        }
                    }
                }
            });
        }
    </script>
@endsection
