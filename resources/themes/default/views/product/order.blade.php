<span id="modal_close"><img src="{!! asset('assets/themes/default/img/close.png') !!}"></span>
{!! Form::open(['role' => 'form', 'route' => 'order.index', 'class' => 'form-horizontal', 'id' => 'order-product']) !!}
    <h3 class="zakaz">Заказ продукции</h3>
    <h3 class="name_tovar">{!! $product->n !!}</h3>
    <div class="wraper_zakaz_tovar">
        <div class="min_tovar clearfix">
            <div class="min_wrapper_tovar clearfix">
                <div class="smal_price"><p><i>{!! $product->price !!}</i> <span>@lang('labels.grn')</span></p></div>

                <p class="min_img_tovar"><img src="{!! $product->image !!}"></p>
            </div>
            <div class="form_zakaz clearfix">
                <div class="line_zakaz">
                    <h3 class="caption1_form">@lang('labels.count'):</h3>
                    <div class="group-input">
                        {!! Form::hidden('item[product_id]', $product->id) !!}
                        <div class="number-max"></div>
                        {!! Form::number('item[count]', 1) !!}
                        <div class="number-min"></div>
                    </div>
                </div>
                <div class="line_zakaz">
                    <div class="caption1_form1">@lang('labels.total'):</div>
                    <div class="price_text"><i class="order_sum_price">{!! $product->price !!}</i> <span>@lang('labels.grn')</span></div>
                </div>
                <p class="o_dostavke">@lang('front_messages.about_delivery')</p>
                {!! Form::textarea('comment',null, ['class' => 'opus_dastavku', 'placeholder' => trans('front_messages.order_tarea_text'), 'required' => true]) !!}
                {!! Form::submit(trans('labels.pay'),['class' => 'oplata']) !!}
            </div>
        </div>
    </div>
{!! Form::close() !!}
