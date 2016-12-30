@foreach($list as $product)
    <div class="wrapper_tovar">
        <div class="price"><p>{!! $product->price !!} <span>@lang('labels.grn')</span></p></div>
        <div class="text-center">
            <a class="img_tovar"><img src="{!! $product->image !!}"></a></div>
        <div class="title_tovar">{!! $product->n !!}</div>

        <div class="wrap_hover_tovar" data-id="{!! $product->id !!}">
            <div class="price"><p>{!! $product->price !!} <span>@lang('labels.grn')</span></p></div>
            <div class="text-center"><a class="img_tovar"><img src="{!! $product->image !!}"></a></div>
            <div class="title_tovar">{!! $product->n !!}</div>
            <div class="wrap_opus">
                <div class="line ">
                    <div class="clearfix">
                        <div class="left_text_opus">@lang('labels.category')</div>
                        <div class="right_text_opus">{!! $product->getCategoryName() ? $product->getCategoryName() : trans('labels.no') !!}</div>
                    </div>
                </div>
                <div class="line ">
                    <div class="left_text_opus">@lang('labels.product_class')</div>
                    <div class="right_text_opus">{!! $product->class ? $product->class : trans('labels.no') !!}</div>
                </div>
                <div class="line">
                    <div class="left_text_opus">@lang('labels.volume')</div>
                    <div class="right_text_opus">{!! $product->volume !!} @lang('labels.ml')</div>
                </div>
                <div class="line">
                    <div class="left_text_opus">@lang('labels.manufacturer')</div>
                    <div class="right_text_opus">{!! $product->manufacturer ? $product->manufacturer : trans('labels.no') !!}</div>
                </div>
                <a  class="btn_hover_tovar go" data-id="{!! $product->id !!}"><div>@lang('labels.help_as_action')</div></a>
                <div class="border_for_a"> <a class="btn_about_tovar go1 clearfix" data-id="{!! $product->id !!}">@lang('labels.detailed')</a>
                </div>
            </div>
        </div>

    </div>
@endforeach