{{--<tr class="duplication-row">
    <td>
        <div class="form-group required">
            {!! Form::text('', $product->name, ['class' => 'input-sm form-control','readonly' =>true, 'data-name' => 'items[new][replaseme][name]' ]) !!}
            {!! Form::hidden(null, $product->id, ['data-name' => 'items[new][replaseme][product_id]']) !!}
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

<tr class="duplication-row {{--duplicate--}}">
    <td>
        <div class="form-group">
            {!! Form::text('', $product->name, ['class' => 'input-sm form-control','readonly' =>true ]) !!}
            {!! Form::hidden('items[new][' . $pos . '][product_id]', $product->id, ['data-name' => 'items[new][' . $pos . '][product_id]','data-check' => 'product_id']) !!}
        </div>
    </td>
    <td>
        <div class="form-group required">
            {!! Form::text(null, $product->volume, ['readonly' =>true ,'class' => 'form-control input-sm']) !!}
        </div>
    </td>
    <td>
        <div class="form-group required">
            {!! Form::text(null, $product->price, ['readonly' =>true ,'class' => 'form-control input-sm']) !!}
        </div>
    </td>
    <td>
        <div class="form-group required">
            {!! Form::text('product_sum', 0, ['readonly' =>true ,'class' => 'form-control input-sm']) !!}
        </div>
    </td>
    <td>
        <div class="form-group required">
            <input type="number" name="items[new][{!! $pos !!}][count]" data-name="items[new][{!! $pos !!}][count]" value="0" data-required="required" class="form-control input-sm">
        </div>
    </td>
    <td class="coll-actions">
        <a class="btn btn-flat btn-danger btn-xs action destroy"><i class="fa fa-remove"></i></a>
    </td>
</tr>