@if(@count($fraction_list) > 0)
    @foreach($fraction_list as $key => $fraction_item)
        <option value="{{$fraction_item['fraction_id']}}" class="fraction-option">{{$fraction_item['fraction_name']}}</option>
    @endforeach
@endif