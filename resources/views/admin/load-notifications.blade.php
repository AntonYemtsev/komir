<a class="nav-link nav-link-icon text-center" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    <div class="nav-link-icon__wrapper">
        <i class="material-icons">&#xE7F4;</i>
        @if(@count($user_task_list) > 0)
            <span class="badge badge-pill badge-danger">{{@count($user_task_list)}}</span>
        @endif
    </div>
</a>
<div class="dropdown-menu dropdown-menu-small" aria-labelledby="dropdownMenuLink">
    @if(@count($user_task_list) > 0)
        @foreach($user_task_list as $key => $user_task_item)
            <a class="dropdown-item" href="/admin/deal-edit/{{$user_task_item['user_task_deal_id']}}">
                <div class="notification__icon-wrapper">
                    <div class="notification__icon">
                        <i class="material-icons">&#xE6E1;</i>
                    </div>
                </div>
                <div class="notification__content">
                    <p><label style="margin: 0; color: {{$user_task_item['task_color']}}">{{$user_task_item['task_name']}}:</label> <?=nl2br($user_task_item['user_task_text'])?></p>
                    <span class="notification__category">{{$user_task_item['user_task_start_date_format']}} {{$user_task_item['user_task_start_time']}} - {{$user_task_item['user_task_end_date_format']}} {{$user_task_item['user_task_end_time']}}</span>
                </div>
            </a>
        @endforeach

        <a class="dropdown-item notification__all text-center" href="/admin/profile"> Посмотреть все задачи </a>
    @endif
</div>