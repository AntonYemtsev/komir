@if(@count($shipping_client_comment_list) > 0)
    @foreach($shipping_client_comment_list as $key => $shipping_client_comment_item)
        <div class="rounded border-danger border px-1 py-1 mb-2 task-small-card" id="task-small-card-1">
            <div class="d-flex align-items-center justify-content-between">
                <span class="task-small-card-status">
                     <span class="task-small-card-status-text">
                        {{$shipping_client_comment_item['user_surname']}} {{$shipping_client_comment_item['user_name']}}
                    </span>
                </span>
                <span class="task-small-card-date">
                  <span class="task-small-card-date-text">
                     {{$shipping_client_comment_item['shipping_comment_datetime_format']}}
                  </span>
                </span>
            </div>
            <div>
                <p class="task-small-card-name my-2">
                    <?=nl2br($shipping_client_comment_item['shipping_client_comment_text'])?>
                </p>
            </div>
            <button type="button" onclick="deleteShippingClientComment({{$shipping_client_comment_item['shipping_client_comment_id']}},this)" name="submit" id="deal-card-1-form-submit" class="mb-2 mt-2 btn btn-primary mr-2">Удалить</button>
            <button type="button" onclick="sendShippingClientCommentEmail({{$shipping_client_comment_item['shipping_client_comment_id']}},this)" name="submit" id="deal-card-1-form-submit" class="mb-2 mt-2 btn btn-primary mr-2">Отправить</button>
            <span style="font-size: 12px;margin-left: 5px;color: green;float: none;display: inline-block;" class="send-shipping-client-comment-result-span{{$shipping_client_comment_item['shipping_client_comment_id']}}"></span>
        </div>
    @endforeach
@endif