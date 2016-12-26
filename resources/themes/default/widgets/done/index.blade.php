@foreach($dones as $done)
    <div class="block_work clearfix">
        <div class="work_text1 clearfix">{!! $done->value !!}</div>
        <h3 class="work_text2 clearfix">{!! $done->content !!}</h3>
    </div>
@endforeach