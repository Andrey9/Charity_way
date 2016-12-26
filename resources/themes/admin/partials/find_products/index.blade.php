@if(count($products) > 0)
    <ul>
    @foreach($products as $product)
        <li class="col-md-12">
            <a title="@lang('labels.add_product')" class="col-md-1 add-current-product-to-list label create-label bg-blue" data-id="{!! $product->id !!}" data-token="{!! csrf_token() !!}">
                <i class="glyphicon glyphicon-plus"></i>
            </a>
            <span class="col-md-1">
                {!! $product->id !!}
            </span>
            <span class="col-md-6">
                {!! $product->name !!}
            </span>
            <span class="col-md-2">
                {!! $product->volume !!} @lang('labels.ml')
            </span>
            <span class="col-md-2">
                {!! $product->price !!} @lang('labels.grn')
            </span>
        </li>
    @endforeach
    </ul>
@else
    <h4 class="col-md-12">No results found...</h4>
@endif