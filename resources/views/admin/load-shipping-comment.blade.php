@if(@count($shipping_comment_list) > 0)
    @foreach($shipping_comment_list as $key => $shipping_comment_item)
        <div class="rounded border-danger border px-1 py-1 mb-2 task-small-card" id="task-small-card-1">
            <div class="d-flex align-items-center justify-content-between">
                <span class="task-small-card-status">
                     <span class="task-small-card-status-text">
                        {{$shipping_comment_item['user_surname']}} {{$shipping_comment_item['user_name']}}
                    </span>
                </span>
                <span class="task-small-card-date">
                  <span class="task-small-card-date-text">
                     {{$shipping_comment_item['shipping_comment_datetime_format']}}
                  </span>
                </span>
            </div>
            <div>
                <p class="task-small-card-name my-2">
                    <?=nl2br($shipping_comment_item['shipping_comment_text'])?>
                </p>
            </div>
            <button type="button" onclick="deleteShippingComment({{$shipping_comment_item['shipping_comment_id']}},this)" name="submit" id="deal-card-1-form-submit" class="mb-2 mt-2 btn btn-file mr-2"><i class="fas fa-times text-danger mr-2"></i><span class="text-danger border-danger">Удалить</span></button>
        </div>
    @endforeach
@endif