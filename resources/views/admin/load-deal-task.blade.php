@if(@count($deal_task_list) > 0)
    @foreach($deal_task_list as $key => $deal_task_item)
        <div class="rounded border-danger border px-1 py-1 mb-2 task-small-card" id="task-small-card-1">
            <div class="d-flex align-items-center justify-content-between">
                <span class="task-small-card-status">
                    <span class="task-small-card-status-icon" style="color: {{$deal_task_item['task_color']}} !important;">
                        <i class="fas fa-circle"></i>
                    </span>
                    <span class="task-small-card-status-text">
                        {{$deal_task_item['task_name']}}
                    </span>
                </span>
                <span class="task-small-card-date text-right">
                  <span class="task-small-card-date-icon" style="color: {{$deal_task_item['task_color']}} !important;">
                    <i class="far fa-calendar-alt"></i>
                  </span>
                  <span class="task-small-card-date-text">
                     {{$deal_task_item['user_task_start_date_format']}} {{$deal_task_item['user_task_start_time']}}
                     {{$deal_task_item['user_task_end_date_format']}} {{$deal_task_item['user_task_end_time']}}
                  </span>
                </span>
            </div>
            <div>
                <p class="task-small-card-name my-2">
                    <?=nl2br($deal_task_item['user_task_text'])?>
                </p>
                <p class="task-small-card-name my-2">
                    Комментарии: <?=nl2br($deal_task_item['user_task_comment'])?>
                </p>
            </div>

            <div class="d-flex align-items-center justify-content-between">
                <span class="task-small-card-responsible">
                    {{$deal_task_item['user_surname']}} {{$deal_task_item['user_name']}}
                </span>
                @if($deal_task_item['user_task_task_id'] < 3)
                    <a href="javascript:void(0)" onclick="showCompleteDealTaskForm({{$deal_task_item['user_task_id']}},this)" class="task-small-card-make" style="color: {{$deal_task_item['task_color']}} !important;">
                      <span>
                        Выполнить
                      </span>
                    </a>
                @endif
            </div>
        </div>
    @endforeach
@endif