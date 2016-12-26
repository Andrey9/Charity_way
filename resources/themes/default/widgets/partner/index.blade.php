@foreach($list as $partner)
<a href="{!! $partner->link !!}" class="text_partner" title="{!! $partner->t !!}">
    <div style=" background-image: url({!! $partner->image !!})" class="text_partner1"></div>
</a>
@endforeach