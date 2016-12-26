<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Order;
use App\Models\Order_item;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use FlashMessages;

class OrderController extends FrontendController
{
    public function store(Request $request){
        //dd($request->all());
        $input = $request->all();
        $input_item = request('item');
        DB::beginTransaction();
        try{
            $model = new Order($input);
            $model->save();
            $item = new Order_item($input_item);
            $model->order_items()->save($item);
            DB::commit();
            return view('product.confirm');
        }
        catch(ModelNotFoundException $e){
            return view('product.error');
        }
    }
}
