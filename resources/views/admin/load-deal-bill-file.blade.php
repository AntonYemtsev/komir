@if(@count($deal_bill_file_list) > 0)
    @foreach($deal_bill_file_list as $key => $deal_bill_file_item)
        <div class="d-flex flex-wrap no-gutters align-items-center justify-content-between" id="deal-card-5-bill1">
            <div class="col-12">
                <p class="deal-card-5-bill-name" id="deal-card-5-bill1-name">Счет №{{$deal_bill_file_item['deal_file_bill_num']}}</p>
                <p class="deal-card-5-bill-date">
                    {{$deal_bill_file_item['deal_bill_volume']}} тонн, Цена: {{floor($sum)}} тг.,
                    Сумма {{floor($deal_bill_file_item['deal_bill_volume']*$sum)}} тг.
                </p>
                <p class="deal-card-5-bill-date" id="deal-card-5-bill1-date">{{$deal_bill_file_item['deal_file_date_format']}}</p>
                <a href="/deal_files/{{$deal_bill_file_item['deal_file_src']}}" target="_blank">
                    <button type="button" id="deal-card-5-bill1-download" class="mb-2 btn btn-sm btn-file mr-2"><i class="fas fa-file-download text-primary mr-2"></i><span class="text-primary border-primary">Скачать</span></button>
                </a>
                <button onclick="sendDealBill({{$deal_bill_file_item['deal_file_id']}},{{$deal_bill_file_item['deal_file_deal_id']}})" type="button" id="deal-card-5-bill1-send" class="mb-2 btn btn-sm btn-file mr-2"><i class="fas fa-share text-primary mr-2"></i><span class="text-primary border-primary">Отправить</span></button>
                <button onclick="deleteDealBill({{$deal_bill_file_item['deal_file_id']}},{{$deal_bill_file_item['deal_file_deal_id']}})" type="button" id="deal-card-5-bill1-send" class="mb-2 btn btn-sm btn-file mr-2"><i class="fas fa-times text-danger mr-2"></i><span class="text-danger border-danger">Удалить</span></button>
                <span style="font-size: 12px;margin-left: 5px;line-height: 1.2;color: green;text-align: center;position: relative;top: -2px;" class="send-deal-bill-result-span{{$deal_bill_file_item['deal_file_id']}}"></span>
            </div>
        </div>
    @endforeach
@endif