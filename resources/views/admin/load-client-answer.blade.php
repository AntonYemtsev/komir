@if(@count($client_answer_list) > 0)
    @foreach($client_answer_list as $key => $client_answer_item)
        <div class="rounded border-danger border px-1 py-1 mb-2 task-small-card" id="task-small-card-1">
            <div class="d-flex align-items-center justify-content-between">
                <span class="task-small-card-status">
                     <span class="task-small-card-status-text">
                        {{$client_answer_item['user_surname']}} {{$client_answer_item['user_name']}}
                    </span>
                </span>
                <span class="task-small-card-date">
                  <span class="task-small-card-date-text">
                     {{$client_answer_item['client_answer_datetime_format']}}
                  </span>
                </span>
            </div>
            <div>
                <p class="task-small-card-name my-2">
                    <?=nl2br($client_answer_item['client_answer_text'])?>
                </p>
            </div>
            <button type="button" onclick="deleteClientAnswer({{$client_answer_item['client_answer_id']}},this)" name="submit" id="deal-card-1-form-submit" class="mb-2 mt-2 btn btn-file mr-2"><i class="fas fa-times text-danger mr-2"></i><span class="text-danger border-danger">Удалить</span></button>
        </div>
    @endforeach
@endif