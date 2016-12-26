<style media="all">
    .find_products {
        margin-bottom: 10px;
    }
    .product-find-list {
        display: none;
        background-color: #e1e4e9;
        border: 1px solid black;
        border-radius: 5px;
        position: absolute;
        top: 30px;
        left: 0;
        right: 0;
        z-index: 1000;
    }
    .product-find-list ul {
        list-style: none;
        padding: 0;
    }
    .product-find-list ul li{
        display: block;
        border-bottom: 1px solid black;
        padding: 10px 10px;
    }
    .product-find-list ul li:last-child {
        border-bottom: none;
    }
    .add-current-product-to-list {
        max-width: 18px;
    }
</style>
<div class="box-body table-responsive no-padding">
    <div class="col-md-12" style="position: relative">
        <input class="form-control input-sm find_products" placeholder="{!! trans('labels.product_search') !!}" data-token="{!! csrf_token() !!}" type="text" />
        <div class="product-find-list"></div>
    </div>
    <table class="table table-hover duplication">
        <tbody class="order-products-list">
        <tr class="table-head">
            <th>{!! trans('labels.product') !!}</th>
            <th>{!! trans('labels.volume') !!}</th>
            <th>{!! trans('labels.price') !!}</th>
            <th>{!! trans('labels.sum') !!}</th>
            <th>{!! trans('labels.count') !!}</th>
            <th>{!! trans('labels.delete') !!}</th>
        </tr>
        <tr class="duplication-row"></tr>
        @if (count($model->order_items))
            @foreach($model->order_items as $item)
                <tr class="duplication-row">
                    <td>
                        <div class="form-group required @if ($errors->has('items.old.' .$item->id. '.name')) has-error @endif">
                            {!! Form::text('items[old][' .$item->id. '][name]', $item->product->name, ['id' => 'items.old.' .$item->id. '.name', 'readonly' =>true ,  'class' => 'form-control input-sm', 'aria-hidden' => 'true', 'required' => true, 'data-token' => csrf_token()]) !!}
                            {!! Form::hidden('product_id', $item['product_id'],['data-check' => 'product_id']) !!}
                        </div>
                    </td>
                    <td>
                        <div class="form-group required @if ($errors->has('items.old.' .$item->id. '.count')) has-error @endif">
                            {!! Form::text(null, $item->product->volume, ['readonly' =>true ,'class' => 'form-control input-sm']) !!}
                        </div>
                    </td>
                    <td>
                        <div class="form-group required @if ($errors->has('items.old.' .$item->id. '.count')) has-error @endif">
                            {!! Form::text('',$item->product->price, ['readonly' =>true ,'class' => 'form-control input-sm check']) !!}
                        </div>
                    </td>
                    <td>
                        <div class="form-group required @if ($errors->has('items.old.' .$item->id. '.count')) has-error @endif">
                            {!! Form::text('product_sum', $item->getItemSum(), ['readonly' =>true ,'class' => 'form-control input-sm']) !!}
                        </div>
                    </td>
                    <td>
                        <div class="form-group required @if ($errors->has('items.old.' .$item->id. '.count')) has-error @endif">
                            {!! Form::number('items[old][' .$item->id. '][count]', $item->count, ['id' => 'items.old.' .$item->id. '.count', 'required' => true, 'class' => 'form-control input-sm count']) !!}
                        </div>
                    </td>
                    <td class="coll-actions">
                        <a class="btn btn-flat btn-danger btn-xs action exist destroy" data-id="{!! $item->id !!}" data-name="items[remove][]"><i class="fa fa-remove"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif

        {{--@if (count(old('items.new')))
            @foreach(old('items.new') as $item_key => $item)
                @if ($item_key !== 'replaseme')
                    <tr class="duplication-row order-items-list">
                        <td>
                            <div class="form-group required">
                                {!! Form::text('items[new]['.$item_key.'][name]', $item['name'], ['class' => 'input-sm form-control','readonly' =>true ]) !!}
                                {!! Form::hidden('items[new]['.$item_key.'][product_id]', $item['product_id']) !!}
                            </div>
                        </td>
                        <td>
                            <div class="form-group required @if ($errors->has('items.new.' .$item_key. '.position')) has-error @endif">
                                {!! Form::text('items[new][' .$item_key. '][count]', $item['count'], ['id' => 'items.new.' .$item_key. '.count', 'class' => 'form-control input-sm']) !!}
                            </div>
                        </td>
                        <td class="coll-actions">
                            <a class="btn btn-flat btn-danger btn-xs action destroy"><i class="fa fa-remove"></i></a>
                        </td>
                    </tr>
                @endif
            @endforeach
        @endif--}}

{{--        <tr class="duplication-button">
            <td colspan="6" class="text-center">
                <a title="@lang('labels.add_one_more')" class="btn btn-flat btn-primary btn-sm action create"><i class="glyphicon glyphicon-plus"></i></a>
            </td>
        </tr>

        <tr class="duplication-row duplicate">
            <td>
                <div class="form-group required">
                    <select class="form-control select2 input-sm" data-required="required" data-name="items[new][replaseme][product_id]">
                        @foreach ($products as $id => $value)
                            <option @if ($id === '') selected="selected" @endif value="{!! $id !!}">{!! $value !!}</option>
                        @endforeach
                    </select>
                </div>
            </td>
            <td>
                <div class="form-group required">
                    <input data-name="items[new][replaseme][count]" value="0" data-required="required" class="form-control input-sm">
                </div>
            </td>
            <td class="coll-actions">
                <a class="btn btn-flat btn-danger btn-xs action destroy"><i class="fa fa-remove"></i></a>
            </td>
        </tr>--}}

        </tbody>
    </table>
    <div class="col-md-12">
        <h3>@lang('labels.total'): {!! $model->getOrderSum() !!}@lang('labels.grn')</h3>
    </div>
</div>