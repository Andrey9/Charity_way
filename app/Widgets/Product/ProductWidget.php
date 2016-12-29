<?php

namespace App\Widgets\Product;

use App\Models\Product;
use Pingpong\Widget\Widget;

class ProductWidget extends Widget
{
    protected $view = 'default';

    public function index()
    {

        $list = Product::withTranslations()->joinTranslations('products')->positionSorted()->visible()->with('category')
            ->select(
                'products.id',
                'product_translations.name as n',
                'product_translations.description as desc',
                'category_id',
                'price',
                'volume',
                'image',
                'manufacturer',
                'class'
            )
            ->limit(6)
            ->get();

        return view('views.product._products')->with('list', $list)->render();

    }
}