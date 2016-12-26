<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order_item extends Model
{

    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'count',
        'order_id'
    ];

    public function order()
    {
        return $this->belongsTo('App\Models\Order');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product')->with('translations');
    }

    public function getItemSum(){
        return $this->count * $this->product->price;
    }

}
