@if(@count($region_list) > 0)
    @foreach($region_list as $key => $region_item)
        <option value="{{$region_item['region_id']}}" class="region-option">{{$region_item['region_name']}}</option>
    @endforeach
@endif