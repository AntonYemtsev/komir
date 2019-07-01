@if(@count($deal_close_file_list) > 0)
    @foreach($deal_close_file_list as $key => $deal_close_file_item)
        <div class="d-flex flex-wrap no-gutters align-items-center justify-content-between">
            <div class="col-12">
                <p class="deal-card-5-bill-name">{{$deal_close_file_item['deal_file_name']}}</p>
                <p class="deal-card-5-bill-date">
                    {{$deal_close_file_item['deal_bill_volume']}} тонн, Цена: {{floor($sum)}} тг.,
                    Сумма {{floor($deal_close_file_item['deal_bill_volume']*$sum)}} тг.
                </p>
                <p class="deal-card-5-bill-date">{{$deal_close_file_item['deal_file_date_format']}}</p>
                <a href="/deal_files/{{$deal_close_file_item['deal_file_src']}}" target="_blank">
                    <button type="button" class="mb-2 btn btn-sm btn-file mr-3"><i class="fas fa-file-download text-primary mr-2"></i><span class="text-primary border-primary">Скачать</span></button>
                </a>
                <button onclick="sendDealBillClose({{$deal_close_file_item['deal_file_id']}},{{$deal_close_file_item['deal_file_deal_id']}})" type="button" id="deal-card-5-bill1-send" class="mb-2 btn btn-sm btn-file mr-2"><i class="fas fa-share text-primary mr-2"></i><span class="text-primary border-primary">Отправить</span></button>
                <button onclick="deleteDealClose({{$deal_close_file_item['deal_file_id']}},{{$deal_close_file_item['deal_file_deal_id']}})" type="button" id="deal-card-5-bill1-send" class="mb-2 btn btn-sm btn-file mr-3"><i class="fas fa-times text-danger mr-2"></i><span class="text-danger border-danger">Удалить</span></button>
                <span style="font-size: 12px;margin-left: 5px;line-height: 1.2;color: green;text-align: center;position: relative;top: -2px;" class="send-deal-close-result-span{{$deal_close_file_item['deal_file_id']}}"></span>
            </div>
        </div>
    @endforeach
@endif