@if(@count($mark_list) > 0)
    @foreach($mark_list as $key => $mark_item)
        <option value="{{$mark_item['mark_id']}}" class="mark-option">{{$mark_item['mark_name']}}</option>
    @endforeach
@endif