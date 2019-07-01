@if(@count($deal_history_list) > 0)
    @foreach($deal_history_list as $key => $deal_history_item)
        <div class="user-activity__item d-flex my-2">
            <div class="user-activity__item__content">
                <span class="text-light">
                    {{$deal_history_item['deal_history_datetime_format']}} <br>
                    {{$deal_history_item['user_surname']}} {{$deal_history_item['user_name']}}
                </span>
                <p style="font-weight: normal"><?=$deal_history_item['deal_history_text']?></p>
            </div>
        </div>
    @endforeach
@endif