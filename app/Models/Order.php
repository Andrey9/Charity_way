<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{

    protected $fillable = [
        'comment',
        'status'
    ];

    public function order_items()
    {
        return $this->hasMany('App\Models\Order_item');
    }

    public function getOrderSum(){
        $sum = 0;
        $items = $this->order_items;
        /*dd($items);*/
        foreach ($items as $item){
            $sum += $item->getItemSum();
        }
        return $sum;
    }

}