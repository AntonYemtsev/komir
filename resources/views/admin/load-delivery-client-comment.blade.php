@if(@count($delivery_client_comment_list) > 0)
    @foreach($delivery_client_comment_list as $key => $delivery_client_comment_item)
        <div class="rounded border-danger border px-1 py-1 mb-2 task-small-card" id="task-small-card-1">
            <div class="d-flex align-items-center justify-content-between">
                <span class="task-small-card-status">
                     <span class="task-small-card-status-text">
                        {{$delivery_client_comment_item['user_surname']}} {{$delivery_client_comment_item['user_name']}}
                    </span>
                </span>
                <span class="task-small-card-date">
                  <span class="task-small-card-date-text">
                     {{$delivery_client_comment_item['delivery_comment_datetime_format']}}
                  </span>
                </span>
            </div>
            <div>
                <p class="task-small-card-name my-2">
                    <?=nl2br($delivery_client_comment_item['delivery_client_comment_text'])?>
                </p>
            </div>
            <button type="button" onclick="deleteDeliveryClientComment({{$delivery_client_comment_item['delivery_client_comment_id']}},this)" name="submit" id="deal-card-1-form-submit" class="mb-2 mt-2 btn btn-primary mr-2">Удалить</button>
            <button type="button" onclick="sendDeliveryClientCommentEmail({{$delivery_client_comment_item['delivery_client_comment_id']}},this)" name="submit" id="deal-card-1-form-submit" class="mb-2 mt-2 btn btn-primary mr-2">Отправить</button>
            <span style="font-size: 12px;margin-left: 5px;color: green;float: none;display: inline-block;" class="send-delivery-client-comment-result-span{{$delivery_client_comment_item['delivery_client_comment_id']}}"></span>
        </div>
    @endforeach
@endif