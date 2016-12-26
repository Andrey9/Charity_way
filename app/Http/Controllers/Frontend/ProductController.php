<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Product;
use Illuminate\Http\Request;

use App\Http\Requests;

class ProductController extends FrontendController
{
    public $module = 'product';

    public function show(Request $request)
    {
        $_id = $request->input('id');
        $product = Product::withTranslations()->joinTranslations('products')
            ->select(
                'products.id',
                'product_translations.name as n',
                'product_translations.description as desc',
                'price',
                'image'
            )
            ->find($_id);
        if ($request->path() == 'about_product'){
            return view('product.about', compact('product'))->render();
        }
        else {
            return view('product.order', compact('product'))->render();
        }

    }

    public function show_more(Request $request){
        $offset = $request->input('offset');
        $list = Product::withTranslations()->joinTranslations('products')->positionSorted()->visible()
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
            ->limit(3)
            ->offset($offset)
            ->get();
        return view('product._products', compact('list'))->render();
    }
}
