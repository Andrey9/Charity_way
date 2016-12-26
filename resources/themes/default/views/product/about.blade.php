<span id="modal_close1"><img src="{!! asset('assets/themes/default/img/close.png') !!}"></span>
<h3 class="zakaz1">информация о товаре</h3>
<h3 class="name_tovar1">{!! $product->n !!}</h3>

<div class="min_tovar1 clearfix">
    <div class="min_wrapper_tovar1 clearfix">
        <div class="smal_price1"><p>{!! $product->price !!} <span>@lang('labels.grn')</span></p></div>
        <p class="min_img_tovar1"><img src="{!! $product->image !!}"></p>
    </div>
    <div id="opus_tovaru">
        {!! $product->desc !!}
    </div>
    <button class="oplata1" data-id="{!! $product->id !!}">@lang('labels.help_as_action')</button>
</div>