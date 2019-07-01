@if(@count($deal_kp_file_list) > 0)
    @foreach($deal_kp_file_list as $key => $deal_kp_file_item)
        <div class="d-flex flex-wrap no-gutters align-items-center justify-content-between">
            <div class="col-12">
                <p class="deal-card-5-bill-name">{{$deal_kp_file_item['deal_file_name']}}</p>
                <p class="deal-card-5-bill-date">
                    {{$deal_kp_file_item['region_name']}}, {{$deal_kp_file_item['station_name']}},
                    {{$deal_kp_file_item['mark_name']}}, {{$deal_kp_file_item['brand_name']}},
                    {{$deal_kp_file_item['fraction_name']}}, {{$deal_kp_file_item['deal_file_deal_volume']}} тонн, {{$deal_kp_file_item['deal_file_deal_kp_sum']}} тг.
                </p>
                <p class="deal-card-5-bill-date">{{$deal_kp_file_item['deal_file_date_format']}}</p>
                <a href="/deal_files/{{$deal_kp_file_item['deal_file_src']}}" target="_blank">
                    <button type="button" class="mb-2 btn btn-sm btn-file mr-3"><i class="fas fa-file-download text-primary mr-2"></i><span class="text-primary border-primary">Скачать</span></button>
                </a>
                <button onclick="deleteDealKpFile({{$deal_kp_file_item['deal_file_id']}},{{$deal_kp_file_item['deal_file_deal_id']}})" type="button" id="deal-card-5-bill1-send" class="mb-2 btn btn-sm btn-file mr-3"><i class="fas fa-times text-danger mr-2"></i><span class="text-danger border-danger">Удалить</span></button>
            </div>
        </div>
    @endforeach
@endif