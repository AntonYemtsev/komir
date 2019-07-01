@if(@count($station_list) > 0)
    @foreach($station_list as $key => $station_item)
        <option value="{{$station_item['station_id']}}" class="station-option">{{$station_item['station_name']}}</option>
    @endforeach
@endif